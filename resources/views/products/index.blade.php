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
<div class="mt-10 flex flex-col sm:flex-row justify-between items-center gap-4">

    <a
        href="{{ route('products.create') }}"
        class="bg-green-500 hover:bg-green-600 text-white px-8 py-5 rounded-2xl text-2xl shadow transition inline-block text-center"
    >
        + Tambah Produk
    </a>

    <div class="relative w-full sm:w-80">
        <input 
            type="text" 
            id="search-product" 
            placeholder="Cari kode, nama, atau kategori..." 
            class="w-full border border-gray-200 rounded-xl pl-4 pr-10 py-3.5 text-sm outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition shadow-sm"
        >
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
            🔍
        </span>
    </div>

</div>

<!-- TABEL -->
<div class="bg-white rounded-3xl shadow mt-10">

    <div class="overflow-x-auto">
        <table class="w-full" id="product-table">

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

</div>

<script>
// Pencarian Real-time untuk Tabel Produk
document.getElementById('search-product')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#product-table tbody tr');
    
    rows.forEach(row => {
        if (row.cells.length === 1 && row.cells[0].colSpan === 8) {
            return;
        }
        
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});

function beliProduk(event, id, name, qty = null, customerData = null) {
    event.preventDefault();
    
    const btn = event.currentTarget || event.target;
    const row = btn.closest('tr');
    const stockBadge = row ? row.querySelector('.stock-badge') : null;
    const maxStock = stockBadge ? parseInt(stockBadge.textContent) || 9999 : 9999;
    
    // Step 1: Input Qty
    if (qty === null) {
        Swal.fire({
            title: 'Jumlah Pembelian',
            html: `
                <div class="text-center mb-2 text-sm text-gray-500">Silakan tentukan jumlah untuk <strong>${name}</strong>:</div>
                <div class="flex items-center justify-center space-x-3 bg-gray-50 p-3 rounded-2xl border border-gray-200 max-w-[220px] mx-auto my-4">
                    <button type="button" id="qty-minus" class="w-10 h-10 rounded-xl bg-white hover:bg-gray-100 border border-gray-200 text-gray-700 font-extrabold flex items-center justify-center focus:outline-none transition active:scale-95 shadow-sm select-none cursor-pointer">-</button>
                    <input type="number" id="swal-qty" value="1" min="1" max="${maxStock}" class="w-16 text-center bg-transparent border-0 font-bold text-xl focus:outline-none focus:ring-0" style="outline: none; -moz-appearance: textfield;">
                    <button type="button" id="qty-plus" class="w-10 h-10 rounded-xl bg-white hover:bg-gray-100 border border-gray-200 text-gray-700 font-extrabold flex items-center justify-center focus:outline-none transition active:scale-95 shadow-sm select-none cursor-pointer">+</button>
                </div>
                <div class="text-xs text-gray-400 text-center">Stok tersedia: ${maxStock} pcs</div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal',
            didOpen: () => {
                const input = document.getElementById('swal-qty');
                const btnMinus = document.getElementById('qty-minus');
                const btnPlus = document.getElementById('qty-plus');
                
                btnMinus.addEventListener('click', () => {
                    let val = parseInt(input.value) || 1;
                    if (val > 1) {
                        input.value = val - 1;
                    }
                });
                
                btnPlus.addEventListener('click', () => {
                    let val = parseInt(input.value) || 1;
                    if (val < maxStock) {
                        input.value = val + 1;
                    }
                });
            },
            preConfirm: () => {
                const qtyVal = parseInt(document.getElementById('swal-qty').value);
                if (isNaN(qtyVal) || qtyVal < 1) {
                    Swal.showValidationMessage('Jumlah minimal pembelian adalah 1!');
                    return false;
                }
                if (qtyVal > maxStock) {
                    Swal.showValidationMessage(`Jumlah melebihi stok yang tersedia (${maxStock} pcs)!`);
                    return false;
                }
                return qtyVal;
            }
        }).then((qtyResult) => {
            if (qtyResult.isConfirmed) {
                beliProduk(event, id, name, qtyResult.value, customerData);
            }
        });
        return;
    }
    
    // Step 2: Checkout Form / Customer Information Form
    if (customerData === null) {
        Swal.fire({
            title: 'Formulir Checkout',
            text: 'Silakan isi data diri Anda untuk menyelesaikan pembelian (Informasi Penagihan & Pengiriman):',
            html:
                '<div style="text-align: left; margin-bottom: 4px;" class="text-xs text-gray-500 font-semibold uppercase">Nama Lengkap</div>' +
                '<input id="swal-nama" class="swal2-input mt-0 mb-3" placeholder="Nama Lengkap Anda" style="margin-top: 0; margin-bottom: 12px; width: 85%;">' +
                '<div style="text-align: left; margin-bottom: 4px;" class="text-xs text-gray-500 font-semibold uppercase">Alamat Email</div>' +
                '<input id="swal-email" type="email" class="swal2-input mt-0 mb-3" placeholder="contoh@domain.com" style="margin-top: 0; margin-bottom: 12px; width: 85%;">' +
                '<div style="text-align: left; margin-bottom: 4px;" class="text-xs text-gray-500 font-semibold uppercase">Nomor HP</div>' +
                '<input id="swal-nomor_hp" class="swal2-input mt-0 mb-3" placeholder="08xxxxxxxxxx" style="margin-top: 0; margin-bottom: 12px; width: 85%;">' +
                '<div style="text-align: left; margin-bottom: 4px;" class="text-xs text-gray-500 font-semibold uppercase">Alamat Pengiriman</div>' +
                '<textarea id="swal-alamat" class="swal2-textarea mt-0" style="width: 85%; margin-top: 0;" placeholder="Alamat lengkap tujuan pengiriman"></textarea>',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'Konfirmasi & Beli',
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
                beliProduk(event, id, name, qty, result.value);
            }
        });
        return;
    }

    // Step 3: Kirim data via AJAX
    Swal.fire({
        title: 'Memproses...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const payload = { qty: qty };
    Object.assign(payload, customerData);
    
    fetch(`/beli-ajax/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Berhasil!',
                text: data.message,
                icon: 'success',
                confirmButtonColor: '#10b981'
            }).then(() => {
                if (stockBadge) {
                    const newStock = data.stok;
                    if (newStock > 0) {
                        stockBadge.textContent = newStock;
                        stockBadge.className = "bg-green-500 text-white px-4 py-2 rounded-xl stock-badge";
                    } else {
                        stockBadge.textContent = "Habis";
                        stockBadge.className = "bg-red-500 text-white px-4 py-2 rounded-xl stock-badge";
                        
                        btn.disabled = true;
                        btn.className = "bg-gray-400 text-white px-4 py-2 rounded-xl cursor-not-allowed";
                        btn.onclick = null;
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