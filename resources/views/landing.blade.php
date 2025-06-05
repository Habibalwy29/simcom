@extends('layouts.app')

@section('title', 'Selamat Datang di SIM.COM') {{-- Judul diubah sedikit --}}

@section('content')
<div class="min-h-screen flex flex-col items-center p-4 pt-20 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl w-full max-w-6xl text-center">
        {{-- Bagian Hero Section --}}
        <div class="flex flex-col md:flex-row items-center justify-center md:justify-between mb-16">
            <div class="md:w-1/2 text-left md:pr-8 mb-8 md:mb-0">
                <h1 class="text-5xl font-extrabold text-teal-600 mb-6 leading-tight">
                    MARI HIDUP SEHAT <br /> BERSAMA SIM.COM
                </h1>
                <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                    Mulailah Perjalanan Anda Menuju Kesehatan Optimal, Alat Penghitung Kalori Cerdas Yang Dirancang Untuk Membantu Anda Mencapai Tujuan Kesehatan Anda. Di Sini, Setiap Kalori Terhitung Untuk Masa Depan Yang Lebih Sehat.
                </p>
                <a href="{{ Auth::check() ? route('mainMenu') : route('login') }}" {{-- Arahkan ke mainMenu jika sudah login --}}
                    class="bg-teal-600 hover:bg-teal-700 text-black {{-- Warna teks diubah agar kontras --}} font-bold py-3 px-8 rounded-full shadow-lg transform transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-teal-300 inline-flex items-center">
                    {{ Auth::check() ? 'Masuk ke Menu Utama' : 'Mulai Sekarang' }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block ml-2">
                        @if(Auth::check())
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>
                        @else
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="17 17 22 12 17 7"/><line x1="22" x2="11" y1="12" y2="12"/>
                        @endif
                    </svg>
                </a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('images/gambar1.png') }}" alt="Ilustrasi Utama SIM.COM" class="rounded-xl shadow-lg max-w-md lg:max-w-lg" /> {{-- Diberi max-width --}}
            </div>
        </div>

        {{-- Bagian Artikel --}}
        <div id="article-section" class="mt-16 text-gray-800 w-full">
            <h2 class="text-3xl font-bold mb-8 flex items-center justify-center text-teal-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-teal-600"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8.5L2 7.5V20a2 2 0 0 0 2 2z"/><polyline points="14 2 14 8 20 8"/><path d="M22 12v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7.5L8.5 2"/></svg>
                ARTIKEL KESEHATAN
            </h2>

            @php
                use Illuminate\Support\Str; // Untuk Str::limit

                $newsArticles = [
                    [
                        'title' => 'Apakah Jus Nanas Bisa Menurunkan Kadar Gula? Berikut Penjelasannya...',
                        'source' => 'Kompas.com',
                        'image' => asset('images/gambar2.jpg'),
                        'link' => 'https://health.kompas.com/read/24K19060000168/apakah-jus-nanas-bisa-menurunkan-kadar-gula-berikut-penjelasannya-',
                    ],
                    [
                        'title' => 'Rebusan Daun Kelor untuk Mengobati Apa? Berikut 10 Daftarnya...',
                        'source' => 'Kompas.com',
                        'image' => asset('images/gambar3.jpg'),
                        'link' => 'https://health.kompas.com/read/24K19050000568/rebusan-daun-kelor-untuk-mengobati-apa-berikut-10-daftarnya-',
                    ],
                    [
                        'title' => 'Manfaat Minum Wedang Jahe di Pagi Hari, Termasuk Naikkan Mood',
                        'source' => 'Kompas.com',
                        'image' => asset('images/gambar4.jpg'),
                        'link' => 'https://health.kompas.com/read/24K19073000368/manfaat-minum-wedang-jahe-di-pagi-hari-termasuk-naikkan-mood',
                    ],
                    [
                        'title' => '7 Buah-buahan yang Bagus untuk Diet, Bikin Cepat Langsing!',
                        'source' => 'Halodoc.com',
                        'image' => asset('images/buah.jpg'), // Anda perlu menyediakan gambar5.jpg
                        'link' => 'https://www.halodoc.com/artikel/7-buah-buahan-yang-bagus-untuk-diet-bikin-cepat-langsing',
                    ],
                    [
                        'title' => 'Pentingnya Sarapan Pagi untuk Kesehatan Tubuh dan Produktivitas',
                        'source' => 'Siloam Hospitals',
                        'image' => asset('images/sarapan.jpg'), // Anda perlu menyediakan gambar6.jpg
                        'link' => 'https://www.siloamhospitals.com/informasi-siloam/artikel/pentingnya-sarapan-pagi',
                    ],
                    [
                        'title' => 'Cara Menghitung Kalori Makanan dan Kebutuhan Kalori Harian Akurat',
                        'source' => 'Alodokter.com',
                        'image' => asset('images/kalori.jpg'), // Anda perlu menyediakan gambar7.jpg
                        'link' => 'https://www.alodokter.com/cara-menghitung-kalori-makanan-dan-kebutuhan-kalori-harian',
                    ],
                ];
            @endphp

            {{-- Container untuk horizontal scroll --}}
            <div class="flex overflow-x-auto space-x-6 md:space-x-8 py-4 -mx-4 px-4 sm:-mx-8 sm:px-8">
                @foreach($newsArticles as $article)
                    {{-- Pembungkus kartu untuk lebar tetap dan efek hover --}}
                    <div class="flex-none w-72 md:w-80 transform transition-all duration-300 hover:scale-105">
                        <a href="{{ $article['link'] }}" target="_blank" rel="noopener noreferrer"
                           class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 block h-full flex flex-col hover:shadow-2xl transition-shadow duration-300">
                            <img src="{{ $article['image'] }}" alt="{{ Str::limit($article['title'], 45) }}" class="w-full h-40 object-cover flex-shrink-0"
                                 onerror="this.onerror=null;this.src='https://placehold.co/320x160/CCCCCC/333333?text=Gambar+Error';" />
                            <div class="p-4 flex flex-col flex-grow">
                                {{-- Beri min-height agar tinggi kartu konsisten jika judul berbeda panjang --}}
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 flex-grow" style="min-height: 4.5em;">{{ Str::limit($article['title'], 65) }}</h3>
                                <p class="text-gray-600 text-sm mt-auto pt-2">{{ $article['source'] }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection