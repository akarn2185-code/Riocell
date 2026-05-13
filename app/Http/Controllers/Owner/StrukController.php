<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    /**
     * Preview struk transaksi
     */
    public function preview(Transaction $transaction)
    {
        $transaction->load('product');
        return view('owner.struk.preview', compact('transaction'));
    }

    /**
     * Download struk sebagai PDF
     */
    public function download(Transaction $transaction)
    {
        $transaction->load('product');
        
        $pdf = Pdf::loadView('owner.struk.template', compact('transaction'))
            ->setPaper([0, 0, 226.77, 566.93], 'portrait'); // Ukuran kertas thermal 80mm
        
        $filename = 'Struk-' . $transaction->id . '-' . date('YmdHis') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Print struk (view untuk print)
     */
    public function print(Transaction $transaction)
    {
        $transaction->load('product');
        return view('owner.struk.print', compact('transaction'));
    }
}