<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-all duration-300">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-green-600 text-white p-8">

        <h1 class="text-5xl font-bold mb-16">
            UMKM APP
        </h1>

        <ul class="space-y-8 text-2xl">

            <li>
                <a href="/dashboard"
                class="hover:text-green-200 transition">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/products"
                class="hover:text-green-200 transition">
                    Produk
                </a>
            </li>

            <li>
                <a href="/statistik"
                class="hover:text-green-200 transition">
                    Statistik
                </a>
            </li>

            <li>
                <a href="/"
                class="hover:text-red-300 transition">
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <!-- HEADER -->
        <div class="flex justify-between items-center">

            <div>

                <h1 class="text-6xl font-bold text-gray-800 dark:text-white">
                    Dashboard UMKM
                </h1>

                <p class="text-2xl text-gray-500 dark:text-gray-300 mt-2">
                    Kelola produk UMKM modern
                </p>

            </div>

            <button onclick="toggleDarkMode()"
            class="bg-black text-white px-8 py-4 rounded-3xl text-xl hover:scale-105 transition">
                Dark Mode
            </button>

        </div>

        <!-- CARD -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">

            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl hover:scale-105 transition">

                <h2 class="text-2xl text-gray-500 dark:text-gray-300">
                    Total Produk
                </h2>

                <p class="text-6xl font-bold text-green-600 mt-4">
                    {{ count($products) }}
                </p>

            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl hover:scale-105 transition">

                <h2 class="text-2xl text-gray-500 dark:text-gray-300">
                    Total Stok
                </h2>

                <p class="text-6xl font-bold text-blue-600 mt-4">
                    {{ $products->sum('stok') }}
                </p>

            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl hover:scale-105 transition">

                <h2 class="text-2xl text-gray-500 dark:text-gray-300">
                    Kategori
                </h2>

                <p class="text-6xl font-bold text-pink-600 mt-4">
                    {{ $products->count() }}
                </p>

            </div>

        </div>

        <!-- TABLE -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden mt-10">

            <table class="w-full">

                <thead class="bg-green-600 text-white">

                    <tr>

                        <th class="p-5 text-left">No</th>
                        <th class="p-5 text-left">Kode</th>
                        <th class="p-5 text-left">Nama</th>
                        <th class="p-5 text-left">Harga</th>
                        <th class="p-5 text-left">Stok</th>
                        <th class="p-5 text-left">Kategori</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($products as $item)

                    <tr class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition">

                        <td class="p-5 dark:text-white">
                            {{ $loop->iteration }}
                        </td>

                        <td class="p-5 dark:text-white">
                            {{ $item->kode_produk }}
                        </td>

                        <td class="p-5 dark:text-white">
                            {{ $item->nama_produk }}
                        </td>

                        <td class="p-5 dark:text-white">
                            Rp {{ number_format($item->harga) }}
                        </td>

                        <td class="p-5 dark:text-white">
                            {{ $item->stok }}
                        </td>

                        <td class="p-5 dark:text-white">
                            {{ $item->kategori }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </main>

</div>

<script>

function toggleDarkMode() {

    document.documentElement.classList.toggle('dark');

}

</script>

</body>
</html>