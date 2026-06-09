<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PRODUK
        |--------------------------------------------------------------------------
        */

        $totalProduk = Product::count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PELANGGAN
        |--------------------------------------------------------------------------
        */

        $totalPelanggan = Customer::count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENJUALAN
        |--------------------------------------------------------------------------
        */

        $totalPenjualan = Transaction::count();

        /*
        |--------------------------------------------------------------------------
        | TOTAL PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $totalPendapatan = Transaction::sum('total_harga');

        /*
        |--------------------------------------------------------------------------
        | PRODUK
        |--------------------------------------------------------------------------
        */

        $products = Product::latest()->get();

        return view('dashboard', compact(

            'totalProduk',
            'totalPelanggan',
            'totalPenjualan',
            'totalPendapatan',
            'products'

        ));
    }
}