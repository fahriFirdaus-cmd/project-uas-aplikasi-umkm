@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Data Pelanggan
</h1>

<div class="mt-10 flex flex-col sm:flex-row justify-between items-center gap-4">
    <a
        href="/customers/create"
        class="bg-green-500 text-white px-8 py-4 rounded-2xl shadow transition inline-block text-center"
    >
        + Tambah Pelanggan
    </a>

    <div class="relative w-full sm:w-80">
        <input 
            type="text" 
            id="search-customer" 
            placeholder="Cari nama, email, nomor HP..." 
            class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-3 text-sm outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition shadow-sm"
        >
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
            🔍
        </span>
    </div>
</div>

<div class="bg-white rounded-3xl shadow mt-10">
    <div class="overflow-x-auto">
        <table class="w-full" id="customer-table">

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

</div>

<script>
// Pencarian Real-time untuk Tabel Pelanggan
document.getElementById('search-customer')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#customer-table tbody tr');
    
    rows.forEach(row => {
        if (row.cells.length === 1 && row.cells[0].colSpan === 6) {
            return;
        }
        
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});

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