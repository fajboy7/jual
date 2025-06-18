<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan model Product di-import
use Illuminate\Support\Facades\Auth; // Pastikan facade Auth di-import
use Illuminate\Validation\Rule; // Tambahkan ini untuk aturan validasi yang lebih kompleks
use Illuminate\Support\Str; // Untuk slug, jika ingin menambahkan

class ProductController extends Controller
{
    // Konstruktor untuk menerapkan middleware jika diperlukan untuk semua aksi di controller ini
    public function __construct()
    {
        // Contoh: Hanya admin/seller yang bisa akses create, store, edit, update, destroy
        // Ini redundant jika sudah dihandle di routes/web.php dengan middleware group
        // $this->middleware('auth')->except(['index', 'show']);
        // $this->middleware('can:isAdmin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // Menampilkan semua produk
    public function index()
    {
        $products = Product::latest()->get(); // Mengambil produk terbaru berdasarkan created_at
        return view('products.index', compact('products'));
    }

    // Form tambah produk (khusus admin/penjual)
    public function create()
    {
        // Pastikan pengguna terotentikasi dan memiliki hak akses (misal: 'isAdmin') sebelum menampilkan form
        // Ini sudah dihandle di routes/web.php, tapi baik juga untuk pengecekan di controller
        // if (!Auth::check() || !Auth::user()->hasRole('admin')) { // Contoh jika pakai kolom 'role' atau method hasRole()
        //     abort(403, 'Unauthorized action.');
        // }
        return view('products.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        // 1. Validasi Input: Lebih lengkap dan robust
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products')], // Nama produk harus unik
            'price' => 'required|numeric|min:0', // Harga harus numerik dan tidak negatif
            'description' => 'required|string', // Deskripsi wajib diisi
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Untuk upload gambar, maksimal 2MB
            'demo_url' => 'nullable|url', // Harus berupa URL jika diisi
            'gdrive_link' => 'nullable|url', // Harus berupa URL jika diisi
        ], [
            // Custom pesan error (opsional)
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Nama produk ini sudah ada. Mohon gunakan nama lain.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'demo_url.url' => 'URL Demo tidak valid.',
            'gdrive_link.url' => 'Link Google Drive tidak valid.',
        ]);

        // 2. Penanganan Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
            // 'product_images' adalah nama folder di dalam storage/app/public
            // 'public' adalah disk storage yang digunakan (konfigurasi di config/filesystems.php)
            // Pastikan Anda sudah menjalankan 'php artisan storage:link'
        }

        // 3. Simpan Produk ke Database
        // Pastikan semua kolom ini ada di $fillable di model Product
        $product = Product::create([
            'seller_id' => Auth::id(), // ID pengguna yang sedang login
            'name' => $request->name,
            // 'slug' => Str::slug($request->name), // Contoh: jika Anda ingin menambahkan slug dari nama produk
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Simpan path gambar yang sudah diupload
            'demo_url' => $request->demo_url,
            'gdrive_link' => $request->gdrive_link,
            // Kolom lain jika ada, misalnya 'stock', 'category_id', dll.
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('products.index')->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');
    }

    // Detail produk
    public function show(Product $product) // Route Model Binding: Laravel otomatis mencari produk berdasarkan ID di URL
    {
        // Pastikan Anda memiliki view products.show
        return view('products.show', compact('product'));
    }

    // Anda bisa menambahkan metode edit, update, destroy di sini
    // public function edit(Product $product) { ... }
    // public function update(Request $request, Product $product) { ... }
    // public function destroy(Product $product) { ... }
}