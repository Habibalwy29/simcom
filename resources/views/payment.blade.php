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
                {{-- Ini bisa diubah menjadi Livewire component untuk update dinamis --}}
                <input
                    type="number"
                    name="manual_calories"
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    placeholder="Atau masukkan kalori manual"
                    value="{{ request('manual_calories', $calculatedCalories) }}"
                    min="1"
                />
                <button
                    type="submit"
                    class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300"
                >
                    Atur Kalori
                </button>
            </form>
            @if(session('message'))
                <div class="mt-2 p-2 text-sm rounded-lg text-center @if(str_contains(session('message'), 'valid')) bg-red-100 text-red-700 @else bg-green-100 text-green-700 @endif">
                    {{ session('message') }}
                </div>
            @endif
        </div>

        <h3 class="text-2xl font-bold mb-4 text-gray-800">Pilihan Makanan Diet:</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $displayCalories = request('manual_calories', $calculatedCalories);
                $filteredFoodItems = collect($dietFoodItems)->filter(function($item) use ($displayCalories) {
                    if (!$displayCalories) return true; // Show all if no calories input
                    return $item['calories'] <= $displayCalories * 1.2 && $item['calories'] >= $displayCalories * 0.8;
                });
            @endphp

            @if($filteredFoodItems->count() > 0)
                @foreach($filteredFoodItems as $item)
                    <div class="bg-gray-50 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-200">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-40 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/150x100/CCCCCC/333333?text=Gambar+Tidak+Tersedia';" />
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
                <p class="col-span-full text-center text-gray-600 text-lg">Tidak ada makanan yang sesuai dengan kebutuhan kalori Anda. Coba sesuaikan input kalori.</p>
            @endif
        </div>

        <div class="mt-10 p-6 bg-gray-100 rounded-xl shadow-inner border border-gray-200">
            <h3 class="text-2xl font-bold mb-4 flex items-center text-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><path d="m7.5 4.27 9 5.16"/><path d="M2.5 8.66l9 5.16 9-5.16"/><path d="M12 22v-8.5"/><path d="m2.5 16.34 9 5.16 9-5.16"/></svg>
                Keranjang Pesanan Anda
            </h3>
            @if(empty($cartItems))
                <p class="text-gray-600">Keranjang Anda kosong.</p>
            @else
                <ul class="space-y-3 mb-4">
                    @foreach($cartItems as $item)
                        <li class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                            <span class="font-semibold text-gray-800">{{ $item['name'] }}</span>
                            <span class="text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            <span class="font-bold text-gray-900">Rp {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}</span>
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
@endsection