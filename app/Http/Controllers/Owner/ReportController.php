<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal: bulan ini
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Query transaksi
        $transactions = Transaction::with('product')
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik
        $totalOmzet = $transactions->sum('sell_price');
        $totalModal = $transactions->sum('buy_price');
        $totalProfit = $transactions->sum('profit');
        $totalTransactions = $transactions->count();

        // ----------------------------------------------------
        // PERBAIKAN: Statistik per kategori (Tangani "Unknown")
        // ----------------------------------------------------
        $categoryStats = $transactions->groupBy(function ($item) {
            // Jika produk tidak ada (Tukar Saldo), kembalikan 'tukar_saldo'
            if (!$item->product) {
                return 'tukar_saldo';
            }
            return $item->product->category;
        })->map(function ($items) {
            return [
                'count' => $items->count(),
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
            ];
        });

        // Statistik per hari (untuk chart garis)
        $dailyStats = $transactions->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($items) {
            return [
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
                'count' => $items->count(),
            ];
        })->sortKeys();

        // Top Products
        $topProducts = $transactions->groupBy('product_id')->map(function ($items) {
            $product = $items->first()->product;
            
            // Tangani nama untuk produk null (Tukar Saldo)
            $name = $product ? $product->name : 'Jasa Tukar Saldo E-Wallet';
            $category = $product ? $product->category : 'tukar_saldo';

            return [
                'name' => $name,
                'category' => $category,
                'count' => $items->count(),
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
            ];
        })->sortByDesc('count')->take(5);

        // Tambahkan 'tukar_saldo' ke daftar alias kategori
        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris',
            'tukar_saldo' => 'Jasa Tukar Saldo'
        ];

        $chartDailyLabels = $dailyStats->keys()->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $chartDailyOmzet = $dailyStats->pluck('omzet')->toArray();
        $chartDailyProfit = $dailyStats->pluck('profit')->toArray();

        $chartCategoryLabels = $categoryStats->keys()->map(function ($k) use ($categories) {
            return $categories[$k] ?? ucfirst($k);
        })->toArray();
        $chartCategoryOmzet = $categoryStats->pluck('omzet')->toArray();

        $chartProductLabels = $topProducts->pluck('name')->toArray();
        $chartProductCounts = $topProducts->pluck('count')->toArray();

        $chartCategoryColors = $categoryStats->keys()->map(function ($k) {
            if ($k == 'pulsa') return '#ef4444';
            if ($k == 'paket_data') return '#3b82f6';
            if ($k == 'e_wallet') return '#10b981';
            if ($k == 'aksesoris') return '#8b5cf6';
            if ($k == 'tukar_saldo') return '#f59e0b';
            return '#6b7280';
        })->toArray();

        return view('owner.reports.index', compact(
            'transactions',
            'totalOmzet',
            'totalModal',
            'totalProfit',
            'totalTransactions',
            'categoryStats',
            'dailyStats',
            'topProducts',
            'categories',
            'startDate',
            'endDate',
            'chartDailyLabels',
            'chartDailyOmzet',
            'chartDailyProfit',
            'chartCategoryLabels',
            'chartCategoryOmzet',
            'chartCategoryColors',
            'chartProductLabels',
            'chartProductCounts'
        ));
    }

    public function print(Request $request)
    {
        $data = $this->prepareReportData($request);
        return view('owner.reports.print', $data);
    }

    public function download(Request $request)
    {
        $data = $this->prepareReportData($request);

        $pdf = Pdf::loadView('owner.reports.print', $data)
            ->setPaper('a4', 'landscape');

        $filename = 'Laporan_Keuangan_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($filename);
    }

    private function prepareReportData(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        $transactions = Transaction::with('product')
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalOmzet = $transactions->sum('sell_price');
        $totalModal = $transactions->sum('buy_price');
        $totalProfit = $transactions->sum('profit');
        $totalTransactions = $transactions->count();

        $categoryStats = $transactions->groupBy(function ($item) {
            return $item->product ? $item->product->category : 'tukar_saldo';
        })->map(function ($items) {
            return [
                'count' => $items->count(),
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
            ];
        });

        $dailyStats = $transactions->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($items) {
            return [
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
                'count' => $items->count(),
            ];
        })->sortKeys();

        $topProducts = $transactions->groupBy('product_id')->map(function ($items) {
            $product = $items->first()->product;
            return [
                'name' => $product ? $product->name : 'Jasa Tukar Saldo E-Wallet',
                'category' => $product ? $product->category : 'tukar_saldo',
                'count' => $items->count(),
                'omzet' => $items->sum('sell_price'),
                'profit' => $items->sum('profit'),
            ];
        })->sortByDesc('count')->take(5);

        $categories = [
            'pulsa' => 'Pulsa',
            'paket_data' => 'Paket Data',
            'e_wallet' => 'E-Wallet',
            'aksesoris' => 'Aksesoris',
            'tukar_saldo' => 'Jasa Tukar Saldo'
        ];

        $chartDailyLabels = $dailyStats->keys()->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $chartDailyOmzet = $dailyStats->pluck('omzet')->toArray();
        $chartDailyProfit = $dailyStats->pluck('profit')->toArray();

        $chartCategoryLabels = $categoryStats->keys()->map(function ($k) use ($categories) {
            return $categories[$k] ?? ucfirst($k);
        })->toArray();
        $chartCategoryOmzet = $categoryStats->pluck('omzet')->toArray();

        $chartProductLabels = $topProducts->pluck('name')->toArray();
        $chartProductCounts = $topProducts->pluck('count')->toArray();

        $chartCategoryColors = $categoryStats->keys()->map(function ($k) {
            if ($k == 'pulsa') return '#ef4444';
            if ($k == 'paket_data') return '#3b82f6';
            if ($k == 'e_wallet') return '#10b981';
            if ($k == 'aksesoris') return '#8b5cf6';
            if ($k == 'tukar_saldo') return '#f59e0b';
            return '#6b7280';
        })->toArray();

        return compact(
            'transactions',
            'totalOmzet',
            'totalModal',
            'totalProfit',
            'totalTransactions',
            'categoryStats',
            'dailyStats',
            'topProducts',
            'categories',
            'startDate',
            'endDate',
            'chartDailyLabels',
            'chartDailyOmzet',
            'chartDailyProfit',
            'chartCategoryLabels',
            'chartCategoryOmzet',
            'chartCategoryColors',
            'chartProductLabels',
            'chartProductCounts'
        );
    }
}