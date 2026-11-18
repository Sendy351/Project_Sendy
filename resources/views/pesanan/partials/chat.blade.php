{{--
    Chat in-app pemesan <-> runner, dengan kirim foto (buat ngasih tau posisi).
    Variabel: $pesanan, $isRunner, $isPemesan
--}}
@php
    $lawanNama = $isRunner ? $pesanan->pengguna->nama : $pesanan->penyedia->nama;
    $chatDitutup = $pesanan->status === 'dibatalkan';
@endphp

<style>
    .chat-card { padding: 0 !important; overflow: hidden; margin-bottom: 1.5rem; }
    .chat-head {
        display: flex; align-items: center; justify-content: space-between; gap: 10px;
        padding: 1rem 1.25rem; border-bottom: 1px solid var(--border);
    }
    .chat-body {
        height: 380px; overflow-y: auto; padding: 1rem;
        background: var(--bg-page); display: flex; flex-direction: column; gap: 8px;
        overscroll-behavior: contain;
    }
    .chat-state { margin: auto; text-align: center; color: var(--text-muted); font-size: 0.85rem; max-width: 300px; line-height: 1.5; }
    .chat-row { display: flex; }
    .chat-row.mine { justify-content: flex-end; }
    .chat-bubble {
        max-width: 78%; padding: 8px 12px; border-radius: 16px; font-size: 0.9rem; line-height: 1.45;
        background: #FFFFFF; border: 1px solid var(--border); color: var(--text-main);
        border-bottom-left-radius: 4px; word-wrap: break-word; overflow-wrap: anywhere; white-space: pre-wrap;
    }
    .chat-row.mine .chat-bubble {
        background: var(--primary); color: #FFFFFF; border-color: var(--primary);
        border-bottom-left-radius: 16px; border-bottom-right-radius: 4px;
    }
    .chat-bubble.has-photo { padding: 4px; }
    .chat-bubble.has-photo .chat-text { padding: 4px 8px 2px; }
    .chat-photo {
        display: block; width: 240px; max-width: 100%; aspect-ratio: 4 / 3; object-fit: cover;
        border-radius: 12px; cursor: zoom-in; background: var(--bg-subtle); border: none; padding: 0;
    }
    .chat-photo img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; display: block; }
    .chat-meta { font-size: 0.7rem; margin-top: 2px; opacity: 0.8; text-align: right; }
    .chat-bubble.has-photo .chat-meta { padding: 0 8px 2px; }
    .chat-row.pending .chat-bubble { opacity: 0.6; }
    .chat-row.failed .chat-bubble { background: var(--rose-light); color: var(--rose); border-color: #FECDD3; }

    .chat-preview {
        display: none; align-items: center; gap: 12px; padding: 10px 1rem;
        border-top: 1px solid var(--border); background: var(--primary-light);
    }
    .chat-preview.show { display: flex; }
    .chat-preview img { width: 64px; height: 64px; object-fit: cover; border-radius: 10px; border: 1px solid #BFDBFE; cursor: zoom-in; }

    .chat-compose { display: flex; align-items: flex-end; gap: 6px; padding: 10px; border-top: 1px solid var(--border); background: #FFFFFF; }
    .chat-icon-btn {
        width: 44px; height: 44px; border-radius: 12px; border: 1px solid var(--border); background: #FFFFFF;
        color: var(--text-secondary); font-size: 1.1rem; cursor: pointer; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .chat-icon-btn:hover { color: var(--primary); border-color: var(--primary); }
    .chat-send { background: var(--primary); color: #FFFFFF; border-color: var(--primary); }
    .chat-send:hover { color: #FFFFFF; background: var(--primary-hover); }
    .chat-send[disabled] { opacity: 0.5; cursor: not-allowed; }
    .chat-input {
        flex: 1; min-width: 0; resize: none; max-height: 120px; min-height: 44px;
        padding: 10px 12px; border: 1px solid var(--border); border-radius: 12px; font-size: 0.9rem;
        line-height: 1.4; outline: none; font-family: inherit;
    }
    .chat-error { display: none; padding: 8px 1rem; font-size: 0.8rem; color: var(--rose); background: var(--rose-light); border-top: 1px solid #FECDD3; }
    .chat-error.show { display: block; }

    .chat-loc {
        display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;
        padding: 4px 2px; min-width: 200px;
    }
    .chat-loc-icon {
        width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
        display: inline-flex; align-items: center; justify-content: center; font-size: 1.1rem;
        background: var(--rose-light); color: var(--rose);
    }
    .chat-row.mine .chat-loc-icon { background: rgba(255,255,255,0.2); color: #FFFFFF; }
    .chat-loc-title { font-weight: 700; font-size: 0.875rem; }
    .chat-loc-sub { font-size: 0.75rem; opacity: 0.85; text-decoration: underline; }
    .chat-icon-btn.is-busy { pointer-events: none; opacity: 0.6; }

    #modal-foto-chat img { max-width: 100%; max-height: 85vh; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

    @media (max-width: 380px) {
        .chat-icon-btn { width: 40px; height: 40px; }
        .chat-compose { gap: 4px; padding: 8px; }
    }

    @media (max-width: 540px) {
        .chat-body { height: 55vh; min-height: 300px; padding: 0.75rem; }
        .chat-bubble { max-width: 85%; }
        .chat-photo { width: 200px; }
        .chat-head { padding: 0.85rem 1rem; }
    }
</style>

<div class="card chat-card" id="chat">
    <div class="chat-head">
        <div style="min-width: 0;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: var(--text-main);">
                <i class="fa-solid fa-comments" style="color: var(--primary);"></i> Chat dengan {{ $isRunner ? 'Pemesan' : 'Runner' }}
            </h3>
            <div style="font-size: 0.8rem; color: var(--text-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                {{ $lawanNama }}
            </div>
        </div>
        <span id="chat-status" style="font-size: 0.75rem; color: var(--text-muted); white-space: nowrap;"></span>
    </div>

    <div class="chat-body" id="chat-body" aria-live="polite">
        <div class="chat-state" id="chat-loading">
            <i class="fa-solid fa-spinner fa-spin"></i> Memuat pesan...
        </div>
    </div>

    <div class="chat-error" id="chat-error" role="alert"></div>

    @if($chatDitutup)
        <div style="padding: 0.85rem 1rem; font-size: 0.85rem; color: var(--text-muted); border-top: 1px solid var(--border); text-align: center;">
            <i class="fa-solid fa-lock"></i> Pesanan dibatalkan, chat ditutup.
        </div>
    @else
        <!-- Preview foto sebelum dikirim -->
        <div class="chat-preview" id="chat-preview">
            <img id="chat-preview-img" alt="Preview foto yang akan dikirim" onclick="chatOpenLightbox(this.src)">
            <div style="flex: 1; min-width: 0;">
                <div style="font-size: 0.85rem; font-weight: 700; color: var(--text-main);">Foto siap dikirim</div>
                <div id="chat-preview-info" style="font-size: 0.75rem; color: var(--text-secondary);"></div>
                <div style="font-size: 0.75rem; color: var(--text-muted);">Tambahin keterangan di kolom pesan (opsional).</div>
            </div>
            <button type="button" class="modal-close" onclick="chatClearPhoto()" aria-label="Batalkan foto">&times;</button>
        </div>

        <form class="chat-compose" id="chat-form" data-no-loading onsubmit="chatSend(event)">
            {{-- Kamera: langsung buka kamera belakang di HP --}}
            <input type="file" id="chat-file-camera" accept="image/*" capture="environment" hidden onchange="chatPickPhoto(this)">
            {{-- Galeri: pilih dari foto yang sudah ada --}}
            <input type="file" id="chat-file-gallery" accept="image/jpeg,image/png,image/webp,image/heic,image/heif" hidden onchange="chatPickPhoto(this)">

            <button type="button" class="chat-icon-btn" onclick="document.getElementById('chat-file-camera').click()" title="Ambil foto pakai kamera" aria-label="Ambil foto pakai kamera">
                <i class="fa-solid fa-camera"></i>
            </button>
            <button type="button" class="chat-icon-btn" onclick="document.getElementById('chat-file-gallery').click()" title="Pilih foto dari galeri" aria-label="Pilih foto dari galeri">
                <i class="fa-regular fa-image"></i>
            </button>

            {{-- Kirim Lokasi: ambil GPS HP lalu kirim sebagai link Google Maps (disimpan di kolom isi, tanpa kolom baru) --}}
            <button type="button" class="chat-icon-btn" id="chat-loc-btn" onclick="chatSendLocation()" title="Kirim lokasi saya (Google Maps)" aria-label="Kirim lokasi saya">
                <i class="fa-solid fa-location-crosshairs"></i>
            </button>

            <textarea id="chat-input" class="chat-input" rows="1" maxlength="2000" aria-label="Tulis pesan"
                placeholder="{{ $isPemesan ? 'Tulis pesan, mis. aku di depan lift lt. 2…' : 'Tulis pesan ke pemesan…' }}"
                onkeydown="chatKeydown(event)" oninput="chatAutoGrow(this)"></textarea>

            <button type="submit" class="chat-icon-btn chat-send" id="chat-send" aria-label="Kirim">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    @endif
</div>

<!-- Lightbox foto (Esc / klik luar buat nutup, ditangani global di layout) -->
<div id="modal-foto-chat" role="dialog" aria-modal="true" aria-label="Foto chat ukuran penuh"
     style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.9); z-index: 1100; align-items: center; justify-content: center; padding: 1rem;">
    <button type="button" class="modal-close" onclick="document.getElementById('modal-foto-chat').style.display='none'" aria-label="Tutup"
            style="position: absolute; top: 12px; right: 12px; background: rgba(255,255,255,0.15); color: #FFFFFF;">&times;</button>
    <img id="modal-foto-chat-img" alt="Foto chat" onclick="document.getElementById('modal-foto-chat').style.display='none'">
</div>

<script>
(function () {
    const CHAT_URL = @json(route('chat.index', $pesanan->id));
    const SEND_URL = @json(route('chat.store', $pesanan->id));
    const CSRF = @json(csrf_token());
    const MAX_SIDE = 1600;          // px
    const JPEG_QUALITY = 0.8;
    const MAX_INPUT_BYTES = 20 * 1024 * 1024; // tolak file > 20 MB sebelum diproses
    const POLL_MS = 4000;

    const body = document.getElementById('chat-body');
    const errBox = document.getElementById('chat-error');
    const statusEl = document.getElementById('chat-status');
    let lastId = 0;
    let loaded = false;
    let pendingBlob = null;
    let previewUrl = null;
    let sending = false;
    let pollTimer = null;

    function fmtSize(b) { return b > 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.round(b / 1024) + ' KB'; }

    function showError(msg) {
        errBox.textContent = msg;
        errBox.classList.toggle('show', !!msg);
    }

    function nearBottom() { return body.scrollHeight - body.scrollTop - body.clientHeight < 80; }
    function scrollBottom() { body.scrollTop = body.scrollHeight; }

    function emptyState() {
        const d = document.createElement('div');
        d.className = 'chat-state';
        d.id = 'chat-empty';
        d.innerHTML = '<i class="fa-regular fa-comments" style="font-size: 1.6rem; display: block; margin-bottom: 6px;"></i>';
        d.append(@json($isPemesan
            ? 'Belum ada pesan. Kirim foto tempat kamu nunggu biar runner gampang nemuin kamu.'
            : 'Belum ada pesan. Sapa pemesan atau minta foto lokasinya.'));
        return d;
    }

    // Bangun bubble pakai DOM + textContent (aman dari XSS)
    function bubble(m, opts = {}) {
        const row = document.createElement('div');
        row.className = 'chat-row' + (m.milik_saya ? ' mine' : '') + (opts.pending ? ' pending' : '');
        if (m.id) row.dataset.id = m.id;

        const b = document.createElement('div');
        b.className = 'chat-bubble' + (m.foto_url ? ' has-photo' : '');

        if (m.foto_url) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'chat-photo';
            btn.setAttribute('aria-label', 'Lihat foto ukuran penuh');
            const img = document.createElement('img');
            img.src = m.foto_url;
            img.alt = 'Foto dari ' + (m.pengirim || 'pengguna');
            img.loading = 'lazy';
            img.onload = function () { if (opts.stick) scrollBottom(); };
            btn.appendChild(img);
            btn.onclick = function () { window.chatOpenLightbox(m.foto_url); };
            b.appendChild(btn);
        }
        const loc = m.isi ? parseLocation(m.isi) : null;
        if (loc) {
            const a = document.createElement('a');
            a.className = 'chat-loc';
            a.href = loc.url;
            a.target = '_blank';
            a.rel = 'noopener noreferrer';
            a.innerHTML = '<span class="chat-loc-icon"><i class="fa-solid fa-location-dot"></i></span>';
            const txt = document.createElement('span');
            const t1 = document.createElement('div'); t1.className = 'chat-loc-title';
            t1.textContent = m.milik_saya ? 'Lokasi saya' : 'Lokasi ' + (m.pengirim || '').split(' ')[0];
            const t2 = document.createElement('div'); t2.className = 'chat-loc-sub';
            t2.textContent = 'Buka di Google Maps' + (loc.akurasi ? ' · ±' + loc.akurasi + ' m' : '');
            txt.append(t1, t2);
            a.appendChild(txt);
            b.appendChild(a);
        } else if (m.isi) {
            const t = document.createElement('div');
            t.className = 'chat-text';
            t.textContent = m.isi;
            b.appendChild(t);
        }
        const meta = document.createElement('div');
        meta.className = 'chat-meta';
        meta.textContent = opts.pending ? 'Mengirim…' : (m.waktu || '');
        b.appendChild(meta);

        row.appendChild(b);
        return row;
    }

    function append(list) {
        if (!list.length) return;
        const stick = nearBottom() || !loaded;
        document.getElementById('chat-empty')?.remove();
        list.forEach(function (m) {
            if (body.querySelector('.chat-row[data-id="' + m.id + '"]')) return;
            body.appendChild(bubble(m, { stick: stick }));
            lastId = Math.max(lastId, m.id);
        });
        if (stick) scrollBottom();
    }

    async function load() {
        try {
            const res = await fetch(CHAT_URL + (lastId ? '?after=' + lastId : ''), {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            if (!res.ok) throw new Error(res.status);
            const data = await res.json();
            document.getElementById('chat-loading')?.remove();
            if (!loaded && !data.pesan.length) body.appendChild(emptyState());
            append(data.pesan);
            loaded = true;
            statusEl.innerHTML = '<span class="pulse-dot" style="width:7px;height:7px;"></span> Terhubung';
            if (errBox.dataset.kind === 'load') { showError(''); errBox.dataset.kind = ''; }
        } catch (e) {
            statusEl.textContent = 'Offline';
            if (!loaded) {
                document.getElementById('chat-loading')?.remove();
                errBox.dataset.kind = 'load';
                showError('Gagal memuat chat. Cek koneksi — akan dicoba lagi otomatis.');
            }
        }
    }

    function startPolling() {
        clearInterval(pollTimer);
        pollTimer = setInterval(function () { if (!document.hidden) load(); }, POLL_MS);
    }
    document.addEventListener('visibilitychange', function () { if (!document.hidden) load(); });

    // ---------- Lokasi ----------
    // Format yang disimpan di kolom isi:  "📍 Lokasi saya: https://www.google.com/maps?q=LAT,LNG (akurasi ±N m)"
    // Hanya URL Google Maps dengan koordinat angka yang dirender jadi link (aman dari link sembarang).
    function parseLocation(isi) {
        const m = isi.match(/^📍 Lokasi saya: https:\/\/www\.google\.com\/maps\?q=(-?\d{1,2}\.\d+),(-?\d{1,3}\.\d+)(?: \(akurasi ±(\d+) m\))?$/u);
        if (!m) return null;
        return { url: 'https://www.google.com/maps?q=' + m[1] + ',' + m[2], akurasi: m[3] || null };
    }

    window.chatSendLocation = function () {
        if (sending) return;
        showError('');
        if (!('geolocation' in navigator)) {
            showError('Browser ini gak dukung GPS. Kirim foto lokasi aja ya.');
            return;
        }
        if (!window.isSecureContext) {
            showError('Lokasi cuma bisa diambil lewat HTTPS (atau localhost). Kirim foto lokasi aja dulu.');
            return;
        }
        const btn = document.getElementById('chat-loc-btn');
        btn.classList.add('is-busy');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        const reset = function () {
            btn.classList.remove('is-busy');
            btn.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i>';
        };

        navigator.geolocation.getCurrentPosition(function (pos) {
            reset();
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);
            const acc = Math.round(pos.coords.accuracy || 0);
            const doSend = function () {
                const text = '📍 Lokasi saya: https://www.google.com/maps?q=' + lat + ',' + lng + (acc ? ' (akurasi ±' + acc + ' m)' : '');
                postMessage(text, null, null);
            };
            // Konfirmasi dulu: lokasi itu data pribadi
            if (window.Swal) {
                Swal.fire({
                    title: 'Kirim lokasimu?',
                    html: 'Lokasi saat ini (akurasi ±' + acc + ' m) akan dikirim ke lawan chat sebagai link Google Maps.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim Lokasi',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#2563EB',
                    reverseButtons: true
                }).then(function (r) { if (r.isConfirmed) doSend(); });
            } else if (confirm('Kirim lokasimu ke lawan chat?')) {
                doSend();
            }
        }, function (err) {
            reset();
            const pesan = {
                1: 'Izin lokasi ditolak. Aktifkan izin lokasi untuk situs ini di pengaturan browser.',
                2: 'Lokasi gak ketemu. Pastikan GPS nyala, atau kirim foto lokasi aja.',
                3: 'Kelamaan nyari lokasi. Coba lagi di tempat yang sinyalnya bagus.'
            };
            showError(pesan[err.code] || 'Gagal mengambil lokasi.');
        }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 30000 });
    };

    // ---------- Foto: validasi, kompres, preview ----------
    async function decodeImage(file) {
        if ('createImageBitmap' in window) {
            try { return await createImageBitmap(file, { imageOrientation: 'from-image' }); } catch (e) { /* fallback */ }
        }
        return await new Promise(function (resolve, reject) {
            const url = URL.createObjectURL(file);
            const img = new Image();
            img.onload = function () { URL.revokeObjectURL(url); resolve(img); };
            img.onerror = function () { URL.revokeObjectURL(url); reject(new Error('decode')); };
            img.src = url;
        });
    }

    async function compress(file) {
        const img = await decodeImage(file);
        const w = img.width, h = img.height;
        const scale = Math.min(1, MAX_SIDE / Math.max(w, h));
        const canvas = document.createElement('canvas');
        canvas.width = Math.round(w * scale);
        canvas.height = Math.round(h * scale);
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        if (img.close) img.close();
        const blob = await new Promise(function (r) { canvas.toBlob(r, 'image/jpeg', JPEG_QUALITY); });
        if (!blob) throw new Error('encode');
        return { blob: blob, w: canvas.width, h: canvas.height };
    }

    window.chatPickPhoto = async function (input) {
        const file = input.files && input.files[0];
        input.value = ''; // biar bisa pilih file yang sama lagi
        if (!file) return;
        showError('');

        if (!file.type.startsWith('image/') && !/\.(jpe?g|png|webp|heic|heif)$/i.test(file.name)) {
            showError('Cuma bisa kirim file gambar (JPG, PNG, WEBP).');
            return;
        }
        if (file.size > MAX_INPUT_BYTES) {
            showError('Foto terlalu besar (' + fmtSize(file.size) + '). Maksimal 20 MB.');
            return;
        }

        const info = document.getElementById('chat-preview-info');
        document.getElementById('chat-preview').classList.add('show');
        info.textContent = 'Mengecilkan foto…';
        try {
            const out = await compress(file);
            pendingBlob = out.blob;
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(out.blob);
            document.getElementById('chat-preview-img').src = previewUrl;
            info.textContent = out.w + '×' + out.h + ' · ' + fmtSize(file.size) + ' → ' + fmtSize(out.blob.size);
            document.getElementById('chat-input').focus();
        } catch (e) {
            chatClearPhoto();
            showError('File ini gak bisa dibaca sebagai gambar. Coba foto lain.');
        }
    };

    window.chatClearPhoto = function () {
        pendingBlob = null;
        if (previewUrl) { URL.revokeObjectURL(previewUrl); previewUrl = null; }
        document.getElementById('chat-preview')?.classList.remove('show');
        const img = document.getElementById('chat-preview-img');
        if (img) img.removeAttribute('src');
    };

    window.chatOpenLightbox = function (src) {
        document.getElementById('modal-foto-chat-img').src = src;
        document.getElementById('modal-foto-chat').style.display = 'flex';
    };

    window.chatAutoGrow = function (el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    };

    window.chatKeydown = function (e) {
        // Enter = kirim di laptop; di HP (layar sentuh) Enter tetap baris baru
        if (e.key === 'Enter' && !e.shiftKey && !window.matchMedia('(pointer: coarse)').matches) {
            e.preventDefault();
            document.getElementById('chat-form').requestSubmit();
        }
    };

    // ---------- Kirim ----------
    window.chatSend = function (e) {
        e.preventDefault();
        if (sending) return;
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text && !pendingBlob) { input.focus(); return; }
        postMessage(text, pendingBlob, previewUrl, true);
    };

    function postMessage(text, blob, photoUrl, fromComposer) {
        const input = document.getElementById('chat-input');
        showError('');
        sending = true;
        const sendBtn = document.getElementById('chat-send');
        sendBtn.disabled = true;

        const fd = new FormData();
        fd.append('_token', CSRF);
        if (text) fd.append('isi', text);
        if (blob) fd.append('foto', blob, 'foto.jpg');

        // Bubble sementara biar langsung kerasa terkirim
        document.getElementById('chat-empty')?.remove();
        const temp = bubble({ milik_saya: true, isi: text, foto_url: photoUrl }, { pending: true });
        body.appendChild(temp);
        scrollBottom();
        const meta = temp.querySelector('.chat-meta');

        const xhr = new XMLHttpRequest();
        xhr.open('POST', SEND_URL);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.upload.onprogress = function (ev) {
            if (ev.lengthComputable && blob) meta.textContent = 'Mengirim… ' + Math.round(ev.loaded / ev.total * 100) + '%';
        };
        xhr.onload = function () {
            sending = false;
            sendBtn.disabled = false;
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch (err) {}
            if (xhr.status === 201 && data.pesan) {
                temp.remove();
                if (fromComposer) {
                    input.value = '';
                    chatAutoGrow(input);
                    chatClearPhoto();
                }
                append([data.pesan]);
                scrollBottom();
            } else {
                temp.classList.remove('pending');
                temp.classList.add('failed');
                meta.textContent = 'Gagal terkirim';
                const firstErr = data.errors ? Object.values(data.errors)[0][0] : null;
                showError(firstErr || data.message || (xhr.status === 419 ? 'Sesi habis, muat ulang halaman.' : 'Pesan gagal terkirim. Coba lagi.'));
                setTimeout(function () { temp.remove(); }, 4000);
            }
        };
        xhr.onerror = function () {
            sending = false;
            sendBtn.disabled = false;
            temp.classList.remove('pending');
            temp.classList.add('failed');
            meta.textContent = 'Gagal terkirim';
            showError('Koneksi putus. Pesan & foto masih ada, tinggal kirim ulang.');
            setTimeout(function () { temp.remove(); }, 4000);
        };
        xhr.send(fd);
    }

    load().then(startPolling);
})();
</script>
