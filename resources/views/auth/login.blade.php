<x-guest-layout card-width="max-w-6xl">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- Login Form Column -->
        <div class="lg:col-span-5 w-full">
            <!-- Header -->
            <div class="text-center lg:text-left mb-8">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Login UMKM</h1>
                <p class="text-sm text-slate-400 mt-2">Selamat datang kembali! Silakan masuk ke akun Anda</p>
            </div>

            <!-- Errors Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-950/40 border border-red-900/50 text-red-400 rounded-2xl text-xs backdrop-blur-sm">
                    <div class="flex items-center gap-2 font-semibold mb-1 text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Terjadi kesalahan:</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            placeholder="contoh@domain.com" 
                            class="w-full bg-slate-950/40 border border-slate-800/80 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-slate-100 pl-12 pr-4 py-3.5 rounded-2xl outline-none transition-all duration-300 placeholder-slate-600 text-sm"
                        >
                    </div>
                </div>

                <!-- PASSWORD -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="••••••••" 
                            class="w-full bg-slate-950/40 border border-slate-800/80 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-slate-100 pl-12 pr-4 py-3.5 rounded-2xl outline-none transition-all duration-300 placeholder-slate-600 text-sm"
                        >
                    </div>
                </div>

                <!-- BUTTON -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/20 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all duration-200 text-sm cursor-pointer"
                >
                    Masuk ke Akun
                </button>

            </form>

            <!-- Footer link -->
            <p class="text-center lg:text-left mt-8 text-sm text-slate-400">
                Belum punya akun?
                <a 
                    href="{{ route('register') }}" 
                    class="text-emerald-400 font-bold hover:underline transition-all duration-200 ml-1"
                >
                    Daftar Sekarang
                </a>
            </p>
        </div>

        <!-- Divider Line (Only visible on large screens) -->
        <div class="hidden lg:block lg:col-span-1 h-[450px] w-px bg-slate-800/50 mx-auto align-middle"></div>

        <!-- Products Column -->
        <div class="lg:col-span-6 w-full space-y-6">
            <div class="text-center lg:text-left">
                <span class="px-3 py-1 text-xs font-semibold tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase">
                    Etalase
                </span>
                <h2 class="text-2xl font-bold text-white tracking-tight mt-2">Produk Unggulan UMKM</h2>
                <p class="text-xs text-slate-400 mt-1">Daftar produk terbaik yang siap Anda pesan setelah masuk ke akun</p>
            </div>

            @if(isset($products) && $products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($products as $product)
                        <div class="bg-slate-950/30 border border-slate-800/60 rounded-2xl p-4 flex flex-col justify-between hover:border-emerald-500/30 transition-all duration-300 group">
                            <div>
                                <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden mb-3 bg-slate-900 flex items-center justify-center">
                                    @if($product->gambar)
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover group-hover:scale-105 transition-all duration-500">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    {{ $product->kategori }}
                                </span>
                                <h3 class="text-sm font-bold text-slate-200 mt-2 line-clamp-1 group-hover:text-emerald-400 transition-colors">
                                    {{ $product->nama_produk }}
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Kode: {{ $product->kode_produk }}
                                </p>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-800/60 flex justify-between items-center">
                                <span class="text-sm font-black text-emerald-400">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </span>
                                <span class="text-[11px] {{ $product->stok > 0 ? 'text-slate-400' : 'text-rose-500 font-medium' }}">
                                    Stok: {{ $product->stok }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback Mock Products if database is empty -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Sample 1 -->
                    <div class="bg-slate-950/30 border border-slate-800/60 rounded-2xl p-4 flex flex-col justify-between hover:border-emerald-500/30 transition-all duration-300 group">
                        <div>
                            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden mb-3 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 flex items-center justify-center border border-emerald-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-400/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                Minuman
                            </span>
                            <h3 class="text-sm font-bold text-slate-200 mt-2">
                                Kopi Susu Aren Premium
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Kopi susu khas dengan gula aren pilihan.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-800/60 flex justify-between items-center">
                            <span class="text-sm font-black text-emerald-400">
                                Rp 18.000
                            </span>
                            <span class="text-[11px] text-emerald-500">
                                Tersedia
                            </span>
                        </div>
                    </div>

                    <!-- Sample 2 -->
                    <div class="bg-slate-950/30 border border-slate-800/60 rounded-2xl p-4 flex flex-col justify-between hover:border-emerald-500/30 transition-all duration-300 group">
                        <div>
                            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden mb-3 bg-gradient-to-br from-teal-500/10 to-indigo-500/10 flex items-center justify-center border border-teal-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-400/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full bg-teal-500/10 text-teal-400 border border-teal-500/20">
                                Kerajinan
                            </span>
                            <h3 class="text-sm font-bold text-slate-200 mt-2">
                                Tas Anyaman Bambu
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Kerajinan anyaman tradisional ramah lingkungan.
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-slate-800/60 flex justify-between items-center">
                            <span class="text-sm font-black text-emerald-400">
                                Rp 75.000
                            </span>
                            <span class="text-[11px] text-emerald-500">
                                Tersedia
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</x-guest-layout>