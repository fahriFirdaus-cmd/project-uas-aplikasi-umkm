@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Edit Pelanggan
</h1>

<form
    action="{{ route('customers.update', $customer->id) }}"
    method="POST"
    class="bg-white p-10 rounded-3xl shadow space-y-6"
>

    @csrf
    @method('PUT')

    <input
        type="text"
        name="nama"
        value="{{ $customer->nama }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="email"
        name="email"
        value="{{ $customer->email }}"
        class="w-full border p-4 rounded-xl"
    >

    <input
        type="text"
        name="nomor_hp"
        value="{{ $customer->nomor_hp }}"
        class="w-full border p-4 rounded-xl"
    >

    <textarea
        name="alamat"
        class="w-full border p-4 rounded-xl"
    >{{ $customer->alamat }}</textarea>

    <button
        class="bg-blue-500 text-white px-8 py-4 rounded-2xl"
    >
        Update Pelanggan
    </button>

</form>

@endsection