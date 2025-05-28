<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM.com - @yield('title', 'Kesehatan Optimal')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Anda akan mengganti ini dengan kompilasi Tailwind CSS lokal Anda di proyek Laravel (misalnya via Vite/Laravel Mix) --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <style>
        
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800">

    {{-- Header --}}
    <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center fixed w-full top-0 z-50 rounded-b-xl">
        <div class="flex items-center">
            <img src="{{ asset('images/sehat.png') }}" alt="SIM.com Logo" class="h-10 w-10 rounded-full mr-2" />
            <span class="text-2xl font-bold text-teal-600">SIM.com</span>
        </div>
        <nav class="hidden md:flex space-x-6 text-gray-700 font-semibold">
            <a href="{{ route('landing') }}" class="hover:text-teal-600 transition-colors duration-200">About</a>
            <a href="{{ route('landing') }}#article-section" class="hover:text-teal-600 transition-colors duration-200">Article</a>
            <a href="#" class="hover:text-teal-600 transition-colors duration-200">Recommendation</a>
            <a href="#" class="hover:text-teal-600 transition-colors duration-200">Our Product</a>
            <a href="#" class="hover:text-teal-600 transition-colors duration-200">History</a>
        </nav>
        <div class="flex items-center space-x-4">
            @auth {{-- Jika pengguna sudah login --}}
                <a href="{{ route('account') }}" class="flex items-center text-gray-700 hover:text-teal-600 transition-colors duration-200">
                    {{-- Ikon pengguna dari Lucide React tidak bisa langsung digunakan di Blade, perlu SVG inline atau pustaka ikon lain --}}
                    {{-- Di sini kita hanya menampilkan teks atau ikon placeholder sederhana --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="hidden sm:inline">{{ Auth::user()->name ?? 'Pengguna' }}</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-200">Keluar</button>
                </form>
            @else {{-- Jika pengguna belum login --}}
                <a href="{{ route('login') }}" class="flex items-center text-gray-700 hover:text-teal-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="17 17 22 12 17 7"/><line x1="22" x2="11" y1="12" y2="12"/></svg>
                    <span class="hidden sm:inline">Masuk</span>
                </a>
            @endauth
            {{-- Tombol menu mobile (icon 'Menu' atau 'X' dari Lucide React) --}}
            <button class="md:hidden text-gray-700 hover:text-teal-600" id="mobile-menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Mobile Menu (hidden by default, toggled by JS) --}}
        <div id="mobile-menu" class="absolute top-full left-0 w-full bg-white shadow-lg py-4 md:hidden rounded-b-xl hidden">
            <nav class="flex flex-col items-center space-y-4 text-gray-700 font-semibold">
                <a href="{{ route('landing') }}" class="hover:text-teal-600 transition-colors duration-200">About</a>
                <a href="{{ route('landing') }}#article-section" class="hover:text-teal-600 transition-colors duration-200">Article</a>
                <a href="#" class="hover:text-teal-600 transition-colors duration-200">Recommendation</a>
                <a href="#" class="hover:text-teal-600 transition-colors duration-200">Our Product</a>
                <a href="#" class="hover:text-teal-600 transition-colors duration-200">History</a>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-200">Keluar</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-grow pt-20 pb-10"> {{-- Sesuaikan padding berdasarkan tinggi header --}}
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white shadow-inner py-6 px-4 text-center text-gray-600 border-t border-teal-200 mt-12 rounded-t-xl">
        {{-- Mengubah justify-between menjadi justify-center di md:flex-row --}}
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-center items-center">
            <div class="mb-4 md:mb-0 md:mr-6"> {{-- Tambahkan margin kanan untuk spacing di desktop --}}
                <p class="text-lg font-bold text-teal-600">Www.Sim.Com</p>
                <p>© 2024 PT. Sehat Itu Mahal. All Rights Reserved.</p>
            </div>
            <div class="flex space-x-6">
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-teal-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.5" y1="6.5" y2="6.5"/></svg>
                </a>
            
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-teal-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-teal-600 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-youtube"><path d="M2.8 19.7c-.5-.9-.8-2-.8-3.1V7.3c0-1.1.3-2.2.8-3.1C3.3 3.4 4.5 3 6 3h12c1.5 0 2.7.4 3.2 1.2.5.9.8 2 .8 3.1v9.4c0 1.1-.3 2.2-.8 3.1-.5.9-1.7 1.2-3.2 1.2H6c-1.5 0-2.7-.4-3.2-1.2z"/><path d="m10 15 5-3-5-3v6z"/></svg>
                </a>
            </div>
        </div>
    </footer>

    {{-- Script untuk toggling menu mobile --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const userIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>`;
            const menuIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>`;
            const xIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>`;

            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                const isHidden = mobileMenu.classList.contains('hidden');
                mobileMenuButton.innerHTML = isHidden ? menuIconSvg : xIconSvg; // Toggle icon
            });
        });
    </script>
</body>
</html>