@extends('layouts.app')

@section('title', 'Pembayaran Pesanan')

@section('content')
<div class="min-h-screen flex flex-col items-center p-4 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-3xl mt-8 border border-indigo-200">
        <h2 class="text-3xl font-bold text-center mb-8 flex items-center justify-center text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
            Detail Pembayaran
        </h2>

        @if(session('error'))
            <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
            <h3 class="text-xl font-semibold text-indigo-800 mb-3">Ringkasan Pesanan</h3>
            @if(empty($cartItems))
                <p class="text-gray-600">Keranjang Anda kosong. <a href="{{ route('dietOrdering') }}" class="text-indigo-600 hover:underline">Kembali ke pemesanan</a>.</p>
            @else
                <ul class="space-y-2 mb-4">
                    @foreach($cartItems as $item)
                        <li class="flex justify-between items-center bg-white p-3 rounded-md shadow-sm">
                            <div>
                                <span class="font-medium text-gray-800">{{ $item['name'] }} ({{ $item['quantity'] }}x)</span>
                                <p class="text-xs text-gray-500">{{ $item['calories'] }} kkal/item</p>
                            </div>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between items-center border-t pt-3 mt-3 border-indigo-300">
                    <span class="text-lg font-bold text-gray-900">Total Pembayaran:</span>
                    <span class="text-xl font-extrabold text-indigo-700">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                </div>
            @endif
        </div>

        @if(!empty($cartItems))
            <div class="mb-6 p-4 bg-teal-50 rounded-lg border border-teal-200">
                <p class="text-md font-semibold text-teal-800">
                    Target Kalori Harian Anda (referensi): <span class="text-lg font-bold">{{ $calculatedCalories ?? 'Belum dihitung' }} kkal</span>
                </p>
                <p class="text-xs text-teal-700 mt-1">Ini adalah target kalori harian Anda yang tersimpan dan hanya untuk referensi saat melakukan pemesanan.</p>
            </div>

            <form action="{{ route('processPayment') }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-6">
                    <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900">Pilih Metode Pembayaran:</label>
                    <select id="payment_method" name="payment_method" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        <option selected disabled value="">Pilih metode...</option>
                        <option value="cod">Cash on Delivery (COD)</option>
                        <option value="transfer">Bank Transfer</option>
                        <option value="ewallet">E-Wallet (GoPay, OVO, Dana)</option>
                    </select>
                    @error('payment_method')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- You can add more fields here if needed, e.g., address for COD, notes, etc. --}}
                {{-- Example:
                <div class="mb-6">
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat Pengiriman (untuk COD):</label>
                    <textarea id="address" name="address" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="Masukkan alamat lengkap jika memilih COD"></textarea>
                </div>
                --}}

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-300 flex items-center justify-center">
                    Proses Pembayaran
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                </button>
            </form>
        @endif
        <div class="mt-8 text-center">
            <a href="{{ route('dietOrdering') }}" class="text-sm text-gray-600 hover:text-indigo-600 hover:underline">
                &larr; Kembali ke Pemesanan Makanan
            </a>
        </div>
    </div>
</div>
@endsection