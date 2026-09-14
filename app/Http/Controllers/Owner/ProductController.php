<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting: Untuk menghapus file lama

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->get();

        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris'
        ];

        return view('owner.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris'
        ];

        return view('owner.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:pulsa,paket_data,e_wallet,aksesoris',
            'type' => 'required|in:digital,fisik',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi Foto
        ]);

        $data = $request->only(['name', 'category', 'type', 'buy_price', 'sell_price', 'stock', 'description']);
        $data['is_active'] = $request->has('is_active');

        // Logika Simpan Foto
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data['image'] = $image->store('products', 'public');
            $data['image_data'] = base64_encode($image->getContent());
            $data['image_mime'] = $image->getMimeType();
        }

        Product::create($data);

        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris'
        ];

        return view('owner.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:pulsa,paket_data,e_wallet,aksesoris',
            'type' => 'required|in:digital,fisik',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi Foto
        ]);

        $data = $request->only(['name', 'category', 'type', 'buy_price', 'sell_price', 'stock', 'description']);
        $data['is_active'] = $request->has('is_active');

        // Logika Update Foto
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada di storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan file lokal dan salinannya agar tetap tersedia setelah deploy ulang.
            $image = $request->file('image');
            $data['image'] = $image->store('products', 'public');
            $data['image_data'] = base64_encode($image->getContent());
            $data['image_mime'] = $image->getMimeType();
        }

        $product->update($data);

        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        // Hapus foto dari storage sebelum data di database dihapus
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('owner.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}