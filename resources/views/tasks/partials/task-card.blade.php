<div class="task-card">
    <!-- Header: Kategori & Status Badge -->
    <div class="task-card-header">
        <span class="category-tag {{ $task->category_class }}">
            <i class="fa-solid {{ $task->category_icon }}"></i> {{ $task->category_label }}
        </span>
        <span class="status-badge st-{{ $task->status }}">
            {{ strtoupper(str_replace('_', ' ', $task->status)) }}
        </span>
    </div>

    <!-- Judul & Deskripsi Tugas -->
    <h3 class="task-title">{{ $task->title }}</h3>
    @if ($task->description)
        <p class="task-desc">{{ $task->description }}</p>
    @endif

    <!-- Rute: Pickup & Dropoff -->
    <div class="route-box">
        <div class="route-point">
            <span class="route-icon" style="color: #ef4444;"><i class="fa-solid fa-circle-dot"></i></span>
            <div>
                <span style="font-size: 0.7rem; color: #64748b;">TITIK JEMPUT:</span><br>
                <strong>{{ $task->pickup_location }}</strong>
            </div>
        </div>
        <div class="route-point">
            <span class="route-icon" style="color: #10b981;"><i class="fa-solid fa-location-dot"></i></span>
            <div>
                <span style="font-size: 0.7rem; color: #64748b;">TITIK ANTAR:</span><br>
                <strong>{{ $task->dropoff_location }}</strong>
            </div>
        </div>
    </div>

    <!-- Mahasiswa Pembuat (Requester) & Pelaksana (Runner) -->
    <div class="task-users">
        <div class="user-info-row">
            <div class="user-avatar-mini">{{ substr($task->requester->name, 0, 1) }}</div>
            <div>
                <div style="font-weight: 700; color: #1e293b;">{{ $task->requester->name }}</div>
                <div style="font-size: 0.7rem;">Requester (NIM: {{ $task->requester->nim }})</div>
            </div>
        </div>

        @if ($task->runner)
            <div class="user-info-row" style="text-align: right;">
                <div>
                    <div style="font-weight: 700; color: #059669;">{{ $task->runner->name }}</div>
                    <div style="font-size: 0.7rem;">Runner Terpilih</div>
                </div>
                <div class="user-avatar-mini" style="background:#d1fae5; color:#059669;">
                    {{ substr($task->runner->name, 0, 1) }}
                </div>
            </div>
        @endif
    </div>

    <!-- Footer: Nominal Tip & Tombol Aksi -->
    <div class="task-card-footer">
        <div class="tip-box">
            <span class="tip-label">Ongkos Tip Runner</span>
            <span class="tip-val">+ Rp {{ number_format($task->tip_amount, 0, ',', '.') }}</span>
            @if ($task->item_price > 0)
                <span class="bailout-val">Talangan: Rp {{ number_format($task->item_price, 0, ',', '.') }}</span>
            @endif
        </div>

        <!-- Tombol Aksi Dinamis Sesuai Status & User -->
        <div>
            @if ($task->status === 'open')
                @if (Auth::id() !== $task->requester_id)
                    <form action="{{ route('tasks.claim', $task->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-hand-holding-dollar"></i> Ambil Order
                        </button>
                    </form>
                @else
                    <span style="font-size: 0.8rem; color: #64748b; font-style: italic;">
                        <i class="fa-solid fa-clock"></i> Tugas buatanmu
                    </span>
                @endif

            @elseif (in_array($task->status, ['taken', 'in_progress']))
                @if (Auth::id() === $task->runner_id)
                    <button class="btn btn-primary" onclick="openProofModal('{{ $task->id }}', '{{ addslashes($task->title) }}')">
                        <i class="fa-solid fa-camera"></i> Kirim Bukti
                    </button>
                @else
                    <span style="font-size: 0.8rem; color: #b45309; font-weight: 600;">
                        <i class="fa-solid fa-person-running"></i> Sedang dikerjakan
                    </span>
                @endif

            @elseif ($task->status === 'delivered')
                @if (Auth::id() === $task->requester_id)
                    <button class="btn btn-success" onclick="openCompleteModal('{{ $task->id }}', '{{ addslashes($task->title) }}', '{{ $task->tip_amount }}', '{{ addslashes($task->runner->name ?? 'Runner') }}')">
                        <i class="fa-solid fa-circle-check"></i> Konfirmasi Selesai
                    </button>
                @elseif (Auth::id() === $task->runner_id)
                    <span style="font-size: 0.8rem; color: #4338ca; font-weight: 600;">
                        <i class="fa-solid fa-hourglass-half"></i> Menunggu Konfirmasi
                    </span>
                @endif

            @elseif ($task->status === 'completed')
                <div style="font-size: 0.8rem; color: #059669; font-weight: 700;">
                    <i class="fa-solid fa-check-double"></i> Tip Sudah Cair
                    @if ($task->reviews->isNotEmpty())
                        <span style="color: #f59e0b; margin-left: 6px;">★ {{ $task->reviews->first()->rating }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
