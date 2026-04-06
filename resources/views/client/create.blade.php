<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tiket - Helpdesk OneMed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#20B2AA' } } }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen pt-10 pb-20 font-sans text-gray-800">

    <div class="max-w-2xl mx-auto px-4">

        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-primary mb-6 font-medium transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>

        @if(session('ticket_success'))

            <div
                class="bg-white p-8 md:p-12 rounded-3xl shadow-lg border border-green-100 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-2 bg-green-500"></div>

                <div
                    class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-sm">
                    <i class="fa-solid fa-check"></i>
                </div>

                <h2 class="text-3xl font-extrabold text-gray-800 mb-2">Tiket Berhasil Dibuat!</h2>
                <p class="text-gray-500 mb-8 font-medium">Mohon simpan nomor referensi ini untuk melacak status tiket Anda:
                </p>

                <div
                    class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-8 flex flex-col items-center justify-center mb-8">
                    <span id="ticket-number"
                        class="text-4xl font-mono font-bold text-primary mb-6 tracking-widest drop-shadow-sm">{{ session('ticket_success') }}</span>

                    <button onclick="copyTicket(this)"
                        class="bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-bold py-3 px-8 rounded-xl shadow-sm transition-all flex items-center gap-2 text-lg group">
                        <i class="fa-regular fa-copy group-hover:scale-110 transition-transform"></i> Salin Nomor Tiket
                    </button>
                </div>

                <a href="{{ route('ticket.create') }}"
                    class="text-gray-400 hover:text-primary font-bold underline decoration-2 underline-offset-4 transition-colors">
                    <i class="fa-solid fa-plus mr-1"></i> Buat Pengaduan Lain
                </a>
            </div>

            <script>
                function copyTicket(btn) {
                    // Ambil teks nomor tiket
                    const ticketNum = document.getElementById('ticket-number').innerText;

                    // Salin ke Clipboard perangkat pengguna
                    navigator.clipboard.writeText(ticketNum).then(() => {
                        const originalHtml = btn.innerHTML;

                        // Ubah tombol jadi warna hijau dan ganti teksnya
                        btn.innerHTML = '<i class="fa-solid fa-check-double"></i> Berhasil Disalin!';
                        btn.classList.replace('bg-white', 'bg-green-500');
                        btn.classList.replace('text-primary', 'text-white');
                        btn.classList.replace('border-primary', 'border-green-500');
                        btn.classList.remove('hover:bg-primary', 'hover:text-white');

                        // Kembalikan tombol ke bentuk semula setelah 3 detik
                        setTimeout(() => {
                            btn.innerHTML = originalHtml;
                            btn.classList.replace('bg-green-500', 'bg-white');
                            btn.classList.replace('text-white', 'text-primary');
                            btn.classList.replace('border-green-500', 'border-primary');
                            btn.classList.add('hover:bg-primary', 'hover:text-white');
                        }, 3000);

                    }).catch(err => {
                        alert('Gagal menyalin. Silakan blok dan copy manual.');
                    });
                }
            </script>

        @else

            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-800 mb-8"><i class="fa-solid fa-ticket text-primary mr-2"></i> Buat
                    Tiket Pengaduan</h2>

                <form action="{{ route('client.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Perusahaan / Pabrik</label>
                        <select name="location" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50 font-semibold text-gray-700 cursor-pointer">
                            <option value="" disabled selected>-- Pilih Lokasi Pabrik Anda --</option>
                            <option value="JMI Krian, Sidoarjo">PT JMI - Krian, Sidoarjo</option>
                            <option value="Mojoagung, Jombang">PT JMI - Mojoagung, Jombang</option>
                            <option value="Batang, Jawa Tengah">PT JMI - Batang, Jawa Tengah</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="requester_name" required placeholder="Misal: Budi Santoso"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Divisi / Departemen</label>
                            <input type="text" name="divisi" required placeholder="Misal: HRD / Keuangan"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label>
                            <input type="text" name="no_wa" required placeholder="Misal: 08123456789"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jelaskan Kendala Anda</label>
                        <textarea name="subject" required rows="4"
                            placeholder="Misal: Printer di ruangan HRD tidak bisa digunakan..."
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50"></textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-4 bg-primary text-white rounded-xl hover:bg-teal-600 font-bold text-lg transition-all shadow-md mt-4 flex justify-center items-center gap-2">
                        <i class="fa-regular fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                </form>
            </div>

        @endif

    </div>
</body>

</html>