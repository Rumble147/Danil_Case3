<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · Catatanku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fb] font-sans text-slate-950">
    <main class="min-h-screen">
        <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-10 lg:px-12">
            <div class="w-full max-w-md">
                <a href="{{ route('login') }}" class="mb-12 flex w-fit items-center gap-3">
                    <span class="grid size-10 place-items-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                            <path d="M8 8h8M8 12h8M8 16h5"/>
                        </svg>
                    </span>
                    <span class="font-bold tracking-tight">Catatanku</span>
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
