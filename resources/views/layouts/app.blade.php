<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#20B2AA', bgLight: '#F8FAFC' } } }
        }
    </script>
</head>

<body class="bg-bgLight h-screen w-full flex overflow-hidden font-sans text-gray-700">

    @include('components.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">

        @include('components.navbar')

        <main class="flex-1 overflow-y-auto p-6 md:p-8 w-full">
            @yield('content')
        </main>

    </div>
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3"></div>

    <script>
        // 1. Minta Izin (Permission) dari Browser saat halaman pertama dimuat
        document.addEventListener('DOMContentLoaded', function () {
            if ("Notification" in window) {
                if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                    Notification.requestPermission();
                }
            }
        });

        // Simpan memori jumlah tiket saat ini
        let currentNewTickets = {{ \App\Models\Ticket::where('status', 'New')->count() ?? 0 }};

        // Menggunakan suara notifikasi klasik iPhone (Tri-tone)
        let notifyAudio = new Audio('https://www.myinstants.com/media/sounds/iphone-notification.mp3');

        // Fungsi untuk memunculkan Notifikasi Desktop Windows/Mac
        function showNativeNotification(title, bodyText) {
            // Cek apakah browser mendukung notifikasi
            if (!("Notification" in window)) {
                console.log("Browser tidak mendukung notifikasi desktop.");
                return;
            }

            // Jika izin sudah diberikan oleh Admin
            if (Notification.permission === "granted") {
                let notification = new Notification(title, {
                    body: bodyText,
                    icon: '{{ asset("images/onemed-logo.png") }}', // Memakai logo OneMed Anda sebagai ikon WA-nya
                    silent: true // Kita matikan suara bawaan Windows, karena kita pakai suara kita sendiri
                });

                // Jika notifikasinya diklik, akan otomatis membuka/fokus ke tab Dashboard Admin
                notification.onclick = function () {
                    window.focus();
                    this.close();
                };
            }
            // Jika belum ada izin, minta izin lagi
            else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    if (permission === "granted") {
                        let notification = new Notification(title, {
                            body: bodyText,
                            icon: '{{ asset("images/onemed-logo.png") }}',
                            silent: true
                        });
                    }
                });
            }
        }

        // Fungsi mengecek tiket baru secara berkala (AJAX Polling)
        setInterval(() => {
            fetch('{{ route("admin.tickets.check") }}')
                .then(res => res.json())
                .then(data => {
                    // Update angka di lonceng navbar
                    const badge = document.getElementById('notification-badge');
                    if (badge) {
                        badge.innerText = data.count > 99 ? '99+' : data.count;
                        badge.style.display = data.count > 0 ? 'flex' : 'none';
                    }

                    // Jika ada tiket baru masuk
                    if (data.count > currentNewTickets) {

                        // 1. Putar Suara
                        notifyAudio.play().catch(e => console.log("Audio diblokir browser."));

                        // 2. Munculkan Notifikasi ala WhatsApp
                        showNativeNotification(
                            'Tiket Baru: ' + data.latest_ticket,
                            `Dari: ${data.requester}\nSilakan cek dashboard IT Support untuk detail kendala.`
                        );

                        // 3. Perbarui memori
                        currentNewTickets = data.count;

                        // 4. (Opsional) Refresh tabel otomatis jika sedang buka dashboard
                        if (window.location.pathname.includes('/dashboard')) {
                            setTimeout(() => { window.location.reload(); }, 2000);
                        }
                    }
                    else if (data.count < currentNewTickets) {
                        currentNewTickets = data.count;
                    }
                })
                .catch(err => console.error(err));
        }, 10000); // Cek setiap 10 detik
    </script>

</body>

</html>