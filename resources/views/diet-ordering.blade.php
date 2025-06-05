@extends('layouts.app')

@section('title', 'Pemesanan Makanan Diet')

@section('content')
<div class="min-h-screen flex flex-col items-center p-4 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-5xl mt-8 transform transition-all duration-500 hover:scale-105 border border-teal-200">
        <h2 class="text-3xl font-bold text-center mb-6 flex items-center justify-center text-teal-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="M12 2a3 3 0 0 0-3 3v7c0 1.1-.9 2-2 2H5a2 2 0 0 1-2-2V5c0-1.7.9-3.2 2.2-4.2M22 2c-.9 1.1-2.2 1.8-3.6 1.8h-2.8a2 2 0 0 0-2 2v7c0 1.1-.9 2-2 2H7c-1.1 0-2 .9-2 2v2c0 1.1.9 2 2 2h10c1.7 0 3-1.3 3-3V7c0-1.7-.9-3.2-2.2-4.2z"/></svg>
            Pemesanan Makanan Diet
        </h2>

        <div class="mb-6 p-4 bg-teal-50 rounded-lg border border-teal-200">
            <p class="text-lg font-semibold text-teal-800 mb-2">
                Kebutuhan Kalori Harian Anda: <span class="text-xl font-bold">{{ $calculatedCalories ?? 'Belum dihitung' }} kkal</span>
            </p>
            <form action="{{ route('dietOrdering') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">
                <input
                    type="number"
                    name="manual_calories"
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    placeholder="Atau masukkan kalori manual (contoh: 1500)"
                    value="{{ request('manual_calories', $calculatedCalories > 0 ? $calculatedCalories : '') }}"
                    min="1"
                />
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300"
                >
                    Atur Kalori
                </button>
            </form>
            @if(session('message'))
                <div class="mt-2 p-2 text-sm rounded-lg text-center @if(str_contains(strtolower(session('message')), 'valid') || str_contains(strtolower(session('message')), 'gagal')) bg-red-100 text-red-700 @else bg-green-100 text-green-700 @endif">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <h3 class="text-2xl font-bold mb-4 text-gray-800">Pilihan Makanan Diet:</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                // Ambil nilai kalori yang akan digunakan untuk filter, prioritaskan dari input manual jika ada dan valid.
                // Jika tidak, gunakan $calculatedCalories dari controller.
                $filterCaloriesValue = request('manual_calories');
                if ($filterCaloriesValue !== null && $filterCaloriesValue !== '' && (float)$filterCaloriesValue > 0) {
                    $displayCalories = (float)$filterCaloriesValue;
                } else {
                    $displayCalories = (float)($calculatedCalories ?? 0);
                }

                $filteredFoodItems = collect($dietFoodItems)->filter(function($item) use ($displayCalories) {
                    if (!$displayCalories || $displayCalories <= 0) return true; // Tampilkan semua jika tidak ada target kalori atau tidak valid
                    // Logika filter: item kalori antara 20% hingga 120% dari target kalori
                    // Anda bisa menyesuaikan rentang ini sesuai kebutuhan
                    return $item['calories'] <= $displayCalories * 1.2 && $item['calories'] >= $displayCalories * 0.2;
                });
            @endphp

            @if($filteredFoodItems->count() > 0)
                @foreach($filteredFoodItems as $item)
                    <div class="bg-gray-50 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-200">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-40 object-cover"
                             onerror="this.onerror=null;this.src='https://placehold.co/150x100/CCCCCC/333333?text=Gambar+Error';" />
                        <div class="p-4">
                            <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $item['name'] }}</h4>
                            <p class="text-gray-700 text-sm mb-1">Kalori: <span class="font-bold">{{ $item['calories'] }} kkal</span></p>
                            <p class="text-gray-700 text-lg font-bold mb-3">Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            <form action="{{ route('addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                <input type="hidden" name="item_name" value="{{ $item['name'] }}">
                                <input type="hidden" name="item_price" value="{{ $item['price'] }}">
                                <input type="hidden" name="item_calories" value="{{ $item['calories'] }}">
                                {{-- Opsi untuk input kuantitas langsung dari daftar produk --}}
                                {{-- <div class="mb-2">
                                    <label for="quantity_{{ $item['id'] }}" class="text-sm font-medium text-gray-700">Jumlah:</label>
                                    <input type="number" name="quantity" id="quantity_{{ $item['id'] }}" value="1" min="1" class="w-20 px-2 py-1 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                                </div> --}}
                                <button
                                    type="submit"
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-300 flex items-center justify-center">
                                    Tambah ke Keranjang
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-600 text-lg">
                    Tidak ada makanan yang sesuai dengan target kalori <span class="font-bold">{{ $displayCalories > 0 ? $displayCalories . ' kkal' : 'Anda' }}</span> saat ini.
                    @if($displayCalories > 0)
                        Coba sesuaikan input kalori atau <a href="{{ route('dietOrdering') }}" class="text-teal-600 hover:text-teal-800 underline">lihat semua item</a>.
                    @endif
                </p>
            @endif
        </div>

        <div class="mt-10 p-6 bg-gray-100 rounded-xl shadow-inner border border-gray-200">
            <h3 class="text-2xl font-bold mb-4 flex items-center text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="m7.5 4.27 9 5.16"/><path d="M2.5 8.66l9 5.16 9-5.16"/><path d="M12 22v-8.5"/><path d="m2.5 16.34 9 5.16 9-5.16"/></svg>
                Keranjang Pesanan Anda
            </h3>
            {{-- Untuk debug, tampilkan jumlah item dan dump data keranjang --}}
            {{-- <p>Debug: Jumlah item di keranjang = {{ count($cartItems ?? []) }}</p>
            @dump($cartItems ?? null) --}}

            @if(empty($cartItems))
                <p class="text-gray-600">Keranjang Anda kosong.</p>
            @else
                <ul class="space-y-3 mb-4">
                    {{-- Loop melalui item keranjang. $cartItems adalah array numerik. --}}
                    @foreach($cartItems as $cartItem)
                        <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-3 rounded-lg shadow-sm">
                            <div class="mb-2 sm:mb-0 flex-grow">
                                <span class="font-semibold text-gray-800">{{ $cartItem['name'] }}</span>
                                <p class="text-xs text-gray-500">{{ $cartItem['calories'] }} kkal</p>
                                <p class="text-xs text-gray-500">Harga Satuan: Rp {{ number_format($cartItem['price'], 0, ',', '.') }}</p>
                            </div>

                            <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-end">
                                <form action="{{ route('cart.updateQuantity') }}" method="POST" class="flex items-center">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $cartItem['id'] }}">
                                    <button type="submit" name="action" value="decrease" class="px-2 py-1 bg-red-500 text-white rounded-l hover:bg-red-600 text-sm font-semibold" title="Kurangi jumlah">-</button>
                                    <input type="text" readonly value="{{ $cartItem['quantity'] }}" class="w-10 text-center border-t border-b border-gray-300 text-sm py-1 bg-gray-50">
                                    <button type="submit" name="action" value="increase" class="px-2 py-1 bg-green-500 text-white rounded-r hover:bg-green-600 text-sm font-semibold" title="Tambah jumlah">+</button>
                                </form>

                                <span class="font-bold text-gray-900 text-sm sm:text-base w-28 text-right">Rp {{ number_format($cartItem['quantity'] * $cartItem['price'], 0, ',', '.') }}</span>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $cartItem['id'] }}">
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-100 ml-1 sm:ml-2" title="Hapus item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="flex justify-between items-center border-t pt-4 mt-4 border-gray-300">
                    <span class="text-xl font-bold text-gray-900">Total:</span>
                    <span class="text-2xl font-extrabold text-teal-700">Rp {{ number_format($totalCartPrice, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('payment') }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-md mt-6 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300 flex items-center justify-center">
                    Lanjutkan ke Pembayaran
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                </a>
            @endif
        </div>
    </div>
</div>

{{-- Script untuk memastikan input kalori manual hanya menerima angka positif --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const manualCaloriesInput = document.querySelector('input[name="manual_calories"]');
        if (manualCaloriesInput) {
            manualCaloriesInput.addEventListener('input', function() {
                if (this.value && parseInt(this.value) < 1) {
                    this.value = ''; // Kosongkan jika kurang dari 1
                }
            });
        }
    });
</script>
@endsection