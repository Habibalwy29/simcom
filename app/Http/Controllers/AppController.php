<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada karena kita menggunakan Auth::user()

class AppController extends Controller
{
    /**
     * Menampilkan halaman landing.
     */
    public function landing()
    {
        return view('landing');
    }
    public function login()
    {
        return view('login'); // ATAU path yang benar ke file login.blade.php Anda
    }
    /**
     * Menampilkan menu utama setelah login.
     */
    public function mainMenu()
    {
        $user = Auth::user();
        return view('main-menu', compact('user'));
    }

    /**
     * Menampilkan halaman penghitung kalori harian.
     */
    public function calorieCalculator(Request $request)
    {
        $calculatedData = $request->session()->get('calculated_data');
        return view('calorie-calculator', compact('calculatedData'));
    }

    /**
     * Memproses perhitungan kalori yang dimasukkan pengguna.
     */
    public function calculateCalories(Request $request)
    {
        $request->validate([
            'age' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'gender' => 'required|in:male,female',
            'activityLevel' => 'required|string',
        ]);

        $age = (float)$request->input('age');
        $height = (float)$request->input('height');
        $weight = (float)$request->input('weight');
        $gender = $request->input('gender');
        $activityLevel = $request->input('activityLevel');

        $heightInMeters = $height / 100;
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        $bmiStatus = '';
        if ($bmi < 18.5) {
            $bmiStatus = 'Kurang Berat Badan (Underweight)';
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            $bmiStatus = 'Berat Badan Ideal (Normal)';
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            $bmiStatus = 'Kelebihan Berat Badan (Overweight)';
        } else {
            $bmiStatus = 'Obesitas (Obese)';
        }

        $bmr = 0;
        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        $activityMultiplier = 1.2;
        switch ($activityLevel) {
            case 'lightlyActive': $activityMultiplier = 1.375; break;
            case 'moderatelyActive': $activityMultiplier = 1.55; break;
            case 'veryActive': $activityMultiplier = 1.725; break;
            case 'extraActive': $activityMultiplier = 1.9; break;
        }
        $dailyCalories = round($bmr * $activityMultiplier);

        $request->session()->flash('calculated_data', [
            'bmiStatus' => $bmiStatus,
            'dailyCalories' => $dailyCalories,
        ]);
        $request->session()->put('calculated_calories_for_order', $dailyCalories);

        return redirect()->route('calorieCalculator')->with('success', 'Perhitungan berhasil!');
    }

    /**
     * Menampilkan halaman pemesanan makanan diet.
     */
    public function dietOrdering(Request $request)
    {
        $calculatedCalories = $request->session()->get('calculated_calories_for_order', 0);

        

        $dietFoodItems = [
            [
                'id' => 'df1',
                'name' => 'Salad Ayam Panggang',
                'calories' => 350,
                'price' => 45000,
                'image' => asset('images\salad_ayam.jpg') 
            ],
            [
                'id' => 'df2',
                'name' => 'Nasi Merah Salmon Panggang',
                'calories' => 520,
                'price' => 75000,
                'image' => asset('images\nasi merah salmon.jpg') 
            ],
            [
                'id' => 'df3',
                'name' => 'Sup Sayuran Detoks',
                'calories' => 200,
                'price' => 30000,
                'image' => asset('images\sup sayur.jpg') 
            ],
            [
                'id' => 'df4',
                'name' => 'Smoothie Hijau Protein',
                'calories' => 280,
                'price' => 35000,
                'image' => asset('images\smothie.jpg') 
            ],
            [
                'id' => 'df5',
                'name' => 'Steak Tempe dengan Quinoa',
                'calories' => 420,
                'price' => 55000,
                'image' => asset('images\steak tempe.jpg') // DIUBAH
            ],
            // ... Lanjutkan untuk semua item lainnya ...
            ['id' => 'df6', 'name' => 'Wrap Ayam Gandum Utuh', 'calories' => 380, 'price' => 40000, 'image' => asset('images\wrap ayam.jpg')],
            ['id' => 'df7', 'name' => 'Pasta Gandum Utuh dengan Pesto', 'calories' => 480, 'price' => 60000, 'image' => asset('images\pasta gandum.jpg')],
            ['id' => 'df8', 'name' => 'Oatmeal Buah Beri', 'calories' => 250, 'price' => 28000, 'image' => asset('images\oatmeal buah beri.jpg')],
            ['id' => 'df9', 'name' => 'Telur Rebus 2 Butir', 'calories' => 160, 'price' => 15000, 'image' => asset('images\telur rebus.jpg')],
            ['id' => 'df10', 'name' => 'Sup Ayam Bening', 'calories' => 180, 'price' => 28000, 'image' => asset('images\sup ayam.jpg')],
            ['id' => 'df11', 'name' => 'Smoothie Hijau Detoks', 'calories' => 220, 'price' => 32000, 'image' => asset('images\smothie.jpg')],
            ['id' => 'df12', 'name' => 'Tumis Tahu Brokoli', 'calories' => 290, 'price' => 30000, 'image' => asset('images\tumis tahu brokoli.jpg')],
            ['id' => 'df13', 'name' => 'Gado-gado Tanpa Lontong', 'calories' => 380, 'price' => 35000, 'image' => asset('images\gado gado.jpg')],
            ['id' => 'df14', 'name' => 'Ikan Patin Bakar', 'calories' => 320, 'price' => 48000, 'image' => asset('images\ikan patin.jpg')],
            ['id' => 'df15', 'name' => 'Urap Sayur Komplit', 'calories' => 250, 'price' => 27000, 'image' => asset('images\urap.jpg')],
            ['id' => 'df16', 'name' => 'Nasi Merah dengan Dada Ayam Panggang', 'calories' => 550, 'price' => 50000, 'image' => asset('images\dada ayam.jpg')],
            ['id' => 'df17', 'name' => 'Salad Buah dengan Yogurt', 'calories' => 200, 'price' => 25000, 'image' => asset('images\salad buah.jpg')],
            ['id' => 'df18', 'name' => 'Bubur Oat Pisang Madu', 'calories' => 310, 'price' => 20000, 'image' => asset('images\bubur oat.jpg')],
            ['id' => 'df19', 'name' => 'Steak Daging Sapi Lada Hitam (Lean)', 'calories' => 600, 'price' => 90000, 'image' => asset('images\steak lada hitam.jpg')],
            ['id' => 'df20', 'name' => 'Quinoa Bowl dengan Sayuran Hijau', 'calories' => 450, 'price' => 58000, 'image' => asset('images\quinoa.jpg')],
            ['id' => 'df21', 'name' => 'Mie Shirataki Kuah Ayam', 'calories' => 190, 'price' => 38000, 'image' => asset('images\mie shirataki.jpg')],
            ['id' => 'df22', 'name' => 'Sandwich Gandum Isi Tuna', 'calories' => 300, 'price' => 29000, 'image' => asset('images\sandwich.jpg')],
            ['id' => 'df23', 'name' => 'Puding Chia Seeds Buah Naga', 'calories' => 260, 'price' => 33000, 'image' => asset('images\puding chia.jpg')],
            ['id' => 'df24', 'name' => 'Paket Nasi Merah, Telur, dan Tempe', 'calories' => 400, 'price' => 28000, 'image' => asset('images\paket diet.jpg')],
            ['id' => 'df27', 'name' => 'Steak Tempe Saus BBQ', 'calories' => 390, 'price' => 38000, 'image' => asset('images\steak tempe.jpg')],
            ['id' => 'df28', 'name' => 'Salad Udang Alpukat', 'calories' => 410, 'price' => 65000, 'image' => asset('images\salad udang.jpg')],
            ['id' => 'df29', 'name' => 'Sup Jamur Krim (Non-dairy)', 'calories' => 240, 'price' => 35000, 'image' => asset('images\sup jamur.jpg')],
            ['id' => 'df30', 'name' => 'Paket Katering Diet Harian (Komplit)', 'calories' => 1600, 'price' => 150000, 'image' => asset('images\paket diet.jpg')],
            ['id' => 'df31', 'name' => 'Pizza Gandum Tipis (Sayuran)', 'calories' => 700, 'price' => 80000, 'image' => asset('images\pizza.jpg')],
            ['id' => 'df32', 'name' => 'Burrito Bowl Ayam (tanpa nasi)', 'calories' => 580, 'price' => 60000, 'image' => asset('images\buritto.jpg')],
            ['id' => 'df33', 'name' => 'Large Personal Keto Meal (Protein Tinggi)', 'calories' => 850, 'price' => 95000, 'image' => asset('images\kato meal.jpg')],
            ['id' => 'df34', 'name' => 'Paket Diet Vegetarian Seminggu', 'calories' => 3000, 'price' => 350000, 'image' => asset('images\paket katering.jpg')]
        ];

        $cartItems = $request->session()->get('cart_items', []);
        $totalCartPrice = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        if ($request->has('manual_calories')) {
            $manualCalories = (float)$request->input('manual_calories');
            if ($manualCalories > 0) {
                $calculatedCalories = $manualCalories;
                $request->session()->put('calculated_calories_for_order', $manualCalories);
                session()->flash('message', 'Kebutuhan kalori diperbarui menjadi ' . $manualCalories . ' kkal!');
            } else {
                session()->flash('message', 'Harap masukkan angka kalori yang valid.');
            }
        }

        return view('diet-ordering', compact('calculatedCalories', 'dietFoodItems', 'cartItems', 'totalCartPrice'));
    }

    /**
     * Menambahkan item ke keranjang belanja (disimpan di sesi).
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string',
            'item_name' => 'required|string',
            'item_price' => 'required|numeric',
            'item_calories' => 'required|numeric',
        ]);

        $itemId = $request->input('item_id');
        $itemName = $request->input('item_name');
        $itemPrice = (float)$request->input('item_price');
        $itemCalories = (int)$request->input('item_calories');

        $cartItems = $request->session()->get('cart_items', []);

        $found = false;
        foreach ($cartItems as &$cartItem) { // Use different variable name to avoid conflict if $item is used elsewhere
            if ($cartItem['id'] == $itemId) {
                $cartItem['quantity']++;
                $found = true;
                break;
            }
        }
        unset($cartItem); // Unset reference

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
    public function updateCartQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string',
            'action' => 'required|in:increase,decrease',
        ]);

        $itemId = $request->input('item_id');
        $action = $request->input('action');
        $cartItems = $request->session()->get('cart_items', []);
        $message = 'Item tidak ditemukan di keranjang. Gagal!'; // Pesan default
        $itemProcessed = false;

        foreach ($cartItems as $key => &$cartItem) { // Gunakan referensi untuk modifikasi langsung
            if ($cartItem['id'] == $itemId) {
                if ($action == 'increase') {
                    $cartItem['quantity']++;
                    $message = $cartItem['name'] . ' kuantitas berhasil ditambah.';
                } elseif ($action == 'decrease') {
                    $cartItem['quantity']--;
                    if ($cartItem['quantity'] <= 0) {
                        unset($cartItems[$key]); // Hapus item jika kuantitas 0 atau kurang
                        $message = $cartItem['name'] . ' berhasil dihapus dari keranjang.';
                    } else {
                        $message = $cartItem['name'] . ' kuantitas berhasil dikurangi.';
                    }
                }
                $itemProcessed = true;
                break; // Hentikan loop setelah item ditemukan dan diproses
            }
        }
        unset($cartItem); // Hapus referensi setelah loop

        if ($itemProcessed) {
            // Re-index array untuk menghilangkan gap dari unset
            $request->session()->put('cart_items', array_values($cartItems));
        }
        
        return redirect()->route('dietOrdering')->with('message', $message);
    }

    /**
     * Menghapus item dari keranjang belanja.
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string',
        ]);

        $itemId = $request->input('item_id');
        $cartItems = $request->session()->get('cart_items', []);
        $itemName = 'Item yang dipilih'; // Default name
        $itemRemoved = false;

        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem['id'] == $itemId) {
                $itemName = $cartItem['name'];
                unset($cartItems[$key]);
                $itemRemoved = true;
                break; // Hentikan loop setelah item ditemukan dan dihapus
            }
        }

        if ($itemRemoved) {
            // Re-index array untuk menghilangkan gap dari unset
            $request->session()->put('cart_items', array_values($cartItems));
            return redirect()->route('dietOrdering')->with('message', $itemName . ' berhasil dihapus dari keranjang.');
        }

        return redirect()->route('dietOrdering')->with('message', 'Item tidak ditemukan untuk dihapus. Gagal!');
    }
    /**
     * Menampilkan halaman pembayaran dengan detail keranjang.
     */
    public function payment(Request $request)
    {
        $cartItems = $request->session()->get('cart_items', []);
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $calculatedCalories = $request->session()->get('calculated_calories_for_order', 0);

        return view('payment', compact('cartItems', 'totalAmount', 'calculatedCalories'));
    }

    /**
     * Memproses pembayaran pesanan.
     */
    public function processPayment(Request $request)
{
    $request->validate([
        'payment_method' => 'required|string|in:cod,transfer,ewallet',
    ]);

    $paymentMethod = $request->input('payment_method');
    $cartItems = $request->session()->get('cart_items', []);
    // ... (validasi keranjang tidak kosong) ...

    if (empty($cartItems)) {
        // Menggunakan 'error' agar sesuai dengan @if(session('error')) di payment.blade.php
        return redirect()->route('dietOrdering')->with('error', 'Keranjang Anda kosong. Tidak ada yang bisa diproses.');
    }

    // ... Logika pemrosesan pembayaran Anda ...

    $request->session()->forget('cart_items');
    // $request->session()->forget('calculated_calories_for_order'); // Opsional

    // Menggunakan 'success' untuk pesan sukses
    return redirect()->route('mainMenu') // Atau route halaman konfirmasi pesanan jika ada
                   ->with('success', 'Pembayaran berhasil! Pesanan Anda dengan metode ' . $paymentMethod . ' sedang diproses.');
}

    /**
     * Menampilkan dan mengelola halaman profil pengguna.
     */
    public function account()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses akun Anda.');
        }

        $profileData = [
            'fullName' => $user->name ?? 'Pengguna DietCare',
            'username' => $user->email ? explode('@', $user->email)[0] : 'pengguna_default',
            'email' => $user->email ?? 'Tidak ada email',
            'phoneNumber' => $user->phone_number ?? '+62 800-0000-0000', // Asumsikan ada field phone_number di tabel users
            'profilePicture' => $user->profile_picture ?? 'https://placehold.co/100x100/4DB6AC/FFFFFF?text=DC', // Asumsikan ada field
        ];
        return view('account', compact('user', 'profileData'));
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Gagal memperbarui profil. Pengguna tidak terautentikasi.');
        }

        $request->validate([
            'fullName' => 'required|string|max:255',
            // 'username' => 'required|string|max:255|unique:users,username,'.$user->id, // Jika username bisa diubah & unik
            'phoneNumber' => 'nullable|string|max:20',
            // 'profilePictureFile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // For file upload
            'profilePictureUrl' => 'nullable|url|max:255', // For URL input
        ]);

        $user->name = $request->input('fullName');
        // if ($request->filled('username')) { $user->username = $request->input('username'); }
        if ($request->filled('phoneNumber')) {
            // $user->phone_number = $request->input('phoneNumber'); // Jika ada field di tabel users
        }

        // Handle profile picture update (contoh untuk URL input)
        if ($request->filled('profilePictureUrl')) {
            // $user->profile_picture = $request->input('profilePictureUrl'); // Jika ada field
        }
        // if ($request->hasFile('profilePictureFile')) {
            // $path = $request->file('profilePictureFile')->store('profile_pictures', 'public');
            // $user->profile_picture = Storage::url($path);
        // }

        // $user->save();

        return redirect()->route('account')->with('success', 'Profil berhasil diperbarui!');
    }
}