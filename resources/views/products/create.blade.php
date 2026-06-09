@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Tambah Produk
</h1>

<form
    id="product-form"
    action="{{ route('products.store') }}"
    method="POST"
    enctype="multipart/form-data"
    onsubmit="return validateProductForm(event)"
    class="bg-white p-10 rounded-3xl shadow space-y-6"
>

    @csrf

    <input
        type="text"
        name="kode_produk"
        placeholder="Kode Produk"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="nama_produk"
        placeholder="Nama Produk"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="harga"
        placeholder="Harga"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="number"
        name="stok"
        placeholder="Stok"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="kategori"
        placeholder="Kategori"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="file"
        name="gambar"
        class="w-full border p-4 rounded-xl"
    >

    <button
        class="bg-green-500 text-white px-8 py-4 rounded-2xl cursor-pointer"
    >
        Simpan Produk
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
            confirmButtonColor: '#10b981'
        });
        return false;
    }
    return true;
}
</script>

@endsection