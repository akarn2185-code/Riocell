<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    /**
     * Tampilkan daftar produk untuk public (tanpa perlu login)
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $category = $request->input('category', '');
        
        $query = Product::where('is_active', true);
        
        // Filter berdasarkan kategori
        if ($category) {
            $query->where('category', $category);
        }
        
        // Filter berdasarkan pencarian nama
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }
        
        // Urutkan dan paginate
        $products = $query->orderBy('name', 'asc')->paginate(12);
        
        // Ambil daftar kategori untuk filter
        $categories = Product::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();
        
        // Label kategori untuk tampilan
        $categoryLabels = [
            'pulsa' => '📱 Pulsa',
            'paket_data' => '📊 Paket Data',
            'e_wallet' => '💳 E-Wallet',
            'aksesoris' => '🎧 Aksesoris'
        ];
        
        return view('public.products.index', compact(
            'products',
            'categories',
            'categoryLabels',
            'search',
            'category'
        ));
    }
    
    /**
     * Tampilkan detail produk
     */
    public function show(Product $product)
    {
        // Pastikan produk aktif
        if (!$product->is_active) {
            abort(404);
        }
        
        // Ambil produk terkait (kategori yang sama)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        $categoryLabels = [
            'pulsa' => '📱 Pulsa',
            'paket_data' => '📊 Paket Data',
            'e_wallet' => '💳 E-Wallet',
            'aksesoris' => '🎧 Aksesoris'
        ];
        
        return view('public.products.show', compact(
            'product',
            'relatedProducts',
            'categoryLabels'
        ));
    }
}
