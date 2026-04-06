<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Tiket - Helpdesk OneMed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#20B2AA' } } }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen pt-10 pb-20 font-sans text-gray-800">

    <div class="max-w-3xl mx-auto px-4">

        <a href="{{ url('/') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-primary mb-8 font-medium transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-8 text-center">
            <div
                class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center text-3xl mx-auto mb-4 shadow-sm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Lacak Status Pengaduan</h1>
            <p class="text-gray-500 mb-8">Masukkan nomor referensi tiket Anda (Contoh: TKT-X8F9A) untuk melihat
                perkembangan penanganan.</p>

            <form action="{{ route('ticket.search') }}" method="POST"
                class="max-w-lg mx-auto flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="ticket_number" value="{{ request('ticket_number') }}" required
                    placeholder="Ketik Nomor Tiket..."
                    class="flex-1 px-5 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50 font-mono font-bold text-lg text-center sm:text-left text-gray-700 uppercase"
                    autocomplete="off">
                <button type="submit"
                    class="bg-primary text-white hover:bg-teal-600 font-bold py-3.5 px-8 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    Cari <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>

        @if(isset($searched))
            @if($ticket)
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">

                    @php
                        $statusColor = match ($ticket->status) {
                            'New' => 'bg-green-500',
                            'Open' => 'bg-blue-500',
                            'Resolved' => 'bg-gray-500',
                            default => 'bg-yellow-500'
                        };
                        $statusBg = match ($ticket->status) {
                            'New' => 'bg-green-50 text-green-700 border-green-200',
                            'Open' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'Resolved' => 'bg-gray-50 text-gray-700 border-gray-200',
                            default => 'bg-yellow-50 text-yellow-700 border-yellow-200'
                        };
                    @endphp
                    <div class="absolute top-0 left-0 right-0 h-2 {{ $statusColor }}"></div>

                    <div class="p-8 md:p-10">
                        <div
                            class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                            <div class="text-center md:text-left">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Tiket</p>
                                <div class="flex items-center flex-col md:flex-row gap-3">
                                    <h2 id="ticket-number"
                                        class="text-3xl font-mono font-extrabold text-gray-800 tracking-wider">
                                        {{ $ticket->ticket_number }}</h2>
                                    <button onclick="copyTicket(this)"
                                        class="text-primary hover:bg-primary/10 bg-gray-50 border border-gray-200 p-2 rounded-lg transition-colors"
                                        title="Salin Nomor">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="px-6 py-2.5 rounded-full text-sm font-extrabold border shadow-sm uppercase tracking-wider {{ $statusBg }}">
                                Status: {{ $ticket->status }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Dibuat
                                    </p>
                                    <p class="font-bold text-gray-700"><i class="fa-regular fa-calendar text-gray-400 mr-2"></i>
                                        {{ $ticket->created_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pelapor &
                                        Lokasi</p>
                                    <p class="font-bold text-gray-700"><i class="fa-regular fa-user text-gray-400 mr-2"></i>
                                        {{ $ticket->requester_name }} ({{ $ticket->divisi }})</p>
                                    <p class="text-sm text-gray-500 mt-1"><i
                                            class="fa-solid fa-location-dot text-red-400 mr-2"></i> {{ $ticket->location }}</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Teknisi
                                        Bertugas</p>
                                    @if($ticket->assigned_to)
                                        <p class="font-bold text-gray-800"><i class="fa-solid fa-user-gear text-primary mr-2"></i>
                                            {{ $ticket->assigned_to }}</p>
                                    @else
                                        <p class="font-bold text-red-500 italic"><i
                                                class="fa-solid fa-triangle-exclamation mr-1"></i> Menunggu Teknisi</p>
                                    @endif
                                </div>

                                @if($ticket->started_at && $ticket->finished_at)
                                    <div class="pt-3 border-t border-gray-200">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Waktu
                                            Pengerjaan</p>
                                        <p class="font-bold text-green-600"><i class="fa-solid fa-stopwatch mr-2"></i>
                                            {{ $ticket->started_at->diffForHumans($ticket->finished_at, true) }}</p>
                                    </div>
                                @elseif($ticket->started_at)
                                    <div class="pt-3 border-t border-gray-200">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Mulai
                                            Dikerjakan</p>
                                        <p class="font-bold text-blue-600"><i class="fa-solid fa-spinner fa-spin mr-2"></i>
                                            {{ $ticket->started_at->format('H:i') }} WIB</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2">Detail Kendala</p>
                            <div
                                class="bg-gray-50/80 p-5 rounded-xl border border-gray-100 text-gray-700 leading-relaxed shadow-inner">
                                {{ $ticket->subject }}
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="bg-red-50 border border-red-200 p-8 rounded-3xl text-center shadow-sm">
                    <div
                        class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                    <h3 class="text-xl font-bold text-red-800 mb-2">Tiket Tidak Ditemukan!</h3>
                    <p class="text-red-600">Kami tidak dapat menemukan tiket dengan nomor referensi
                        <strong>"{{ request('ticket_number') }}"</strong>. Silakan periksa kembali nomor tiket Anda.</p>
                </div>
            @endif
        @endif

    </div>

    <script>
        function copyTicket(btn) {
            const ticketNum = document.getElementById('ticket-number').innerText;
            navigator.clipboard.writeText(ticketNum).then(() => {
                const originalHtml = btn.innerHTML;

                // Ubah icon jadi centang hijau
                btn.innerHTML = '<i class="fa-solid fa-check text-green-500"></i>';
                btn.classList.add('border-green-500', 'bg-green-50');

                // Kembalikan ke semula setelah 2 detik
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('border-green-500', 'bg-green-50');
                }, 2000);
            }).catch(err => {
                alert('Browser Anda tidak mendukung fitur salin otomatis.');
            });
        }
    </script>
</body>

</html>