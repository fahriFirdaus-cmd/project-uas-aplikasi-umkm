<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1>Edit Transaksi</h1>

    <form action="/transactions/{{ $transaction->id }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nomor Invoice</label>
            <input type="text"
                   name="nomor_invoice"
                   class="form-control"
                   value="{{ $transaction->nomor_invoice }}">
        </div>

        <div class="mb-3">
            <label>Tanggal Transaksi</label>
            <input type="date"
                   name="tanggal_transaksi"
                   class="form-control"
                   value="{{ $transaction->tanggal_transaksi }}">
        </div>

        <div class="mb-3">
            <label>Pelanggan</label>

            <select name="customer_id"
                    class="form-control">

                @foreach($customers as $customer)

                <option value="{{ $customer->id }}"
                    {{ $transaction->customer_id == $customer->id ? 'selected' : '' }}>

                    {{ $customer->nama }}

                </option>

                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Total Harga</label>
            <input type="number"
                   name="total_harga"
                   class="form-control"
                   value="{{ $transaction->total_harga }}">
        </div>

        <div class="mb-3">
            <label>Status Pembayaran</label>

            <select name="status_pembayaran"
                    class="form-control">

                <option value="Lunas"
                    {{ $transaction->status_pembayaran == 'Lunas' ? 'selected' : '' }}>
                    Lunas
                </option>

                <option value="Belum Lunas"
                    {{ $transaction->status_pembayaran == 'Belum Lunas' ? 'selected' : '' }}>
                    Belum Lunas
                </option>

            </select>
        </div>

        <button class="btn btn-success">
            Update
        </button>

    </form>

</div>

</body>
</html>
