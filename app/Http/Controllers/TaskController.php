<?php

namespace App\Http\Controllers;

use App\Models\OrderProof;
use App\Models\Review;
use App\Models\Task;
use App\Models\User;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Helper untuk mendapatkan mahasiswa aktif saat ini (simulasi session).
     */
    private function getCurrentUser()
    {
        $userId = session('current_user_id', 1); // default Sendy Pratama
        return User::find($userId) ?? User::first();
    }

    /**
     * Campus Task Feed & Beranda Utama.
     */
    public function index(Request $request)
    {
        $currentUser = $this->getCurrentUser();
        $allUsers = User::where('role', 'mahasiswa')->get();

        $query = Task::with(['requester', 'runner', 'proof', 'reviews']);

        // Filter status tab (default: feed tugas yang butuh runner / open)
        $tab = $request->get('tab', 'feed');
        if ($tab === 'feed') {
            $query->where('status', 'open');
        } elseif ($tab === 'in_progress') {
            $query->whereIn('status', ['taken', 'in_progress', 'delivered']);
        } elseif ($tab === 'my_tasks') {
            $query->where(function ($q) use ($currentUser) {
                $q->where('requester_id', $currentUser->id)
                  ->orWhere('runner_id', $currentUser->id);
            });
        } elseif ($tab === 'completed') {
            $query->where('status', 'completed');
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search Titik Kampus atau Judul Tugas
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('pickup_location', 'like', "%{$search}%")
                  ->orWhere('dropoff_location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $tasks = $query->latest()->get();

        // Statistik Kampus
        $stats = [
            'open_tasks' => Task::where('status', 'open')->count(),
            'active_tasks' => Task::whereIn('status', ['taken', 'in_progress', 'delivered'])->count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'total_runners' => User::where('role', 'mahasiswa')->count(),
            'total_tips_paid' => (float) WalletTransaction::where('type', 'credit')->sum('amount'),
        ];

        // Riwayat Transaksi Dompet User Aktif
        $walletHistory = WalletTransaction::where('user_id', $currentUser->id)
            ->latest()
            ->take(5)
            ->get();

        return view('tasks.index', compact('tasks', 'stats', 'currentUser', 'allUsers', 'tab', 'walletHistory'));
    }

    /**
     * Requester membuat pesanan / task baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:print_dokumen,titip_makanan,ambil_barang,lainnya',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'item_price' => 'nullable|numeric|min:0',
            'tip_amount' => 'required|numeric|min:2000',
            'description' => 'nullable|string',
        ]);

        $currentUser = $this->getCurrentUser();

        Task::create([
            'requester_id' => $currentUser->id,
            'title' => $request->title,
            'category' => $request->category,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'item_price' => $request->item_price ?? 0,
            'tip_amount' => $request->tip_amount,
            'description' => $request->description,
            'status' => 'open',
        ]);

        return redirect()->route('tasks.index', ['tab' => 'feed'])
            ->with('success', 'Order tugas berhasil diposting ke Campus Task Feed!');
    }

    /**
     * Runner mengambil order (Claim).
     */
    public function claim(Task $task)
    {
        $currentUser = $this->getCurrentUser();

        // Validasi tidak bisa ambil tugas buatan sendiri
        if ($task->requester_id === $currentUser->id) {
            return back()->with('error', 'Kamu tidak bisa mengambil tugas yang kamu buat sendiri!');
        }

        if ($task->status !== 'open') {
            return back()->with('error', 'Tugas ini sudah diambil oleh mahasiswa lain.');
        }

        $task->update([
            'runner_id' => $currentUser->id,
            'status' => 'in_progress',
            'taken_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Tugas berhasil kamu ambil! Segera koordinasikan penjemputan dan pengantaran.');
    }

    /**
     * Runner mengunggah bukti selesai (Foto/Nota) -> status DELIVERED.
     */
    public function submitProof(Request $request, Task $task)
    {
        $currentUser = $this->getCurrentUser();

        if ($task->runner_id !== $currentUser->id) {
            return back()->with('error', 'Hanya Runner bertugas yang dapat mengirimkan bukti.');
        }

        $request->validate([
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = 'proofs/sample_proof.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('proofs', 'public');
        }

        OrderProof::updateOrCreate(
            ['task_id' => $task->id],
            [
                'runner_id' => $currentUser->id,
                'image_path' => $imagePath,
                'notes' => $request->notes ?? 'Tugas telah selesai diantar sesuai instruksi.',
            ]
        );

        $task->update([
            'status' => 'delivered',
            'delivered_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Bukti pengerjaan berhasil diunggah! Menunggu konfirmasi dari Requester.');
    }

    /**
     * Requester mengonfirmasi selesai -> status COMPLETED + DB::transaction untuk mutasi saldo.
     */
    public function confirmComplete(Request $request, Task $task)
    {
        $currentUser = $this->getCurrentUser();

        if ($task->requester_id !== $currentUser->id) {
            return back()->with('error', 'Hanya Requester pembuat tugas yang dapat mengonfirmasi selesai.');
        }

        if (! in_array($task->status, ['in_progress', 'delivered'])) {
            return back()->with('error', 'Status tugas belum memenuhi syarat untuk diselesaikan.');
        }

        // DATABASE TRANSACTION: Update status + Tambah saldo runner + Catat transaksi
        DB::transaction(function () use ($task, $request, $currentUser) {
            // 1. Update task ke completed
            $task->update([
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ]);

            // 2. Tambahkan saldo dompet runner
            $runner = User::find($task->runner_id);
            if ($runner) {
                $runner->increment('wallet_balance', $task->tip_amount);

                // 3. Catat mutasi wallet kredit
                WalletTransaction::create([
                    'user_id' => $runner->id,
                    'task_id' => $task->id,
                    'type' => 'credit',
                    'amount' => $task->tip_amount,
                    'description' => "Penerimaan Tip Runner: Task #{$task->id} ({$task->title})",
                ]);
            }

            // 4. Catat ulasan jika ada rating
            if ($request->filled('rating') && $task->runner_id) {
                Review::updateOrCreate(
                    [
                        'task_id' => $task->id,
                        'reviewer_id' => $currentUser->id,
                    ],
                    [
                        'reviewee_id' => $task->runner_id,
                        'rating' => $request->rating,
                        'comment' => $request->comment ?? 'Sangat membantu dan terpercaya!',
                    ]
                );
            }
        });

        return back()->with('success', 'Tugas selesai! Ongkos jasa Rp ' . number_format($task->tip_amount, 0, ',', '.') . ' telah masuk ke dompet Runner.');
    }

    /**
     * Helper untuk simulasi ganti akun mahasiswa (mudahkan testing / presentasi dosen).
     */
    public function switchUser(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        session(['current_user_id' => $request->user_id]);

        $user = User::find($request->user_id);
        return back()->with('success', "Akun aktif dialihkan ke: {$user->name} ({$user->nim})");
    }
}
