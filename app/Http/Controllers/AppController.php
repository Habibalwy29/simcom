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

    /**
     * Menampilkan menu utama setelah login.
     */
    public function mainMenu()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();
        // Meneruskan data user ke tampilan
        return view('main-menu', compact('user'));
    }

    /**
     * Menampilkan halaman penghitung kalori harian.
     */
    public function calorieCalculator()
    {
        // Jika ada data hasil perhitungan dari sesi, teruskan ke view
        $calculatedData = session('calculated_data');
        return view('calorie-calculator', compact('calculatedData'));
    }

    /**
     * Memproses perhitungan kalori yang dimasukkan pengguna.
     */
    public function calculateCalories(Request $request)
    {
        // Lakukan validasi input
        $request->validate([
            'age' => 'required|numeric|min:1',
            'height' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'gender' => 'required|in:male,female',
            'activityLevel' => 'required|string', // Bisa ditambahkan validasi 'in' dengan level aktivitas yang valid
        ]);

        $age = (float)$request->input('age');
        $height = (float)$request->input('height');
        $weight = (float)$request->input('weight');
        $gender = $request->input('gender');
        $activityLevel = $request->input('activityLevel');

        // Lakukan perhitungan BMI
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

        // Hitung BMR (Basal Metabolic Rate) menggunakan Mifflin-St Jeor Equation
        $bmr = 0;
        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        // Tentukan multiplier aktivitas
        $activityMultiplier = 1.2; // Sedentary (default)
        switch ($activityLevel) {
            case 'lightlyActive': $activityMultiplier = 1.375; break;
            case 'moderatelyActive': $activityMultiplier = 1.55; break;
            case 'veryActive': $activityMultiplier = 1.725; break;
            case 'extraActive': $activityMultiplier = 1.9; break;
        }

        // Hitung Kebutuhan Kalori Harian
        $dailyCalories = round($bmr * $activityMultiplier);

        // Simpan hasil ke sesi
        $request->session()->flash('calculated_data', [
            'bmiStatus' => $bmiStatus,
            'dailyCalories' => $dailyCalories,
        ]);
        $request->session()->put('calculated_calories_for_order', $dailyCalories); // Simpan untuk halaman order

        return redirect()->route('calorieCalculator')->with('success', 'Perhitungan berhasil!');
    }

    /**
     * Menampilkan halaman pemesanan makanan diet.
     */
    public function dietOrdering(Request $request)
    {
        // Meneruskan data kalori yang mungkin berasal dari halaman perhitungan
        $calculatedCalories = $request->session()->get('calculated_calories_for_order');
        
        // Mock data makanan diet (Anda bisa memuat dari database)
        $dietFoodItems = [
            ['id' => 'df1', 'name' => 'Salad Ayam Panggang', 'calories' => 350, 'price' => 45000, 'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Salad+Ayam'],
            ['id' => 'df2', 'name' => 'Nasi Merah Salmon Panggang', 'calories' => 500, 'price' => 70000, 'image' => 'https://placehold.co/150x100/FEE2E2/991B1B?text=Salmon+Rice'],
            ['id' => 'df3', 'name' => 'Sup Sayuran Detoks', 'calories' => 200, 'price' => 30000, 'image' => 'https://placehold.co/150x100/DBEAFE/1E40AF?text=Sup+Sayur'],
            ['id' => 'df4', 'name' => 'Smoothie Hijau Protein', 'calories' => 280, 'price' => 35000, 'image' => 'https://placehold.co/150x100/D1FAE5/065F46?text=Smoothie'],
            ['id' => 'df5', 'name' => 'Steak Tempe dengan Quinoa', 'calories' => 420, 'price' => 55000, 'image' => 'https://placehold.co/150x100/FEE2E2/991B1B?text=Tempe+Quinoa'],
            ['id' => 'df6', 'name' => 'Wrap Ayam Gandum Utuh', 'calories' => 380, 'price' => 40000, 'image' => 'https://placehold.co/150x100/DBEAFE/1E40AF?text=Wrap+Ayam'],
            ['id' => 'df7', 'name' => 'Pasta Gandum Utuh dengan Pesto', 'calories' => 480, 'price' => 60000, 'image' => 'https://placehold.co/150x100/A7F3D0/065F46?text=Pasta+Pesto'],
            ['id' => 'df8', 'name' => 'Oatmeal Buah Beri', 'calories' => 250, 'price' => 28000, 'image' => 'https://placehold.co/150x100/FEE2E2/991B1B?text=Oatmeal'],
        ];

        // Ambil item keranjang dari sesi
        $cartItems = session('cart_items', []);
        
        // HITUNG totalCartPrice DI SINI
        $totalCartPrice = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // Jika pengguna memasukkan kalori manual dari form GET, gunakan itu
        if ($request->has('manual_calories')) {
            $manualCalories = (float)$request->input('manual_calories');
            if ($manualCalories > 0) {
                $calculatedCalories = $manualCalories; // Update kalori yang akan ditampilkan
                $request->session()->put('calculated_calories_for_order', $manualCalories); // Update juga di sesi
                session()->flash('message', 'Kebutuhan kalori diperbarui!');
            } else {
                session()->flash('message', 'Harap masukkan angka kalori yang valid.');
            }
        }

        // Teruskan semua variabel yang dibutuhkan ke view
        return view('diet-ordering', compact('calculatedCalories', 'dietFoodItems', 'cartItems', 'totalCartPrice'));
    }

    /**
     * Menambahkan item ke keranjang belanja (disimpan di sesi).
     */
    public function addToCart(Request $request)
    {
        $itemId = $request->input('item_id');
        $itemName = $request->input('item_name');
        $itemPrice = (float)$request->input('item_price');
        $itemCalories = (int)$request->input('item_calories'); // Jika perlu

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

    /**
     * Menampilkan halaman pembayaran dengan detail keranjang.
     */
    public function payment()
    {
        // Ambil item keranjang dari sesi untuk ditampilkan di halaman pembayaran
        $cartItems = session('cart_items', []);
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('payment', compact('cartItems', 'totalAmount'));
    }

    /**
     * Memproses pembayaran pesanan.
     */
    public function processPayment(Request $request)
    {
        $paymentMethod = $request->input('payment_method');
        $cartItems = $request->session()->get('cart_items', []);
        $totalAmount = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // --- Di sini Anda akan menambahkan logika pemrosesan pembayaran yang sebenarnya ---
        // Contoh: Simpan detail pesanan ke database
        // Order::create([
        //     'user_id' => Auth::id(),
        //     'items' => json_encode($cartItems),
        //     'total_amount' => $totalAmount,
        //     'payment_method' => $paymentMethod,
        //     'status' => 'pending', // atau 'completed'
        // ]);
        // --- Akhir logika pemrosesan pembayaran ---

        // Hapus keranjang setelah pembayaran berhasil
        $request->session()->forget('cart_items');

        return redirect()->route('mainMenu')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }

    /**
     * Menampilkan dan mengelola halaman profil pengguna.
     */
    public function account()
    {
        $user = Auth::user();
        // Anda bisa memuat data profil lengkap dari database di sini
        // Untuk contoh ini, menggunakan data mock yang mungkin diperbarui dari DB
        $profileData = [
            'fullName' => $user->name ?? 'Pengguna SIM',
            'username' => $user->email ? explode('@', $user->email)[0] : 'default_username', // Mengambil bagian email sebelum '@'
            'email' => $user->email ?? 'default@example.com',
            'phoneNumber' => '+62 81234567890', // Contoh data mock
            'profilePicture' => 'https://placehold.co/100x100/4DB6AC/FFFFFF?text=DC',
        ];

        // Jika Anda menyimpan data profil di tabel terpisah (misalnya 'user_profiles'), Anda akan memuatnya di sini
        // $userProfile = UserProfile::where('user_id', $user->id)->first();
        // if ($userProfile) {
        //     $profileData['fullName'] = $userProfile->full_name;
        //     $profileData['phoneNumber'] = $userProfile->phone_number;
        //     $profileData['profilePicture'] = $userProfile->profile_picture;
        // }
        
        return view('account', compact('user', 'profileData'));
    }

    /**
     * Memperbarui data profil pengguna.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Lakukan validasi input
            $request->validate([
                'fullName' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'phoneNumber' => 'nullable|string|max:20',
                'profilePicture' => 'nullable|url|max:255', // Tambahkan validasi untuk URL gambar
            ]);

           

            // Jika Anda memiliki tabel profil terpisah (misalnya UserProfile), Anda akan memperbarui di sana
            // $userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
            // $userProfile->full_name = $request->input('fullName');
            // $userProfile->phone_number = $request->input('phoneNumber');
            // $userProfile->profile_picture = $request->input('profilePicture');
            // $userProfile->save();

            return redirect()->route('account')->with('success', 'Profil berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Gagal memperbarui profil. Pengguna tidak terautentikasi.');
    }
}