@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Tambah Pelanggan
</h1>

<form
    id="customer-form"
    action="{{ route('customers.store') }}"
    method="POST"
    onsubmit="return validateCustomerForm(event)"
    class="bg-white p-10 rounded-3xl shadow space-y-6"
>

    @csrf

    <input
        type="text"
        name="nama"
        placeholder="Nama Pelanggan"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="email"
        name="email"
        placeholder="Email"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="nomor_hp"
        placeholder="Nomor HP"
        class="w-full border p-4 rounded-xl"
    >

    <textarea
        name="alamat"
        placeholder="Alamat"
        class="w-full border p-4 rounded-xl"
    ></textarea>

    <button
        class="bg-green-500 text-white px-8 py-4 rounded-2xl cursor-pointer"
    >
        Simpan Pelanggan
    </button>

</form>

<script>
function validateCustomerForm(event) {
    const name = document.getElementsByName('nama')[0].value.trim();
    const email = document.getElementsByName('email')[0].value.trim();
    const nomorHp = document.getElementsByName('nomor_hp')[0].value.trim();
    const alamat = document.getElementsByName('alamat')[0].value.trim();
    
    let errors = [];
    
    if (name === '') errors.push('Nama Pelanggan harus diisi.');
    if (email === '') {
        errors.push('Email harus diisi.');
    } else if (!validateEmail(email)) {
        errors.push('Format Email tidak valid.');
    }
    if (nomorHp === '') {
        errors.push('Nomor HP harus diisi.');
    } else if (!/^\d+$/.test(nomorHp)) {
        errors.push('Nomor HP hanya boleh berisi angka.');
    }
    if (alamat === '') errors.push('Alamat harus diisi.');
    
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

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
</script>

@endsection