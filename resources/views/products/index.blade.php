@extends('layouts.app')

@section('content')

<h1 class="text-6xl font-bold text-slate-800">
    Dashboard UMKM
</h1>

<p class="text-2xl text-gray-500 mt-2">
    Kelola produk UMKM modern
</p>

<!-- STATISTIK -->
<div class="grid grid-cols-3 gap-8 mt-10">

    <!-- TOTAL PRODUK -->
    <div class="bg-white p-10 rounded-3xl shadow hover:scale-105 transition duration-300">

        <h2 class="text-3xl text-gray-500">
            Total Produk
        </h2>

        <p class="text-7xl font-bold text-green-500 mt-5">
            {{ $totalProduk }}
        </p>

    </div>

    <!-- TOTAL STOK -->
    <div class="bg-white p-10 rounded-3xl shadow hover:scale-105 transition duration-300">

        <h2 class="text-3xl text-gray-500">
            Total Stok
        </h2>

        <p class="text-7xl font-bold text-blue-500 mt-5" id="total-stok-display">
            {{ $totalStok }}
        </p>

    </div>

    <!-- TOTAL KATEGORI -->
    <div class="bg-white p-10 rounded-3xl shadow hover:scale-105 transition duration-300">

        <h2 class="text-3xl text-gray-500">
            Total Kategori
        </h2>

        <p class="text-7xl font-bold text-pink-500 mt-5">
            {{ $totalKategori }}
        </p>

    </div>

</div>

<!-- BUTTON TAMBAH -->
<div class="mt-10">

    <a
        href="{{ route('products.create') }}"
        class="bg-green-500 hover:bg-green-600 text-white px-8 py-5 rounded-2xl text-2xl shadow transition"
    >
        + Tambah Produk
    </a>

</div>

<!-- TABEL -->
<div class="bg-white rounded-3xl shadow mt-10 overflow-x-auto">

<table class="w-full">

    <thead class="bg-green-500 text-white">

        <tr>

            <th class="p-6">No</th>

            <th>Kode</th>

            <th>Nama Produk</th>

            <th>Harga</th>

            <th>Stok</th>

            <th>Kategori</th>

            <th>Gambar</th>

            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

        @forelse($products as $product)

        <tr class="text-center border-b hover:bg-gray-100 transition">

            <!-- NO -->
            <td class="p-6">
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

                @if($product->stok > 0)

                    <span class="bg-green-500 text-white px-4 py-2 rounded-xl stock-badge">
                        {{ $product->stok }}
                    </span>

                @else

                    <span class="bg-red-500 text-white px-4 py-2 rounded-xl stock-badge">
                        Habis
                    </span>

                @endif

            </td>

            <!-- KATEGORI -->
            <td>
                {{ $product->kategori }}
            </td>

            <!-- GAMBAR -->
            <td class="p-5">

                @if($product->gambar)

                    <img
                        src="{{ asset('storage/'.$product->gambar) }}"
                        class="w-24 h-24 object-cover rounded-2xl mx-auto shadow"
                    >

                @else

                    <span class="text-gray-400">
                        Tidak ada gambar
                    </span>

                @endif

            </td>

            <!-- AKSI -->
            <td class="p-5 flex gap-2 justify-center">

                <!-- BELI -->
                @if($product->stok > 0)
                    <button
                        onclick="beliProduk(event, {{ $product->id }}, '{{ $product->nama_produk }}')"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl cursor-pointer"
                    >
                        Beli
                    </button>
                @else
                    <button
                        disabled
                        class="bg-gray-400 text-white px-4 py-2 rounded-xl cursor-not-allowed"
                    >
                        Beli
                    </button>
                @endif

                <!-- EDIT -->
                <a
                    href="{{ route('products.edit', $product->id) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl"
                >
                    Edit
                </a>

                <!-- DELETE -->
                <form
                    action="{{ route('products.destroy', $product->id) }}"
                    method="POST"
                    class="inline-block"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="button"
                        onclick="confirmDelete(event, '{{ $product->nama_produk }}')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl cursor-pointer"
                    >
                        Hapus
                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="8" class="p-10 text-center text-gray-500">

                Belum ada data produk

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

<script>
function beliProduk(event, id, name) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi Pembelian',
        text: `Apakah Anda yakin ingin membeli produk "${name}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Beli!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memproses...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/beli-ajax/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Gagal membeli produk.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        const row = event.target.closest('tr');
                        const stockBadge = row.querySelector('.stock-badge');
                        
                        if (stockBadge) {
                            const newStock = data.stok;
                            if (newStock > 0) {
                                stockBadge.textContent = newStock;
                                stockBadge.className = "bg-green-500 text-white px-4 py-2 rounded-xl stock-badge";
                            } else {
                                stockBadge.textContent = "Habis";
                                stockBadge.className = "bg-red-500 text-white px-4 py-2 rounded-xl stock-badge";
                                
                                event.target.disabled = true;
                                event.target.className = "bg-gray-400 text-white px-4 py-2 rounded-xl cursor-not-allowed";
                                event.target.onclick = null;
                            }
                        }
                        
                        const totalStokEl = document.getElementById('total-stok-display');
                        if (totalStokEl) {
                            totalStokEl.textContent = data.total_stok_semua;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Stok produk habis atau terjadi kesalahan.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

function confirmDelete(event, name) {
    event.preventDefault();
    const form = event.target.closest('form');
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Produk "${name}" akan dihapus permanen!`,
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