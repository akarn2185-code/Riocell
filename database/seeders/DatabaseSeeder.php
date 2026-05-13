<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\SaldoInduk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN OWNER
        User::firstOrCreate(
            ['email' => 'owner@riocell.com'],
            [
                'name' => 'Owner Rio Cell',
                'phone' => '083113188047',
                'role' => 'owner',
                'password' => Hash::make('password123')
            ]
        );

        // 2. BUAT AKUN PELANGGAN (DUMMY)
        User::firstOrCreate(
            ['email' => 'budi@gmail.com'],
            [
                'name' => 'Budi Santoso',
                'phone' => '081234567891',
                'role' => 'pelanggan',
                'password' => Hash::make('password123')
            ]
        );

        // 3. INISIALISASI SALDO INDUK
        if (SaldoInduk::count() == 0) {
            SaldoInduk::create([
                'balance' => 5000000,
                'last_deposit' => 5000000,
                'last_deposit_at' => now()
            ]);
        }

        // 4. MASUKKAN BANYAK DATA PRODUK (TOTAL 31 PRODUK)
        
        // --- KATEGORI: PULSA (7 Produk) ---
        $this->createProduct('Pulsa Telkomsel 5.000', 'pulsa', 'digital', 5200, 7000, 0, 'Pulsa reguler Telkomsel menambah masa aktif');
        $this->createProduct('Pulsa Telkomsel 10.000', 'pulsa', 'digital', 10100, 12000, 0, 'Pulsa reguler Telkomsel menambah masa aktif');
        $this->createProduct('Pulsa Telkomsel 50.000', 'pulsa', 'digital', 49500, 51000, 0, 'Pulsa reguler Telkomsel menambah masa aktif');
        $this->createProduct('Pulsa Telkomsel 100.000', 'pulsa', 'digital', 98000, 100000, 0, 'Pulsa reguler Telkomsel menambah masa aktif');
        $this->createProduct('Pulsa Indosat 10.000', 'pulsa', 'digital', 10200, 12000, 0, 'Pulsa reguler Indosat Ooredoo');
        $this->createProduct('Pulsa Indosat 25.000', 'pulsa', 'digital', 24900, 27000, 0, 'Pulsa reguler Indosat Ooredoo');
        $this->createProduct('Pulsa XL/Axis 25.000', 'pulsa', 'digital', 24800, 27000, 0, 'Pulsa reguler XL atau Axis');

        // --- KATEGORI: PAKET DATA (8 Produk) ---
        $this->createProduct('Data Telkomsel 3GB (30 Hari)', 'paket_data', 'digital', 15000, 18000, 0, 'Kuota utama 3GB full 24 jam untuk 30 hari');
        $this->createProduct('Data Telkomsel 10GB (30 Hari)', 'paket_data', 'digital', 40000, 45000, 0, 'Kuota utama 10GB full 24 jam untuk 30 hari');
        $this->createProduct('Data Telkomsel 25GB (30 Hari)', 'paket_data', 'digital', 75000, 80000, 0, 'Kuota utama 25GB full 24 jam untuk 30 hari');
        $this->createProduct('Data Indosat Freedom 5GB', 'paket_data', 'digital', 20000, 25000, 0, 'Freedom Internet 5GB, 30 Hari');
        $this->createProduct('Data Indosat Freedom 15GB', 'paket_data', 'digital', 45000, 50000, 0, 'Freedom Internet 15GB, 30 Hari');
        $this->createProduct('Data XL Xtra Combo 15GB', 'paket_data', 'digital', 50000, 55000, 0, 'Xtra Combo VIP 15GB, 30 Hari');
        $this->createProduct('Data Tri (3) 10GB AON', 'paket_data', 'digital', 35000, 40000, 0, 'Always On 10GB Aktif Selamanya');
        $this->createProduct('Voucher Axis Aigo 5GB', 'paket_data', 'digital', 18000, 22000, 0, 'Kode voucher akan dikirim via Chat/WA');

        // --- KATEGORI: E-WALLET (6 Produk) ---
        $this->createProduct('Saldo DANA 20.000', 'e_wallet', 'digital', 20500, 22000, 0, 'Topup Saldo DANA langsung masuk');
        $this->createProduct('Saldo DANA 50.000', 'e_wallet', 'digital', 50500, 52000, 0, 'Topup Saldo DANA langsung masuk');
        $this->createProduct('Saldo DANA 100.000', 'e_wallet', 'digital', 100500, 102000, 0, 'Topup Saldo DANA langsung masuk');
        $this->createProduct('Saldo OVO 50.000', 'e_wallet', 'digital', 51000, 53000, 0, 'Topup Saldo OVO langsung masuk');
        $this->createProduct('Saldo GoPay 100.000', 'e_wallet', 'digital', 101000, 103000, 0, 'Topup Saldo GoPay Customer/Driver');
        $this->createProduct('Saldo ShopeePay 50.000', 'e_wallet', 'digital', 51000, 53000, 0, 'Topup Saldo ShopeePay untuk belanja');

        // --- KATEGORI: AKSESORIS (PRODUK FISIK) (10 Produk) ---
        $this->createProduct('Kabel Data Type-C Fast Charging 3A', 'aksesoris', 'fisik', 15000, 25000, 20, 'Kabel data tebal, support fast charging up to 3A');
        $this->createProduct('Kabel Data iPhone (Lightning) 20W', 'aksesoris', 'fisik', 25000, 45000, 15, 'Support PD Fast Charging untuk iPhone');
        $this->createProduct('Kepala Charger (Batok) 18W QC 3.0', 'aksesoris', 'fisik', 35000, 55000, 10, 'Kepala charger batok Quick Charge 3.0');
        $this->createProduct('Kepala Charger iPhone 20W USB-C', 'aksesoris', 'fisik', 45000, 75000, 8, 'Adaptor iPhone 20W Type C');
        
        // 3 PRODUK TAMBAHAN BARU:
        $this->createProduct('Powerbank Robot 10.000 mAh', 'aksesoris', 'fisik', 90000, 135000, 12, 'Powerbank original Robot, dual output USB, garansi 1 tahun.');
        $this->createProduct('TWS Bluetooth Earbuds V5.3', 'aksesoris', 'fisik', 65000, 110000, 8, 'Earphone nirkabel bluetooth, bass nendang, baterai awet 4 jam.');
        $this->createProduct('Ring Stand HP Besi / Holder', 'aksesoris', 'fisik', 4000, 10000, 35, 'Cincin pegangan HP bahan besi, bisa untuk stand nonton YouTube.');

        // Produk Fisik Stok Menipis (Untuk Peringatan)
        $this->createProduct('Tempered Glass Anti Spy', 'aksesoris', 'fisik', 10000, 25000, 4, 'Anti gores gelap dari samping. (Sebutkan tipe HP di catatan)');
        $this->createProduct('Softcase Silikon Bening / Anti Crack', 'aksesoris', 'fisik', 8000, 15000, 2, 'Case transparan melindungi sudut HP dari benturan.');
        
        // Produk Fisik Stok Habis (Untuk Testing Disable Button)
        $this->createProduct('Earphone / Headset Super Bass', 'aksesoris', 'fisik', 15000, 35000, 0, 'Headset kabel jack 3.5mm, suara jernih dan bass mantap.');
    }

    /**
     * Fungsi bantuan agar penulisan seeder tidak panjang
     */
    private function createProduct($name, $category, $type, $buyPrice, $sellPrice, $stock, $description)
    {
        Product::firstOrCreate(
            ['name' => $name], // Cek agar tidak duplikat jika di-seed 2 kali
            [
                'category' => $category,
                'type' => $type,
                'buy_price' => $buyPrice,
                'sell_price' => $sellPrice,
                'stock' => $stock,
                'description' => $description,
                'is_active' => true,
            ]
        );
    }
}