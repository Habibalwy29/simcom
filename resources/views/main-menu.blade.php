@extends('layouts.app')

@section('title', 'Menu Utama')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl shadow-2xl text-center max-w-2xl w-full transform transition-all duration-500 hover:scale-105 border border-teal-200">
        <h2 class="text-4xl font-extrabold text-teal-600 mb-8">
            Selamat Datang, {{ $user->name ?? ($user->email ? explode('@', $user->email)[0] : 'Pengguna') }}!
        </h2>
        <p class="text-md text-gray-600 mb-4">
            ID Pengguna Anda: <span class="font-mono text-sm bg-gray-200 p-1 rounded-md">{{ $user->id ?? 'N/A' }}</span>
        </p>
        <p class="text-lg text-gray-700 mb-10">
            Pilih fitur yang ingin Anda gunakan:
        </p>

        <div class="grid md:grid-cols-2 gap-8">
            <a href="{{ route('calorieCalculator') }}"
                class="flex flex-col items-center justify-center p-8 bg-blue-600 hover:bg-teal-700 text-white rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-4"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><line x1="16" x2="8" y1="6" y2="6"/><line x1="16" x2="8" y1="10" y2="10"/><line x1="12" x2="12" y1="14" y2="14"/><line x1="12" x2="12" y1="18" y2="18"/></svg>
                <span class="text-2xl font-bold">Penghitung Kalori Harian</span>
            </a>
            <a href="{{ route('dietOrdering') }}"
                class="flex flex-col items-center justify-center p-8 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-4"><path d="M12 2a3 3 0 0 0-3 3v7c0 1.1-.9 2-2 2H5a2 2 0 0 1-2-2V5c0-1.7.9-3.2 2.2-4.2M22 2c-.9 1.1-2.2 1.8-3.6 1.8h-2.8a2 2 0 0 0-2 2v7c0 1.1-.9 2-2 2H7c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h10c1.7 0 3-1.3 3-3V7c0-1.7-.9-3.2-2.2-4.2z"/></svg>
                <span class="text-2xl font-bold">Pemesanan Makanan Diet</span>
            </a>
        </div>

        <div class="mt-10">
            <a href="{{ route('account') }}"
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-full shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300">
                Lihat Profil Saya
            </a>
        </div>
    </div>
</div>
@endsection