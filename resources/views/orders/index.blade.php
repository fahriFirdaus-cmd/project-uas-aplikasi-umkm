@extends('layouts.app')

@section('content')

<h1 class="text-5xl font-bold mb-8">
    Riwayat Transaksi
</h1>

<div class="bg-white rounded-3xl shadow overflow-x-auto">

<table class="w-full">

    <thead class="bg-green-500 text-white">

        <tr>

            <th class="p-5">No</th>

            <th>Invoice</th>

            <th>Tanggal</th>

            <th>Pelanggan</th>

            <th>Produk</th>

            <th>Qty</th>

            <th>Total Harga</th>

            <th>Status</th>

            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

        @forelse($transactions as $trx)

        <tr class="text-center border-b">

            <!-- NO -->
            <td class="p-5">
                {{ $loop->iteration }}
            </td>

            <!-- INVOICE -->
            <td>
                {{ $trx->nomor_invoice }}
            </td>

            <!-- TANGGAL -->
            <td>
                {{ $trx->tanggal_transaksi }}
            </td>

            <!-- PELANGGAN -->
            <td>
                {{ $trx->pelanggan }}
            </td>

            <!-- PRODUK -->
            <td>
                {{ $trx->product->nama_produk ?? 'Produk Telah Dihapus' }}
            </td>

            <!-- QTY -->
            <td>
                {{ $trx->qty }}
            </td>

            <!-- TOTAL -->
            <td>
                Rp {{ number_format($trx->total_harga) }}
            </td>

            <!-- STATUS -->
            <td>

                <span class="bg-green-500 text-white px-4 py-2 rounded-xl">

                    {{ $trx->status_pembayaran }}

                </span>

            </td>

            <!-- AKSI -->
            <td class="p-5">
                <button
                    onclick="showInvoiceDetail(
                        '{{ $trx->nomor_invoice }}',
                        '{{ $trx->tanggal_transaksi }}',
                        '{{ $trx->pelanggan }}',
                        '{{ $trx->product->nama_produk ?? 'Produk Telah Dihapus' }}',
                        '{{ $trx->qty }}',
                        '{{ number_format($trx->product->harga ?? 0) }}',
                        '{{ number_format($trx->total_harga) }}',
                        '{{ $trx->status_pembayaran }}'
                    )"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl cursor-pointer"
                >
                    Lihat Invoice
                </button>
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="9" class="p-10 text-center">

                Belum ada transaksi

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

<script>
function showInvoiceDetail(invoice, tanggal, pelanggan, produk, qty, hargaSatuan, total, status) {
    const formattedTanggal = new Date(tanggal).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    Swal.fire({
        title: 'INVOICE PEMBAYARAN',
        html: `
            <div class="text-left space-y-4 border-t border-b border-dashed border-slate-300 py-4 my-2 text-slate-700 font-mono text-sm leading-relaxed">
                <div class="flex justify-between">
                    <span>No. Invoice:</span>
                    <span class="font-bold text-green-600">${invoice}</span>
                </div>
                <div class="flex justify-between">
                    <span>Tanggal:</span>
                    <span>${formattedTanggal}</span>
                </div>
                <div class="flex justify-between">
                    <span>Pelanggan:</span>
                    <span class="font-semibold text-slate-900">${pelanggan}</span>
                </div>
                <hr class="border-dashed border-slate-300 my-2">
                <div class="space-y-1">
                    <div class="flex justify-between font-semibold text-slate-950">
                        <span>Detail Item</span>
                        <span>Total</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span>${produk} (${qty}x @ Rp ${hargaSatuan})</span>
                        <span>Rp ${total}</span>
                    </div>
                </div>
                <hr class="border-dashed border-slate-300 my-2">
                <div class="flex justify-between text-lg font-bold text-slate-950 mt-4">
                    <span>Total Bayar:</span>
                    <span class="text-green-600">Rp ${total}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span>Status Pembayaran:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${status === 'Lunas' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-yellow-100 text-yellow-700 border border-yellow-300'}">${status}</span>
                </div>
            </div>
            <p class="text-xs text-slate-400 text-center mt-4">Terima kasih telah berbelanja di UMKM App!</p>
        `,
        icon: 'info',
        width: '450px',
        confirmButtonColor: '#10b981',
        confirmButtonText: 'Tutup',
        showDenyButton: true,
        denyButtonText: 'Cetak/Print',
        denyButtonColor: '#3b82f6'
    }).then((result) => {
        if (result.isDenied) {
            const printContent = `
                <div style="font-family: monospace; padding: 40px; width: 400px; margin: auto; border: 1px solid #ccc;">
                    <h2 style="text-align: center; margin-bottom: 2px;">UMKM APP</h2>
                    <p style="text-align: center; font-size: 12px; margin-top: 0;">Bukti Pembayaran Resmi</p>
                    <hr style="border-top: 1px dashed #000;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr><td>No. Invoice</td><td>: ${invoice}</td></tr>
                        <tr><td>Tanggal</td><td>: ${formattedTanggal}</td></tr>
                        <tr><td>Pelanggan</td><td>: ${pelanggan}</td></tr>
                    </table>
                    <hr style="border-top: 1px dashed #000;">
                    <table style="width: 100%; font-size: 14px;">
                        <tr style="font-weight: bold;"><td>Item</td><td style="text-align: right;">Total</td></tr>
                        <tr><td>${produk} (${qty}x)</td><td style="text-align: right;">Rp ${total}</td></tr>
                    </table>
                    <hr style="border-top: 1px dashed #000;">
                    <table style="width: 100%; font-size: 16px; font-weight: bold;">
                        <tr><td>Total Bayar</td><td style="text-align: right;">Rp ${total}</td></tr>
                        <tr><td>Status</td><td style="text-align: right;">${status}</td></tr>
                    </table>
                    <hr style="border-top: 1px dashed #000;">
                    <p style="text-align: center; font-size: 12px;">Terima kasih atas kunjungan Anda!</p>
                </div>
            `;
            const win = window.open('', '_blank');
            win.document.write(`<html><head><title>Cetak Invoice ${invoice}</title></head><body onload="window.print();window.close();">${printContent}</body></html>`);
            win.document.close();
        }
    });
}
</script>

@endsection