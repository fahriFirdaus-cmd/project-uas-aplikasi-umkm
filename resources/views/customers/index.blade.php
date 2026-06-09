@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Data Pelanggan
</h1>

<a
    href="/customers/create"
    class="bg-green-500 text-white px-8 py-4 rounded-2xl"
>
    + Tambah Pelanggan
</a>

<div class="bg-white rounded-3xl shadow mt-10 overflow-x-auto">

<table class="w-full">

    <thead class="bg-green-500 text-white">

        <tr>

            <th class="p-5">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

        @forelse($customers as $customer)

        <tr class="text-center border-b">

            <td class="p-5">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $customer->nama }}
            </td>

            <td>
                {{ $customer->email }}
            </td>

            <td>
                {{ $customer->nomor_hp }}
            </td>

            <td>
                {{ $customer->alamat }}
            </td>

            <td class="space-x-2">

                <a
                    href="{{ route('customers.edit', $customer->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-xl"
                >
                    Edit
                </a>

                <form
                    action="{{ route('customers.destroy', $customer->id) }}"
                    method="POST"
                    class="inline"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="button"
                        onclick="confirmDelete(event, '{{ $customer->nama }}')"
                        class="bg-red-500 text-white px-4 py-2 rounded-xl cursor-pointer"
                    >
                        Hapus
                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6" class="p-10 text-center">

                Belum ada data pelanggan

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

<script>
function confirmDelete(event, name) {
    event.preventDefault();
    const form = event.target.closest('form');
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Pelanggan "${name}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>

@endsection