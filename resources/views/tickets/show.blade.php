@extends('layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.tickets.index') }}"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-white shadow-sm hover:bg-gray-50 text-gray-500 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tiket {{ $ticket->ticket_number }}</h1>
                    <p class="text-sm text-gray-500">Dibuat pada {{ $ticket->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            @php
                $statusColor = match ($ticket->status) {
                    'New' => 'bg-green-100 text-green-700 border-green-200',
                    'Open' => 'bg-blue-100 text-blue-700 border-blue-200',
                    'Resolved' => 'bg-gray-100 text-gray-700 border-gray-200',
                    default => 'bg-yellow-100 text-yellow-700 border-yellow-200'
                };
            @endphp
            <div class="px-5 py-2 rounded-full text-sm font-bold border shadow-sm {{ $statusColor }}">
                Status: {{ strtoupper($ticket->status) }}
            </div>
        </div>

        @if(session('success'))
            <div
                class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">

            <div class="lg:col-span-2 space-y-6 lg:space-y-8">

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center text-xl">
                            <i class="fa-regular fa-comment-dots"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Deskripsi Kendala</h2>
                            <p class="text-sm text-gray-500">Laporan keluhan dari klien</p>
                        </div>
                    </div>

                    <div
                        class="p-6 bg-gray-50/80 rounded-xl border border-gray-100 text-gray-800 text-base leading-relaxed whitespace-pre-line shadow-inner">
                        {{ $ticket->subject }}
                    </div>
                </div>

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3
                        class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5 pb-3 border-b border-gray-50 flex items-center gap-2">
                        <i class="fa-solid fa-stopwatch text-gray-300"></i> Status Pengerjaan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-500 mb-1.5 font-bold uppercase tracking-wide">Dikerjakan Oleh
                            </p>
                            @if($ticket->assigned_to)
                                <span class="font-bold text-gray-800 flex items-center gap-2"><i
                                        class="fa-solid fa-user-gear text-primary"></i> {{ $ticket->assigned_to }}</span>
                            @else
                                <span class="font-bold text-red-500 flex items-center gap-2"><i
                                        class="fa-solid fa-triangle-exclamation"></i> Belum ditugaskan</span>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-500 mb-1.5 font-bold uppercase tracking-wide">Waktu Mulai (Open)
                            </p>
                            <span class="font-bold text-gray-800 flex items-center gap-2"><i
                                    class="fa-regular fa-clock text-blue-500"></i>
                                {{ $ticket->started_at ? $ticket->started_at->format('d M Y, H:i') : '-' }}</span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <p class="text-[10px] text-gray-500 mb-1.5 font-bold uppercase tracking-wide">Waktu Selesai
                                (Resolved)</p>
                            <span class="font-bold text-gray-800 flex items-center gap-2"><i
                                    class="fa-solid fa-flag-checkered text-green-500"></i>
                                {{ $ticket->finished_at ? $ticket->finished_at->format('d M Y, H:i') : '-' }}</span>
                        </div>
                    </div>

                    @if($ticket->started_at && $ticket->finished_at)
                        <div
                            class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between bg-green-50/50 p-4 rounded-xl border-l-4 border-l-green-500">
                            <p class="text-sm text-gray-600 font-bold uppercase tracking-wider">Total Durasi Penanganan</p>
                            <span class="font-extrabold text-green-700 text-lg">
                                {{ $ticket->started_at->diffForHumans($ticket->finished_at, true) }}
                            </span>
                        </div>
                    @endif
                </div>

            </div>

            <div class="space-y-6 lg:space-y-8">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                    @php
                        $priorityColor = match ($ticket->priority) { 'Critical' => 'bg-red-500', 'High' => 'bg-pink-500', 'Medium' => 'bg-blue-500', default => 'bg-yellow-500'};
                    @endphp
                    <div class="absolute top-0 left-0 right-0 h-1 {{ $priorityColor }}"></div>

                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-5 pb-3 border-b border-gray-50">
                        Informasi Pelapor</h3>

                    <div class="space-y-5">
                        <div>
                            <p class="text-[10px] text-gray-500 mb-1 font-bold uppercase tracking-wide">Nomor Referensi</p>
                            <span
                                class="font-bold text-primary font-mono text-lg tracking-widest">{{ $ticket->ticket_number }}</span>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-500 mb-1 font-bold uppercase tracking-wide">Nama Pelapor</p>
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->requester_name) }}&background=F8FAFC&color=20B2AA"
                                    class="w-8 h-8 rounded-full border border-gray-200">
                                <span class="font-bold text-gray-800">{{ $ticket->requester_name }}</span>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-500 mb-1 font-bold uppercase tracking-wide">Divisi / Departemen
                            </p>
                            <span class="font-semibold text-gray-800 flex items-center gap-2"><i
                                    class="fa-regular fa-building text-gray-400"></i> {{ $ticket->divisi }}</span>
                        </div>

                        <div>
                            <p class="text-[10px] text-gray-500 mb-1 font-bold uppercase tracking-wide">No. WhatsApp</p>
                            @php
                                $waNumber = preg_replace('/[^0-9]/', '', $ticket->no_wa);
                                if (str_starts_with($waNumber, '0'))
                                    $waNumber = '62' . substr($waNumber, 1);
                            @endphp
                            <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                class="font-bold text-green-600 hover:text-green-700 flex items-center gap-2 transition-colors bg-green-50 px-3 py-1.5 rounded-lg w-fit border border-green-100">
                                <i class="fa-brands fa-whatsapp text-lg"></i> {{ $ticket->no_wa }}
                            </a>
                        </div>

                        <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide">Tingkat Prioritas</p>
                            <span
                                class="font-extrabold text-xs uppercase px-3 py-1.5 rounded-md shadow-sm border {{ $ticket->priority == 'Critical' ? 'text-red-700 bg-red-50 border-red-200' : ($ticket->priority == 'High' ? 'text-pink-700 bg-pink-50 border-pink-200' : ($ticket->priority == 'Medium' ? 'text-blue-700 bg-blue-50 border-blue-200' : 'text-yellow-700 bg-yellow-50 border-yellow-200')) }}">
                                {{ $ticket->priority }}
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl shadow-sm border border-primary/20 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary to-blue-400"></div>

                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-sliders text-primary"></i> Tugaskan & Update
                    </h3>

                    <form id="update-ticket-form" action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wide">Pilih Teknisi
                            IT:</label>
                        <select id="select-teknisi" name="assigned_to"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary mb-4 bg-white text-gray-700 font-bold shadow-sm cursor-pointer transition-colors hover:border-primary/50">
                            <option value="">-- Belum Ditugaskan --</option>
                            <option value="Tyo Bayu" {{ $ticket->assigned_to == 'Tyo Bayu' ? 'selected' : '' }}>Tyo Bayu (IT
                                Support)</option>
                            <option value="Pak Sigit" {{ $ticket->assigned_to == 'Pak Sigit' ? 'selected' : '' }}>Pak Sigit
                                (Infrastruktur)</option>
                            <option value="Teknisi IT 3" {{ $ticket->assigned_to == 'Teknisi IT 3' ? 'selected' : '' }}>
                                Teknisi IT 3</option>
                        </select>

                        <label class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wide">Ubah
                            Status:</label>
                        <select id="select-status" name="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary mb-6 bg-white text-gray-700 font-bold shadow-sm cursor-pointer transition-colors hover:border-primary/50">
                            <option value="New" {{ $ticket->status == 'New' ? 'selected' : '' }}>🟢 New</option>
                            <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>🔵 Open (Kerjakan)</option>
                            <option value="On-hold" {{ $ticket->status == 'On-hold' ? 'selected' : '' }}>🟡 On-hold (Tertunda)
                            </option>
                            <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>⚪ Resolved
                                (Selesai)</option>
                        </select>

                        <button type="button" onclick="confirmUpdate()"
                            class="w-full py-3.5 bg-gradient-to-r from-primary to-teal-500 text-white rounded-xl hover:from-teal-600 hover:to-primary font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function confirmUpdate() {
            // Ambil teks dari pilihan yang aktif di dropdown
            const teknisiSelect = document.getElementById('select-teknisi');
            const statusSelect = document.getElementById('select-status');

            const teknisiText = teknisiSelect.options[teknisiSelect.selectedIndex].text;
            const statusText = statusSelect.options[statusSelect.selectedIndex].text;
            const statusValue = statusSelect.value;

            // Peringatan jika diubah ke Open tapi teknisi kosong
            if (statusValue === 'Open' && teknisiSelect.value === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Teknisi Kosong!',
                    text: 'Anda harus memilih teknisi IT sebelum memulai (Open) pengerjaan tiket ini.',
                    confirmButtonColor: '#20B2AA',
                    customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md' }
                });
                return;
            }

            // Pop-up Konfirmasi Utama
            Swal.fire({
                title: 'Konfirmasi Perubahan',
                html: `Anda akan mengubah status menjadi <br><b class="text-blue-600 text-lg">${statusText}</b><br><br>dan menugaskan tiket kepada <br><b class="text-gray-800">${teknisiText}</b>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#20B2AA', // Warna teal (primary)
                cancelButtonColor: '#E14D4D', // Warna merah (batal)
                confirmButtonText: '<i class="fa-solid fa-check"></i> Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true, // Tombol simpan di kanan
                customClass: {
                    popup: 'rounded-2xl shadow-xl',
                    confirmButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md',
                    cancelButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan animasi loading agar admin tahu sedang diproses
                    Swal.fire({
                        title: 'Menyimpan Data...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    // Lanjutkan proses form (Submit ke controller)
                    document.getElementById('update-ticket-form').submit();
                }
            })
        }
    </script>
@endsection