@extends('layouts.app')

@section('content')

<div class="mb-10">

    <h1 class="text-6xl font-bold text-slate-800">
        Dashboard UMKM
    </h1>

    <p class="text-2xl text-gray-500 mt-2">
        Kelola produk UMKM modern
    </p>

</div>

<!-- CARD STATISTIK -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <!-- TOTAL PRODUK -->

    <div class="bg-white rounded-3xl shadow p-8">

        <h2 class="text-3xl text-gray-500 mb-5">
            Total Produk
        </h2>

        <h1 class="text-6xl font-bold text-green-500">
            {{ $totalProduk }}
        </h1>

    </div>

    <!-- TOTAL PELANGGAN -->

    <div class="bg-white rounded-3xl shadow p-8">

        <h2 class="text-3xl text-gray-500 mb-5">
            Total Pelanggan
        </h2>

        <h1 class="text-6xl font-bold text-blue-500">
            {{ $totalPelanggan }}
        </h1>

    </div>

    <!-- TOTAL PENJUALAN -->

    <div class="bg-white rounded-3xl shadow p-8">

        <h2 class="text-3xl text-gray-500 mb-5">
            Total Penjualan
        </h2>

        <h1 class="text-6xl font-bold text-pink-500">
            {{ $totalPenjualan }}
        </h1>

    </div>

    <!-- TOTAL PENDAPATAN -->

    <div class="bg-white rounded-3xl shadow p-8">

        <h2 class="text-3xl text-gray-500 mb-5">
            Total Pendapatan
        </h2>

        <h1 class="text-4xl font-bold text-yellow-500">
            Rp {{ number_format($totalPendapatan) }}
        </h1>

    </div>

</div>

<!-- BUTTON TAMBAH PRODUK -->

<a href="{{ route('products.create') }}"
   class="bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-2xl text-2xl shadow">

    + Tambah Produk

</a>

<!-- TABLE PRODUK -->

<div class="bg-white rounded-3xl shadow overflow-x-auto mt-10">

    <table class="w-full">

        <thead class="bg-green-500 text-white">

            <tr>

                <th class="p-5">No</th>

                <th>Kode</th>

                <th>Nama</th>

                <th>Harga</th>

                <th>Stok</th>

                <th>Kategori</th>

                <th>Gambar</th>

                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($products as $product)

            <tr class="text-center border-b">

                <!-- NO -->

                <td class="p-5">
                    {{ $loop->iteration }}
                </td>

                <!-- KODE -->

                <td>
                    {{ $product->kode_produk }}
                </td>

                <!-- NAMA -->

                <td>
                    {{ $product->nama_produk }}
                </td>

                <!-- HARGA -->

                <td>
                    Rp {{ number_format($product->harga) }}
                </td>

                <!-- STOK -->

                <td>
                    {{ $product->stok }}
                </td>

                <!-- KATEGORI -->

                <td>
                    {{ $product->kategori }}
                </td>

                <!-- GAMBAR -->

                <td class="p-5">

                    @if($product->gambar)

                        <img src="{{ asset('storage/' . $product->gambar) }}"
                             class="w-20 h-20 object-cover rounded-xl mx-auto">

                    @else

                        Tidak ada gambar

                    @endif

                </td>

                <!-- AKSI -->

                <td>

                    <div class="flex justify-center gap-2">

                        <!-- EDIT -->

                        <a href="{{ route('products.edit', $product->id) }}"
                           class="bg-blue-500 text-white px-5 py-2 rounded-xl">

                            Edit

                        </a>

                        <!-- HAPUS -->

                        <form action="{{ route('products.destroy', $product->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-5 py-2 rounded-xl">

                                Hapus

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="p-10 text-center">

                    Belum ada data produk

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection