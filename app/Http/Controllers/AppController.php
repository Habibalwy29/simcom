<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function mainMenu()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();
        // Anda bisa meneruskan data user ke tampilan
        return view('main-menu', compact('user'));
    }

    public function calorieCalculator()
    {
        // Jika ada data hasil perhitungan dari sesi, teruskan ke view
        $calculatedData = session('calculated_data');
        return view('calorie-calculator', compact('calculatedData'));
    }

    public function dietOrdering(Request $request)
    {
        // Meneruskan data kalori yang mungkin berasal dari halaman perhitungan
        $calculatedCalories = $request->session()->get('calculated_calories_for_order');
        // Anda bisa memuat item makanan diet dari database di sini
        $dietFoodItems = [
            ['id' => 'df1', 'name' => 'Salad Ayam Panggang', 'calories' => 350, 'price' => 45000, 'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Salad+Ayam'],
            ['id' => 'df2', 'name' => 'Nasi Merah Salmon Panggang', 'calories' => 500, 'price' => 70000, 'image' => 'https://placehold.co/150x100/FEE2E2/991B1B?text=Salmon+Rice'],
            // ... tambahkan item lain
        ];
        // Anda bisa mengelola keranjang di sesi atau database
        $cartItems = session('cart_items', []); // Ambil item keranjang dari sesi
        return view('diet-ordering', compact('calculatedCalories', 'dietFoodItems', 'cartItems'));
    }

    public function payment()
    {
        // Ambil item keranjang dari sesi untuk ditampilkan di halaman pembayaran
        $cartItems = session('cart_items', []);
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
        return view('payment', compact('cartItems', 'totalAmount'));
    }

    public function account()
    {
        $user = Auth::user();
        // Anda bisa memuat data profil lengkap dari database di sini
        $profileData = [
            'fullName' => $user->name ?? 'Pengguna SIM',
            'username' => $user->email ? explode('@', $user->email)[0] : 'default_username',
            'email' => $user->email ?? 'default@example.com',
            'phoneNumber' => '+62 81234567890', // Contoh data mock
            'profilePicture' => 'https://placehold.co/100x100/4DB6AC/FFFFFF?text=DC',
        ];
        return view('account', compact('user', 'profileData'));
    }

    // --- Contoh Logika Pemrosesan Form (Sederhana, tanpa Livewire) ---

    public function calculateCalories(Request $request)
    {
        // Logika perhitungan kalori Anda di sini (sama seperti di React, tapi dalam PHP)
        $age = $request->input('age');
        $height = $request->input('height');
        $weight = $request->input('weight');
        $gender = $request->input('gender');
        $activityLevel = $request->input('activityLevel');

        // ... Lakukan perhitungan BMI dan Kalori di PHP ...
        $bmiStatus = "Berat Badan Ideal (Mock)"; // Contoh
        $dailyCalories = 2000; // Contoh

        // Simpan hasil ke sesi atau database jika diperlukan
        $request->session()->flash('calculated_data', [
            'bmiStatus' => $bmiStatus,
            'dailyCalories' => $dailyCalories,
        ]);
        $request->session()->put('calculated_calories_for_order', $dailyCalories); // Simpan untuk halaman order

        return redirect()->route('calorieCalculator')->with('success', 'Perhitungan berhasil!');
    }

    public function addToCart(Request $request)
    {
        $itemId = $request->input('item_id');
        $itemName = $request->input('item_name');
        $itemPrice = $request->input('item_price');
        $itemCalories = $request->input('item_calories'); // Jika perlu

        $cartItems = $request->session()->get('cart_items', []);

        $found = false;
        foreach ($cartItems as &$item) {
            if ($item['id'] == $itemId) {
                $item['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $cartItems[] = [
                'id' => $itemId,
                'name' => $itemName,
                'price' => $itemPrice,
                'quantity' => 1,
                'calories' => $itemCalories,
            ];
        }

        $request->session()->put('cart_items', $cartItems);
        return redirect()->back()->with('success', $itemName . ' ditambahkan ke keranjang!');
    }

    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $cartItems = $request->session()->get('cart_items', []);
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // ... Logika pemrosesan pembayaran (misalnya, simpan ke database) ...

        // Hapus keranjang setelah pembayaran
        $request->session()->forget('cart_items');

        return redirect()->route('mainMenu')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Lakukan validasi input
            $request->validate([
                'fullName' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'phoneNumber' => 'nullable|string|max:20',
            ]);

            // Update data user (simulasi)
            $user->name = $request->input('fullName');
            // Untuk username dan phone, Anda mungkin perlu menambahkan kolom di tabel users
            // $user->username = $request->input('username');
            // $user->phone_number = $request->input('phoneNumber');
            $user->save(); // Simpan perubahan ke database

            return redirect()->route('account')->with('success', 'Profil berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }
}