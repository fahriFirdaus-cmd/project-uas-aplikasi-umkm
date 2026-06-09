@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Edit Produk
</h1>

<form
    id="product-form"
    action="{{ route('products.update', $product->id) }}"
    method="POST"
    enctype="multipart/form-data"
    onsubmit="return validateProductForm(event)"
    class="bg-white p-10 rounded-3xl shadow space-y-6"
>

    @csrf
    @method('PUT')

    <input
        type="text"
        name="kode_produk"
        value="{{ $product->kode_produk }}"
        placeholder="Kode Produk"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="nama_produk"
        value="{{ $product->nama_produk }}"
        placeholder="Nama Produk"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="harga"
        value="{{ $product->harga }}"
        placeholder="Harga"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="stok"
        value="{{ $product->stok }}"
        placeholder="Stok"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="kategori"
        value="{{ $product->kategori }}"
        placeholder="Kategori"
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
        class="bg-blue-500 text-white px-8 py-4 rounded-2xl cursor-pointer"
    >
        Update Produk
    </button>

</form>

<script>
function validateProductForm(event) {
    const kode = document.getElementsByName('kode_produk')[0].value.trim();
    const nama = document.getElementsByName('nama_produk')[0].value.trim();
    const harga = document.getElementsByName('harga')[0].value.trim();
    const stok = document.getElementsByName('stok')[0].value.trim();
    const kategori = document.getElementsByName('kategori')[0].value.trim();
    
    let errors = [];
    
    if (kode === '') errors.push('Kode Produk harus diisi.');
    if (nama === '') errors.push('Nama Produk harus diisi.');
    if (harga === '') {
        errors.push('Harga harus diisi.');
    } else if (isNaN(harga) || parseFloat(harga) <= 0) {
        errors.push('Harga harus berupa angka positif.');
    }
    if (stok === '') {
        errors.push('Stok harus diisi.');
    } else if (isNaN(stok) || parseInt(stok) < 0) {
        errors.push('Stok tidak boleh bernilai negatif.');
    }
    if (kategori === '') errors.push('Kategori harus diisi.');
    
    if (errors.length > 0) {
        event.preventDefault();
        Swal.fire({
            title: 'Kesalahan Validasi',
            html: `<ul class="text-left list-disc pl-5 space-y-1">${errors.map(err => `<li>${err}</li>`).join('')}</ul>`,
            icon: 'error',
            confirmButtonColor: '#3b82f6'
        });
        return false;
    }
    return true;
}
</script>

@endsection