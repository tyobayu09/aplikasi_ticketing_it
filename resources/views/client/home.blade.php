<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk IT Support - OneMed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        btnRed: '#E14D4D',
                        btnRedHover: '#C93C3C'
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Konfigurasi Background Image Utama */
        .bg-hero-image {
            background-color: #003b6d;
            background-image: url('{{ asset('images/hero-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Lapisan Gelap Transparan agar Teks Putih Terbaca Jelas */
        .hero-overlay {
            background: linear-gradient(to right, rgba(0, 15, 40, 0.85) 0%, rgba(0, 15, 40, 0.4) 100%);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
    </style>
</head>

<body class="bg-gray-900 min-h-screen flex flex-col font-sans overflow-x-hidden">

    <header
        class="absolute top-0 left-0 right-0 w-full py-6 px-6 md:px-12 lg:px-20 flex justify-between items-center z-30">

        <div class="bg-white px-5 py-3 rounded-2xl shadow-lg inline-flex items-center gap-4 mb-8 md:mb-0">
            <img src="{{ asset('images/onemed-logo.png') }}" alt="OneMed Health Care"
                class="h-10 md:h-12 w-auto object-contain">

            <div class="h-8 w-px bg-gray-200"></div>

            <img src="{{ asset('images/logo-jmi.png') }}" alt="JMI Logo" class="h-10 md:h-12 w-auto object-contain">
        </div>

        <a href="{{ route('login') }}"
            class="text-sm md:text-base font-bold text-white hover:text-yellow-300 transition-all flex items-center gap-3 bg-white/10 hover:bg-white/25 border border-white/30 px-5 py-2.5 md:px-7 md:py-3 rounded-full backdrop-blur-md shadow-sm">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span class="hidden sm:inline">Login Admin</span>
        </a>
    </header>

    <main class="flex-1 relative bg-hero-image min-h-screen flex items-center">

        <div class="hero-overlay z-10"></div>

        <div class="container mx-auto px-6 md:px-12 lg:px-20 relative z-20 pt-24 pb-16">

            <div class="max-w-3xl text-left text-white">

                <h1
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 tracking-tight leading-tight drop-shadow-lg">
                    Selamat Datang di <br>
                    <span class="text-yellow-400">Layanan Helpdesk</span>
                </h1>

                <p
                    class="text-base sm:text-lg md:text-xl text-gray-200 mb-10 max-w-2xl leading-relaxed font-medium drop-shadow-md">
                    Pusat layanan bantuan IT OneMed Health Care. Silakan buat tiket pengaduan baru jika mengalami
                    kendala, atau lacak status tiket Anda.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <a href="{{ route('ticket.create') }}"
                        class="group bg-btnRed hover:bg-btnRedHover text-white font-bold py-4 px-8 rounded-full shadow-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg w-full sm:w-auto">
                        <i class="fa-solid fa-ticket transition group-hover:rotate-12"></i>
                        Buat Tiket Baru
                    </a>

                    <a href="{{ route('ticket.track') }}"
                        class="group bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/40 font-bold py-4 px-8 rounded-full shadow-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg w-full sm:w-auto hover:border-white/70">
                        <i class="fa-solid fa-magnifying-glass transition group-hover:scale-110"></i>
                        Lacak Status
                    </a>
                </div>
            </div>

        </div>
    </main>

    <footer
        class="absolute bottom-0 w-full border-t border-white/10 py-4 text-center text-xs md:text-sm font-medium text-white/60 z-30 bg-black/20 backdrop-blur-sm">
        Copyright &copy; {{ date('Y') }} OneMed Health Care | IT Helpdesk
    </footer>

</body>

</html>