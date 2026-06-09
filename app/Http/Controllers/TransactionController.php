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
        |
        */

        $product = Product::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | CEK STOK
        |--------------------------------------------------------------------------
        |
        */

        if ($product->stok <= 0) {

            return back()->with('error', 'Stok habis');

        }

        /*
        |--------------------------------------------------------------------------
        | CEK PELANGGAN
        |--------------------------------------------------------------------------
        |
        */

        if (\App\Models\Customer::count() == 0) {

            return redirect('/customers/create')->with('error', 'Silakan tambah pelanggan terlebih dahulu.');

        }

        $customer = \App\Models\Customer::first();

        /*
        |--------------------------------------------------------------------------
        | KURANGI STOK
        |--------------------------------------------------------------------------
        |
        */

        $product->stok -= 1;

        $product->save();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN TRANSAKSI
        |--------------------------------------------------------------------------
        |
        */

        Transaction::create([

            'user_id' => Auth::id(),

            'customer_id' => $customer->id,

            'product_id' => $product->id,

            'nomor_invoice' => 'INV-' . rand(1000,9999),

            'tanggal_transaksi' => now(),

            'pelanggan' => $customer->nama,

            'qty' => 1,

            'total_harga' => $product->harga,

            'status' => 'dibeli',

            'status_pembayaran' => 'Lunas'

        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        |
        */

        return redirect('/my-orders')

            ->with('success', 'Produk berhasil dibeli');
    }

    /*
    |--------------------------------------------------------------------------
    | BELI PRODUK (AJAX)
    |--------------------------------------------------------------------------
    | Fitur ini melayani request AJAX untuk pembelian produk tanpa reload halaman.
    | Jika pelanggan belum ada, mengembalikan response agar form input pelanggan ditampilkan.
    |
    */

    public function beliAjax(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis!'
            ], 400);
        }

        // Cek jika database belum memiliki data pelanggan sama sekali
        if (\App\Models\Customer::count() == 0 && !$request->has('nama')) {
            return response()->json([
                'success' => false,
                'needs_customer' => true,
                'message' => 'Belum ada data pelanggan di database. Silakan lengkapi data pelanggan baru untuk melanjutkan pembelian.'
            ]);
        }

        $customerId = null;
        $customerName = Auth::user()->name;

        // Jika request membawa data pelanggan baru
        if ($request->has('nama')) {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email',
                'nomor_hp' => 'required|string',
                'alamat' => 'required|string',
            ]);

            $customer = \App\Models\Customer::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => $request->alamat,
            ]);

            $customerId = $customer->id;
            $customerName = $customer->nama;
        } else {
            $customer = \App\Models\Customer::first();
            if ($customer) {
                $customerId = $customer->id;
                $customerName = $customer->nama;
            }
        }

        $product->stok -= 1;
        $product->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'customer_id' => $customerId,
            'product_id' => $product->id,
            'nomor_invoice' => 'INV-' . rand(1000,9999),
            'tanggal_transaksi' => now(),
            'pelanggan' => $customerName,
            'qty' => 1,
            'total_harga' => $product->harga,
            'status' => 'dibeli',
            'status_pembayaran' => 'Lunas'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ' . $product->nama_produk . ' berhasil dibeli!',
            'stok' => $product->stok,
            'total_stok_semua' => Product::sum('stok'),
            'total_penjualan' => Transaction::count(),
            'total_pendapatan' => Transaction::sum('total_harga')
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