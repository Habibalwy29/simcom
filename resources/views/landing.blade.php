@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="min-h-screen flex flex-col items-center p-4 pt-20 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl w-full max-w-6xl text-center">
        <div class="flex flex-col md:flex-row items-center justify-center md:justify-between mb-16">
            <div class="md:w-1/2 text-left md:pr-8 mb-8 md:mb-0">
                <h1 class="text-5xl font-extrabold text-teal-600 mb-6 leading-tight">
                    MARI HIDUP SEHAT <br /> BERSAMA SIM.COM
                </h1>
                <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                    Mulailah Perjalanan Anda Menuju Kesehatan Optimal, Alat Penghitung Kalori Cerdas Yang Dirancang Untuk Membantu Anda Mencapai Tujuan Kesehatan Anda. Di Sini, Setiap Kalori Terhitung Untuk Masa Depan Yang Lebih Sehat.
                </p>
                <a href="{{ route('login') }}"
                    class="bg-teal-600 hover:bg-teal-700 text-black font-bold py-3 px-8 rounded-full shadow-lg transform transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-4 focus:ring-teal-300 inline-flex items-center">
                    Mulai Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block ml-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="17 17 22 12 17 7"/><line x1="22" x2="11" y1="12" y2="12"/></svg>
                </a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="https://placehold.co/400x300/E0F2F1/004D40?text=Gambar+Utama" alt="Main illustration" class="rounded-xl shadow-lg" />
            </div>
        </div>

        <div id="article-section" class="mt-12 text-gray-800">
            <h2 class="text-3xl font-bold mb-8 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 text-teal-600"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8.5L2 7.5V20a2 2 0 0 0 2 2z"/><polyline points="14 2 14 8 20 8"/><path d="M22 12v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7.5L8.5 2"/></svg>
                ARTICLE
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $newsArticles = [
                        [
                            'title' => 'Apakah Jus Nanas Bisa Menurunkan Kadar Gula? Berikut Penjelasannya...',
                            'source' => 'Kompas.com',
                            'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Jus+Nanas',
                            'link' => 'https://health.kompas.com/read/2024/05/27/100000/apakah-jus-nanas-bisa-menurunkan-kadar-gula-berikut-penjelasannya',
                        ],
                        [
                            'title' => 'Rebusan Daun Kelor untuk Mengobati Apa? Berikut 10 Daftarnya...',
                            'source' => 'Kompas.com',
                            'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Daun+Kelor',
                            'link' => 'https://health.kompas.com/read/2024/05/27/100000/rebusan-daun-kelor-untuk-mengobati-apa-berikut-10-daftarnya',
                        ],
                        [
                            'title' => 'Manfaat Minum Wedang Jahe di Pagi Hari, Termasuk Naikkan Mood',
                            'source' => 'Kompas.com',
                            'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Wedang+Jahe',
                            'link' => 'https://health.kompas.com/read/2024/05/27/100000/manfaat-minum-wedang-jahe-di-pagi-hari-termasuk-naikkan-mood',
                        ],
                    ];
                @endphp

                @foreach($newsArticles as $article)
                    <a href="{{ $article['link'] }}" target="_blank" rel="noopener noreferrer"
                        class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-200 block">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-40 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/150x100/CCCCCC/333333?text=Gambar+Tidak+Tersedia';" />
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $article['title'] }}</h3>
                            <p class="text-gray-600 text-sm">{{ $article['source'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection