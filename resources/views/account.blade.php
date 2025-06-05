@extends('layouts.app')

@section('title', 'Profil Akun Saya')

@section('content')
<div class="min-h-screen flex flex-col items-center p-4 bg-gray-50 text-gray-800">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-2xl mt-8 border border-gray-200">
        <h2 class="text-3xl font-bold text-center mb-8 flex items-center justify-center text-teal-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Profil Akun Saya
        </h2>

        @if(session('message'))
            <div class="mb-4 p-3 rounded-lg text-center @if(str_contains(strtolower(session('message')), 'gagal')) bg-red-100 text-red-700 @else bg-green-100 text-green-700 @endif">
                {{ session('message') }}
            </div>
        @endif
        {{-- Jika ada error validasi dari form updateProfile --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="flex flex-col items-center mb-6">
            <img src="{{ $profileData['profilePicture'] ?? asset('images/default-profile.png') }}" alt="Foto Profil {{ $user->name ?? 'Pengguna' }}"
                 class="w-32 h-32 rounded-full object-cover border-4 border-teal-500 shadow-lg mb-4"
                 onerror="this.onerror=null;this.src='https://placehold.co/100x100/CCCCCC/333333?text=Error';">
            <h3 class="text-2xl font-semibold text-gray-700">{{ $user->name ?? 'Nama Pengguna' }}</h3>
            <p class="text-gray-500">{{ $user->email ?? 'Email tidak tersedia' }}</p>
        </div>

        <form action="{{ route('updateProfile') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="fullName" id="fullName"
                       value="{{ old('fullName', $user->name ?? '') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                       required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email"
                       value="{{ $user->email ?? '' }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                       readonly disabled>
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah.</p>
            </div>

            <div>
                <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                <input type="tel" name="phoneNumber" id="phoneNumber"
                       value="{{ old('phoneNumber', $profileData['phoneNumber'] ?? '') }}"
                       placeholder="+62 8XX-XXXX-XXXX"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200">
            </div>

            <div>
                <label for="profilePictureUrl" class="block text-sm font-medium text-gray-700 mb-1">URL Foto Profil</label>
                <input type="url" name="profilePictureUrl" id="profilePictureUrl"
                       value="{{ old('profilePictureUrl', $profileData['profilePicture'] ?? '') }}"
                       placeholder="https://example.com/image.png"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200">
                 <p class="text-xs text-gray-500 mt-1">Gunakan URL yang valid untuk foto profil baru Anda.</p>
            </div>

            {{-- Anda bisa menambahkan input untuk ganti password di sini jika ada fungsionalitasnya --}}
            {{-- <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div> --}}

            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit"
                        class="text-red-500 hover:text-red-700 hover:underline font-semibold transition duration-150">
                    Keluar dari Akun
                </button>
            </form>
        </div>

    </div>
</div>
@endsection