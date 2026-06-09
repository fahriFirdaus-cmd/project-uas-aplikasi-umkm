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

        <h1 class="text-6xl font-bold text-pink-500" id="total-penjualan-display">
            {{ $totalPenjualan }}
        </h1>

    </div>

    <!-- TOTAL PENDAPATAN -->

    <div class="bg-white rounded-3xl shadow p-8">

        <h2 class="text-3xl text-gray-500 mb-5">
            Total Pendapatan
        </h2>

        <h1 class="text-4xl font-bold text-yellow-500" id="total-pendapatan-display">
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

<div class="bg-white rounded-3xl shadow mt-10">

    <!-- Search Bar Header -->
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 rounded-t-3xl gap-4">
        <h3 class="text-2xl font-bold text-slate-800">Daftar Produk UMKM</h3>
        <div class="relative w-full sm:w-80">
            <input 
                type="text" 
                id="search-product" 
                placeholder="Cari kode, nama, atau kategori..." 
                class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-2.5 text-sm outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition shadow-sm"
            >
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                🔍
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full" id="product-table">

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

                        <img src="{{ asset('storage/' . $product->gambar) }}"
                             class="w-20 h-20 object-cover rounded-xl mx-auto">

                    @else

                        Tidak ada gambar

                    @endif

                </td>

                <!-- AKSI -->

                <td>

                    <div class="flex justify-center gap-2 items-center">

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

                        <a href="{{ route('products.edit', $product->id) }}"
                           class="bg-blue-500 text-white px-5 py-2 rounded-xl">

                            Edit

                        </a>

                        <!-- HAPUS -->

                        <form action="{{ route('products.destroy', $product->id) }}"
                              method="POST"
                              class="inline-block">

                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    onclick="confirmDelete(event, '{{ $product->nama_produk }}')"
                                    class="bg-red-500 text-white px-5 py-2 rounded-xl cursor-pointer">

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

</div>

<script>
// Pencarian Real-time untuk Tabel Produk di Dashboard
document.getElementById('search-product')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#product-table tbody tr');
    let hasResults = false;
    
    rows.forEach(row => {
        // Cek jika baris kosong (belum ada data produk)
        if (row.cells.length === 1 && row.cells[0].colSpan === 8) {
            return;
        }
        
        const text = row.innerText.toLowerCase();
        if (text.includes(query)) {
            row.style.display = '';
            hasResults = true;
        } else {
            row.style.display = 'none';
        }
    });
});

function beliProduk(event, id, name, customerData = null) {
    event.preventDefault();
    
    const confirmTitle = customerData ? 'Memproses Transaksi...' : 'Konfirmasi Pembelian';
    const confirmText = customerData ? `Membeli produk "${name}" untuk pelanggan "${customerData.nama}"...` : `Apakah Anda yakin ingin membeli produk "${name}"?`;
    
    Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: customerData ? 'info' : 'question',
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
                },
                body: customerData ? JSON.stringify(customerData) : null
            })
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (data.needs_customer) {
                    Swal.fire({
                        title: 'Data Pelanggan Baru',
                        text: 'Belum ada data pelanggan di database. Silakan isi terlebih dahulu:',
                        html:
                            '<input id="swal-nama" class="swal2-input" placeholder="Nama Pelanggan">' +
                            '<input id="swal-email" type="email" class="swal2-input" placeholder="Email">' +
                            '<input id="swal-nomor_hp" class="swal2-input" placeholder="Nomor HP">' +
                            '<textarea id="swal-alamat" class="swal2-textarea" style="width: 80%;" placeholder="Alamat"></textarea>',
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Simpan & Beli',
                        cancelButtonText: 'Batal',
                        preConfirm: () => {
                            const nama = document.getElementById('swal-nama').value.trim();
                            const email = document.getElementById('swal-email').value.trim();
                            const nomor_hp = document.getElementById('swal-nomor_hp').value.trim();
                            const alamat = document.getElementById('swal-alamat').value.trim();
                            
                            if (!nama || !email || !nomor_hp || !alamat) {
                                Swal.showValidationMessage('Semua data wajib diisi!');
                                return false;
                            }
                            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                                Swal.showValidationMessage('Format email tidak valid!');
                                return false;
                            }
                            return { nama, email, nomor_hp, alamat };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            beliProduk(event, id, name, result.value);
                        }
                    });
                } else if (data.success) {
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
                        
                        // Update Dashboard widgets dynamically
                        const totalPenjualanEl = document.getElementById('total-penjualan-display');
                        if (totalPenjualanEl) {
                            totalPenjualanEl.textContent = data.total_penjualan;
                        }
                        
                        const totalPendapatanEl = document.getElementById('total-pendapatan-display');
                        if (totalPendapatanEl) {
                            const formatted = new Intl.NumberFormat('id-ID').format(data.total_pendapatan);
                            totalPendapatanEl.textContent = 'Rp ' + formatted;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memproses data.',
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