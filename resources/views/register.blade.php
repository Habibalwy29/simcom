@extends('layouts.app')

@section('title', 'Buat Akun Baru')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden my-8">
        {{-- Bagian Kiri (Background Teal) - Bisa dibuat komponen terpisah jika ingin --}}
        <div class="w-1/2 bg-teal-600 flex-col items-center justify-center p-12 text-white hidden md:flex">
            <img src="{{ asset('images/logo_sim_putih.png') }}" alt="SIM.com Logo" class="h-28 w-auto mb-6" onerror="this.onerror=null;this.src='https://placehold.co/150x50/FFFFFF/4DB6AC?text=SIM';this.style.height='50px';" />
            <h2 class="text-3xl font-bold mb-2 text-center">Bergabunglah Sekarang!</h2>
            <h1 class="text-4xl font-extrabold mb-4 text-center">SIM.COM</h1>
            <p class="text-md text-center leading-relaxed">Daftar dan mulailah perjalanan Anda menuju gaya hidup yang lebih sehat dan terukur.</p>
        </div>

        {{-- Bagian Kanan (Form Register) --}}
        <div class="w-full md:w-1/2 p-8 sm:p-10 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4 text-center">
                Buat Akun Baru
            </h2>

            <p class="text-center text-gray-600 mb-6 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-700 hover:underline font-semibold">
                    Masuk di sini
                </a>
            </p>

            @if(session('status'))
                <div class="mb-4 p-3 rounded-lg text-center bg-green-100 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any()) {{-- Menampilkan semua error validasi --}}
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">
                     <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="reg_name" class="block text-gray-700 text-sm font-semibold mb-1">Nama Lengkap</label>
                    <input
                        type="text"
                        id="reg_name"
                        name="name"
                        class="w-full px-4 py-2.5 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 text-sm"
                        placeholder="Masukkan Nama Lengkap Anda"
                        value="{{ old('name') }}"
                        required
                    />
                    @error('name')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="reg_email" class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                    <input
                        type="email"
                        id="reg_email"
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
                    <label for="reg_password" class="block text-gray-700 text-sm font-semibold mb-1">Kata Sandi</label>
                    <input
                        type="password"
                        id="reg_password"
                        name="password"
                        class="w-full px-4 py-2.5 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 text-sm"
                        placeholder="Minimal 8 karakter"
                        required
                    />
                     @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="reg_password_confirmation" class="block text-gray-700 text-sm font-semibold mb-1">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="reg_password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200 text-sm"
                        placeholder="Ulangi kata sandi"
                        required
                    />
                    {{-- Error untuk password_confirmation biasanya terkait dengan rule 'confirmed' pada 'password' --}}
                </div>
                <button
                    type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-md">
                    Daftar Akun Baru
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