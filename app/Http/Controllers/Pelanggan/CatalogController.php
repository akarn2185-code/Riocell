<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Pencarian berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // PERBAIKAN: Sekarang menggunakan paginate(10) agar pas 10 produk per halaman
        $products = $query->latest()->paginate(10);
        
        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris'
        ];

        return view('pelanggan.catalog', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Pastikan nama view ini sesuai dengan file detail produk di folder pelanggan
        return view('pelanggan.catalog-detail', compact('product'));
    }
}