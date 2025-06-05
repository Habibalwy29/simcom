@extends('layouts.app')

@section('title', 'Masuk / Daftar')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden">
        {{-- Left Section (Green Background) --}}
        <div class="w-1/2 bg-teal-600 flex flex-col items-center justify-center p-8 text-white hidden md:flex">
            <img src="https://placehold.co/150x150/FFFFFF/4DB6AC?text=SIM" alt="SIM.com Logo" class="h-32 w-32 mb-6 rounded-full" />
            <h2 class="text-4xl font-bold mb-2">Welcome to</h2>
            <h1 class="text-5xl font-extrabold mb-4">SIM.com</h1>
            <p class="text-lg">Sehat Itu Mahal</p>
        </div>

        {{-- Right Section (Login/Register Form) --}}
        <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center" id="auth-form-title">
                Masuk
            </h2>

            <p class="text-center text-gray-600 mb-6">
                Belum punya akun?
                <button type="button" onclick="toggleAuthForm()" class="text-teal-600 hover:underline font-semibold" id="toggle-auth-button">
                    Register
                </button>
            </p>

            {{-- Login Form --}}
            <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email atau Username</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="Masukkan Email atau Username"
                        value="{{ old('email') }}"
                        required
                    />
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="********"
                        required
                    />
                    @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="text-right">
                    <a href="#" class="text-teal-600 hover:underline text-sm font-semibold">Lupa Password?</a>
                </div>
                <button
                    type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300"
                >
                    Masuk
                </button>
            </form>

            {{-- Register Form (Hidden by default) --}}
            <form id="register-form" action="{{ route('register') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <div>
                    <label for="reg_email" class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
                    <input
                        type="email"
                        id="reg_email"
                        name="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="email@example.com"
                        value="{{ old('email') }}"
                        required
                    />
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="reg_password" class="block text-gray-700 text-sm font-semibold mb-2">Kata Sandi</label>
                    <input
                        type="password"
                        id="reg_password"
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="********"
                        required
                    />
                    @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="reg_password_confirmation" class="block text-gray-700 text-sm font-semibold mb-2">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="reg_password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 transition duration-200"
                        placeholder="********"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300"
                >
                    Daftar
                </button>
            </form>

            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300" />
                <span class="px-4 text-gray-500">ATAU</span>
                <hr class="flex-grow border-gray-300" />
            </div>

            <div class="space-y-3">
                <button class="w-full flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-200">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google logo" class="w-5 h-5 mr-3" />
                    Lanjut dengan Google
                </button>
                <button class="w-full flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-3 text-red-500"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Lanjut dengan email
                </button>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('mainMenu') }}" class="text-teal-600 hover:underline font-semibold">
                    Beranda
                </a>
            </div>

            @if(session('status'))
                <div class="mt-4 p-3 rounded-lg text-center bg-green-100 text-green-700">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mt-4 p-3 rounded-lg text-center bg-red-100 text-red-700">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleAuthForm() {
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const authFormTitle = document.getElementById('auth-form-title');
        const toggleAuthButton = document.getElementById('toggle-auth-button');

        if (loginForm.classList.contains('hidden')) {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            authFormTitle.innerText = 'Masuk';
            toggleAuthButton.innerText = 'Register';
            toggleAuthButton.parentNode.firstChild.textContent = 'Belum punya akun?';
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            authFormTitle.innerText = 'Daftar Akun';
            toggleAuthButton.innerText = 'Masuk di sini';
            toggleAuthButton.parentNode.firstChild.textContent = 'Sudah punya akun?';
        }
    }
</script>
@endsection