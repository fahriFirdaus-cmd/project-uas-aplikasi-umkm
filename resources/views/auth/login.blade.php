<x-guest-layout>

    <!-- Header -->
    <div class="text-center mb-8">
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
    <p class="text-center mt-8 text-sm text-slate-400">
        Belum punya akun?
        <a 
            href="{{ route('register') }}" 
            class="text-emerald-400 font-bold hover:underline transition-all duration-200 ml-1"
        >
            Daftar Sekarang
        </a>
    </p>

</x-guest-layout>