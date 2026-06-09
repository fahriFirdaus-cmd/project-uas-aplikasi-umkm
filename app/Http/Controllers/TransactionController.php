<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BELI PRODUK
    |--------------------------------------------------------------------------
    */

    public function beli($id)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL PRODUK
        |--------------------------------------------------------------------------
        */

        $product = Product::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CEK STOK
        |--------------------------------------------------------------------------
        */

        if ($product->stok <= 0) {

            return back()->with('error', 'Stok habis');

        }

        /*
        |--------------------------------------------------------------------------
        | KURANGI STOK
        |--------------------------------------------------------------------------
        */

        $product->stok -= 1;

        $product->save();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        */

        Transaction::create([

            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            'user_id' => Auth::id(),

            /*
            |--------------------------------------------------------------------------
            | CUSTOMER
            |--------------------------------------------------------------------------
            */

            'customer_id' => \App\Models\Customer::where('id', Auth::id())->exists()
                ? Auth::id()
                : (\App\Models\Customer::first()?->id ?? Auth::id()),

            /*
            |--------------------------------------------------------------------------
            | PRODUCT
            |--------------------------------------------------------------------------
            */

            'product_id' => $product->id,

            /*
            |--------------------------------------------------------------------------
            | INVOICE
            |--------------------------------------------------------------------------
            */

            'nomor_invoice' => 'INV-' . rand(1000,9999),

            /*
            |--------------------------------------------------------------------------
            | TANGGAL TRANSAKSI
            |--------------------------------------------------------------------------
            */

            'tanggal_transaksi' => now(),

            /*
            |--------------------------------------------------------------------------
            | PELANGGAN
            |--------------------------------------------------------------------------
            */

            'pelanggan' => Auth::user()->name,

            /*
            |--------------------------------------------------------------------------
            | JUMLAH
            |--------------------------------------------------------------------------
            */

            'qty' => 1,

            /*
            |--------------------------------------------------------------------------
            | TOTAL HARGA
            |--------------------------------------------------------------------------
            */

            'total_harga' => $product->harga,

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            'status' => 'dibeli',

            /*
            |--------------------------------------------------------------------------
            | STATUS PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            'status_pembayaran' => 'Lunas'

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect('/my-orders')

            ->with('success', 'Produk berhasil dibeli');
    }

    /*
    |--------------------------------------------------------------------------
    | BELI PRODUK (AJAX)
    |--------------------------------------------------------------------------
    | Fitur ini melayani request AJAX untuk pembelian produk tanpa reload halaman.
    |
    */

    public function beliAjax($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis!'
            ], 400);
        }

        $product->stok -= 1;
        $product->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'customer_id' => \App\Models\Customer::where('id', Auth::id())->exists()
                ? Auth::id()
                : (\App\Models\Customer::first()?->id ?? Auth::id()),
            'product_id' => $product->id,
            'nomor_invoice' => 'INV-' . rand(1000,9999),
            'tanggal_transaksi' => now(),
            'pelanggan' => Auth::user()->name,
            'qty' => 1,
            'total_harga' => $product->harga,
            'status' => 'dibeli',
            'status_pembayaran' => 'Lunas'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ' . $product->nama_produk . ' berhasil dibeli!',
            'stok' => $product->stok,
            'total_stok_semua' => Product::sum('stok')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function myOrders()
    {
        $transactions = Transaction::with('product')

            ->where('user_id', Auth::id())

            ->latest()

            ->get();

        return view('orders.index', compact('transactions'));
    }
}