<!DOCTYPE html>
<html>

<head>

    <title>Tambah Produk</title>

</head>

<body>

    <h1>Tambah Produk</h1>

    <form action="/products"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <p>

            Kode Produk

        </p>

        <input type="text"
               name="kode_produk">

        <br><br>

        <p>

            Nama Produk

        </p>

        <input type="text"
               name="nama_produk">

        <br><br>

        <p>

            Harga

        </p>

        <input type="number"
               name="harga">

        <br><br>

        <p>

            Stok

        </p>

        <input type="number"
               name="stok">

        <br><br>

        <p>

            Kategori

        </p>

        <input type="text"
               name="kategori">

        <br><br>

        <p>

            Gambar

        </p>

        <input type="file"
               name="gambar">

        <br><br>

        <button type="submit">

            Simpan

        </button>

    </form>

</body>

</html>