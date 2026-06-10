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
        | BACA & CEK QTY
        |--------------------------------------------------------------------------
        |
        */

        $qty = intval(request('qty', 1));
        if ($qty < 1) {
            return back()->with('error', 'Jumlah pembelian minimal 1');
        }

        /*
        |--------------------------------------------------------------------------
        | CEK STOK
        |--------------------------------------------------------------------------
        |
        */

        if ($product->stok < $qty) {

            return back()->with('error', 'Stok tidak mencukupi');

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

        $product->stok -= $qty;

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

            'qty' => $qty,

            'total_harga' => $product->harga * $qty,

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

        $qty = intval($request->input('qty', 1));
        if ($qty < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah pembelian minimal 1!'
            ], 400);
        }

        if ($product->stok < $qty) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk tidak mencukupi! Stok tersedia: ' . $product->stok
            ], 400);
        }

        // Selalu wajibkan data diri checkout pelanggan
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_hp' => 'required|string|max:50',
            'alamat' => 'required|string',
        ]);

        // Simpan atau update data pelanggan berdasarkan email
        $customer = \App\Models\Customer::updateOrCreate(
            ['email' => $request->email],
            [
                'nama' => $request->nama,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => $request->alamat,
            ]
        );

        $product->stok -= $qty;
        $product->save();

        Transaction::create([
            'user_id' => Auth::id(),
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'nomor_invoice' => 'INV-' . rand(1000,9999),
            'tanggal_transaksi' => now(),
            'pelanggan' => $customer->nama,
            'qty' => $qty,
            'total_harga' => $product->harga * $qty,
            'status' => 'dibeli',
            'status_pembayaran' => 'Lunas'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ' . $product->nama_produk . ' sebanyak ' . $qty . ' pcs berhasil dibeli atas nama ' . $customer->nama . '!',
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