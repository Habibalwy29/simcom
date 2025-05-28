@extends('layouts.app')

@section('title', 'Penghitung Kalori Harian')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-white text-gray-800">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-500 hover:scale-105 border border-teal-200">
        <h2 class="text-3xl font-bold text-center mb-6 flex items-center justify-center text-teal-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><line x1="16" x2="8" y1="6" y2="6"/><line x1="16" x2="8" y1="10" y2="10"/><line x1="12" x2="12" y1="14" y2="14"/><line x1="12" x2="12" y1="18" y2="18"/></svg>
            Penghitung Kalori Harian
        </h2>

        <form action="{{ route('calculateCalories') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="age" class="block text-gray-700 text-sm font-semibold mb-2">Umur (tahun)</label>
                <input
                    type="number"
                    id="age"
                    name="age"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    placeholder="Contoh: 30"
                    min="1"
                    value="{{ old('age') }}"
                    required
                />
            </div>
            <div>
                <label for="height" class="block text-gray-700 text-sm font-semibold mb-2">Tinggi Badan (cm)</label>
                <input
                    type="number"
                    id="height"
                    name="height"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    placeholder="Contoh: 170"
                    min="1"
                    value="{{ old('height') }}"
                    required
                />
            </div>
            <div>
                <label for="weight" class="block text-gray-700 text-sm font-semibold mb-2">Berat Badan (kg)</label>
                <input
                    type="number"
                    id="weight"
                    name="weight"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    placeholder="Contoh: 65"
                    min="1"
                    value="{{ old('weight') }}"
                    required
                />
            </div>
            <div>
                <label for="gender" class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin</label>
                <select
                    id="gender"
                    name="gender"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    required
                >
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Pria</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Wanita</option>
                </select>
            </div>
            <div>
                <label for="activityLevel" class="block text-gray-700 text-sm font-semibold mb-2">Tingkat Aktivitas</label>
                <select
                    id="activityLevel"
                    name="activityLevel"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                    required
                >
                    <option value="sedentary" {{ old('activityLevel') == 'sedentary' ? 'selected' : '' }}>Sangat Sedikit/Tidak Berolahraga</option>
                    <option value="lightlyActive" {{ old('activityLevel') == 'lightlyActive' ? 'selected' : '' }}>Ringan (1-3 hari/minggu)</option>
                    <option value="moderatelyActive" {{ old('activityLevel') == 'moderatelyActive' ? 'selected' : '' }}>Sedang (3-5 hari/minggu)</option>
                    <option value="veryActive" {{ old('activityLevel') == 'veryActive' ? 'selected' : '' }}>Berat (6-7 hari/minggu)</option>
                    <option value="extraActive" {{ old('activityLevel') == 'extraActive' ? 'selected' : '' }}>Sangat Berat (Atlet/Pekerjaan Fisik)</option>
                </select>
            </div>
            <button
                type="submit"
                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-md mt-6 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300"
            >
                Hitung Kebutuhan Kalori
            </button>
        </form>

        @if(session('success'))
            <div class="mt-4 p-3 rounded-lg text-center bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mt-4 p-3 rounded-lg text-center bg-red-100 text-red-700">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @isset($calculatedData)
            <div class="mt-8 p-6 bg-teal-50 rounded-xl shadow-inner border border-teal-200">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Hasil Perhitungan:</h3>
                <p class="text-lg text-gray-700 mb-2">
                    Status Berat Badan: <span class="font-semibold text-teal-600">{{ $calculatedData['bmiStatus'] }}</span>
                </p>
                <p class="text-lg text-gray-700">
                    Kebutuhan Kalori Harian Anda: <span class="font-bold text-teal-600 text-xl">{{ $calculatedData['dailyCalories'] }} kkal</span>
                </p>
                <a href="{{ route('dietOrdering') }}"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-md mt-6 transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300 flex items-center justify-center">
                    Pesan Makanan Diet Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                </a>
            </div>
        @endisset
    </div>
</div>
@endsection