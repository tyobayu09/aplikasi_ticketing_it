<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Helpdesk OneMed & JMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#162A4A] min-h-screen flex items-center justify-center p-4 font-sans relative">

    <a href="{{ url('/') }}"
        class="absolute top-6 left-4 md:top-8 md:left-8 flex items-center gap-2 text-white/70 hover:text-white hover:bg-white/10 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 z-20 border border-transparent hover:border-white/20">
        <i class="fa-solid fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali ke Halaman Utama</span>
        <span class="sm:hidden">Kembali</span>
    </a>

    <div class="w-full max-w-md bg-white rounded-[2rem] shadow-2xl overflow-hidden z-10 p-8 sm:p-10 mt-12 sm:mt-0">

        <div class="flex justify-center items-center gap-5 mb-8">
            <img src="{{ asset('images/onemed-logo.png') }}" alt="OneMed" class="h-10 w-auto object-contain">
            <div class="h-8 w-px bg-gray-300 rounded-full"></div>
            <img src="{{ asset('images/logo-jmi.png') }}" alt="JMI" class="h-10 w-auto object-contain">
        </div>

        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-[#162A4A]">Login Admin IT</h2>
            <p class="text-gray-500 text-sm mt-2 font-medium">Silakan masuk untuk mengelola tiket bantuan.</p>
        </div>

        @if ($errors->any())
            <div
                class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex items-start gap-3 text-red-600 text-sm font-medium">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <div>Email atau password yang Anda masukkan salah.</div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="admin@onemed.co.id"
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EA580C] focus:border-transparent outline-none bg-gray-50 text-gray-700 font-medium transition-all shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#EA580C] focus:border-transparent outline-none bg-gray-50 text-gray-700 font-medium transition-all shadow-sm">
                </div>
            </div>

            <div class="flex items-center justify-between pt-1 mb-2">
                <label class="flex items-center text-sm font-medium text-gray-600 cursor-pointer group">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-[#EA580C] focus:ring-[#EA580C] transition-colors cursor-pointer">
                    <span class="ml-2 group-hover:text-[#162A4A] transition-colors">Ingat Saya</span>
                </label>
            </div>

            <button type="submit"
                class="w-full bg-[#EA580C] hover:bg-[#c94908] text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-[#EA580C]/30 flex justify-center items-center gap-2 group mt-4 uppercase tracking-wider">
                LOGIN
                <i class="fa-solid fa-arrow-right-to-bracket group-hover:translate-x-1 transition-transform"></i>
            </button>
        </form>
    </div>

</body>

</html>