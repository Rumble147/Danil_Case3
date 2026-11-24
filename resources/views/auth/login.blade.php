<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · CatatanKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fb] font-sans text-slate-950">
    <main class="grid min-h-screen lg:grid-cols-2">
        <section class="relative hidden overflow-hidden bg-slate-950 px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between xl:px-20">
            <div class="absolute -right-36 -top-32 size-[32rem] rounded-full bg-indigo-600/25 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-24 size-[28rem] rounded-full bg-violet-600/20 blur-3xl"></div>

            <a href="{{ route('login') }}" class="relative flex w-fit items-center gap-3">
                <span class="grid size-11 place-items-center rounded-xl bg-indigo-500 text-white shadow-lg shadow-indigo-950/30">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </span>
                <span>
                    <span class="block font-bold tracking-tight">CatatanKu</span>
                    <span class="block text-xs text-slate-400">Ruang untuk semua idemu</span>
                </span>
            </a>

            <div class="relative max-w-xl py-12">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-indigo-200">
                    <span class="size-1.5 rounded-full bg-emerald-400"></span>
                    Semua pikiran, tertata rapi
                </div>
                <h1 class="text-5xl font-bold leading-[1.12] tracking-tight xl:text-6xl">Ide hebat dimulai dari sebuah catatan.</h1>
                <p class="mt-5 max-w-md text-base leading-7 text-slate-300">Simpan inspirasi, rencana, dan hal pentingmu dalam satu ruang yang sederhana.</p>

                <div class="mt-12 max-w-md rotate-[-2deg] rounded-2xl border border-white/10 bg-white/10 p-5 shadow-2xl shadow-black/20 backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="grid size-10 place-items-center rounded-xl bg-indigo-400/20 text-indigo-200">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold">Rencana hari ini</p>
                                <p class="mt-1 text-xs text-slate-400">Catatan pribadi · Baru saja</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-emerald-400/15 px-2.5 py-1 text-[11px] font-medium text-emerald-300">Tersimpan</span>
                    </div>
                    <div class="mt-5 space-y-2.5">
                        <div class="h-2 w-full rounded-full bg-white/15"></div>
                        <div class="h-2 w-4/5 rounded-full bg-white/15"></div>
                        <div class="h-2 w-3/5 rounded-full bg-white/15"></div>
                    </div>
                </div>
            </div>

            <p class="relative text-xs text-slate-500">CatatanKu · Ruang pribadimu untuk berpikir lebih jernih.</p>
        </section>

        <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-10 lg:px-12">
            <div class="w-full max-w-md">
                <a href="{{ route('login') }}" class="mb-12 flex w-fit items-center gap-3 lg:hidden">
                    <span class="grid size-10 place-items-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>
                    </span>
                    <span class="font-bold tracking-tight">CatatanKu</span>
                </a>

                <div class="mb-8">
                    <p class="text-sm font-semibold text-indigo-600">Selamat datang kembali</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Masuk ke akunmu</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-500">Lanjutkan merapikan ide dan catatan pentingmu.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    @if ($errors->any())
                        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <p class="font-semibold">Belum bisa masuk</p>
                            <ul class="mt-1 list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <flux:input
                        type="email"
                        name="email"
                        label="Alamat email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                    />
                    <flux:input
                        type="password"
                        name="password"
                        label="Kata sandi"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password"
                        required
                    />

                    <div class="flex items-center justify-between gap-4">
                        <flux:checkbox name="remember" label="Ingat saya" />
                        <span class="text-xs text-slate-400">Akses aman ke catatanmu</span>
                    </div>

                    <flux:button type="submit" variant="primary" class="w-full">
                        Masuk ke akun
                    </flux:button>

                    <p class="pt-2 text-center text-sm text-slate-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 transition hover:text-indigo-800">Daftar sekarang</a>
                    </p>
                </form>

                <p class="mt-10 text-center text-xs text-slate-400">Dengan masuk, catatanmu selalu dekat kapan pun dibutuhkan.</p>
            </div>
        </section>
    </main>
    @fluxScripts
</body>
</html>
