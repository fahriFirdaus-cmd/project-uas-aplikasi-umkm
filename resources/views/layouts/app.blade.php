@php
    use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>UMKM APP</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <div class="w-64 bg-green-500 text-white p-8 shadow-2xl">

        <h1 class="text-5xl font-bold mb-12">
            UMKM APP
        </h1>

        <ul class="space-y-8 text-2xl">

            <!-- DASHBOARD -->
            <li>

                <a
                    href="/dashboard"
                    class="hover:text-green-200 transition"
                >
                    🏠 Dashboard
                </a>

            </li>

            <!-- PRODUK -->
            <li>

                <a
                    href="/products"
                    class="hover:text-green-200 transition"
                >
                    📦 Produk
                </a>

            </li>

            <!-- PELANGGAN -->
            <li>

                <a
                    href="/customers"
                    class="hover:text-green-200 transition"
                >
                    👥 Pelanggan
                </a>

            </li>

            <!-- STATISTIK -->
            <li>

                <a
                    href="/statistik"
                    class="hover:text-green-200 transition"
                >
                    📊 Statistik
                </a>

            </li>

            <!-- PESANAN -->
            <li>

                <a
                    href="/my-orders"
                    class="hover:text-green-200 transition"
                >
                    🛒 Pesanan
                </a>

            </li>

            <!-- PROFILE -->
            <li>

                <a
                    href="/profile"
                    class="hover:text-green-200 transition"
                >
                    ⚙️ Pengaturan Profil
                </a>

            </li>

            <!-- USER LOGIN -->
            <li class="pt-10 text-lg text-green-100">

                👤 {{ Auth::user()->name }}

            </li>

            <!-- LOGOUT -->
            <li>

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="hover:text-green-200 transition"
                    >
                        🚪 Logout
                    </button>

                </form>

            </li>

        </ul>

    </div>

    <!-- CONTENT -->
    <div class="flex-1 p-10">

        @yield('content')

    </div>

</div>

</body>
</html>