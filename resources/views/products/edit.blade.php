@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Edit Produk
</h1>

<form
    action="{{ route('products.update', $product->id) }}"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white p-10 rounded-3xl shadow space-y-6"
>

    @csrf
    @method('PUT')

    <input
        type="text"
        name="kode_produk"
        value="{{ $product->kode_produk }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="nama_produk"
        value="{{ $product->nama_produk }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="harga"
        value="{{ $product->harga }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="stok"
        value="{{ $product->stok }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="kategori"
        value="{{ $product->kategori }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="file"
        name="gambar"
        class="w-full border p-4 rounded-xl"
    >

    @if($product->gambar)

        <img
            src="{{ asset('storage/'.$product->gambar) }}"
            class="w-32 rounded-2xl"
        >

    @endif

    <button
        class="bg-blue-500 text-white px-8 py-4 rounded-2xl"
    >
        Update Produk
    </button>

</form>

@endsection