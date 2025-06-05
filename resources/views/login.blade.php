@extends('layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden my-8">
        {{-- Bagian Kiri (Background Teal) --}}
        <div class="w-1/2 bg-teal-600 flex-col items-center justify-center p-12 text-white hidden md:flex">
            <img src="{{ asset('images/logo_sim_putih.png') }}" alt="SIM.com Logo" class="h-28 w-auto mb-6" onerror="this.onerror=null;this.src='https://placehold.co/150x50/FFFFFF/4DB6AC?text=SIM';this.style.height='50px';" />
            <h2 class="text-3xl font-bold mb-2 text-center">Selamat Datang Kembali!</h2>
            <h1 class="text-4xl font-extrabold mb-4 text-center">SIM.COM</h1>
            <p class="text-md text-center leading-relaxed">Platform kesehatan Anda untuk mencapai tujuan hidup sehat. Sehat Itu Mahal, tapi investasi terbaik!</p>
        </div>

        {{-- Bagian Kanan (Form Login) --}}
        <div class="w-full md:w-1/2 p-8 sm:p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">
                Masuk ke Akun Anda
            </h2>

            <p class="text-center text-gray-600 mb-6 text-sm">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-700 hover:underline font-semibold">
                    Daftar Sekarang
                </a>
            </p>

            @if(session('status'))
                <div class="mb-4 p-3 rounded-lg text-center bg-green-100 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any()) {{-- Menampilkan semua error validasi (termasuk dari error bag 'login' jika ada) --}}
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full px-4 py-2.5 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 text-sm"
                        placeholder="cth: email@example.com"
                        value="{{ old('email') }}"
                        required
                    />
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-1">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2.5 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 text-sm"
                        placeholder="Masukkan password"
                        required
                    />
                    @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me_login" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <label for="remember_me_login" class="ml-2 block text-xs text-gray-700">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-xs">
                        <a href="{{ route('password.request') }}" class="text-teal-600 hover:text-teal-700 hover:underline font-semibold">Lupa Password?</a>
                    </div>
                </div>
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-md">
                    Masuk
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <a href="{{ route('landing') }}" class="text-teal-600 hover:text-teal-700 hover:underline font-semibold">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection