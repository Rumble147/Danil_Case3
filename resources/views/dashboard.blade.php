<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fb] font-sans text-slate-950">
    <div class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-64 border-r border-slate-200/80 bg-white lg:flex lg:flex-col">
            <div class="flex h-20 items-center gap-3 px-7">
                <div class="grid size-10 place-items-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold tracking-tight">CatatanKu</p>
                    <p class="text-xs text-slate-400">Workspace pribadi</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('catatan') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-slate-50 hover:text-slate-900">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                    </svg>
                    Semua Catatan
                </a>
            </nav>

            <div class="p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-red-50 hover:text-red-600">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M10 17l5-5-5-5M15 12H3M14 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="w-full lg:ml-64">
            <header class="sticky top-0 z-10 border-b border-slate-200/80 bg-white/90 backdrop-blur">
                <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 sm:px-8">
                    <div class="flex items-center gap-3 lg:hidden">
                        <div class="grid size-9 place-items-center rounded-lg bg-indigo-600 text-white">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                                <path d="M8 8h8M8 12h8M8 16h5"/>
                            </svg>
                        </div>
                        <span class="font-bold">CatatanKu</span>
                    </div>
                    <p class="hidden text-sm text-slate-500 lg:block">{{ now()->translatedFormat('l, d F Y') }}</p>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('catatan') }}" class="grid size-10 place-items-center rounded-full border border-slate-200 bg-white text-slate-500 transition hover:border-indigo-200 hover:text-indigo-600 lg:hidden" aria-label="Buka catatan">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                            </svg>
                        </a>
                        <div class="text-right">
                            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">Pengguna</p>
                        </div>
                        <div class="grid size-10 place-items-center rounded-full bg-linear-to-br from-indigo-500 to-violet-600 text-sm font-bold text-white shadow-md shadow-indigo-100">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <div class="mx-auto max-w-7xl space-y-8 px-5 py-8 sm:px-8 sm:py-10">
                <section class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-8 text-white shadow-xl shadow-slate-200 sm:px-9 sm:py-10">
                    <div class="absolute -right-16 -top-20 size-64 rounded-full bg-indigo-500/30 blur-2xl"></div>
                    <div class="absolute bottom-0 right-24 size-40 rounded-full bg-violet-500/20 blur-2xl"></div>
                    <div class="relative max-w-xl">
                        <p class="mb-2 text-sm font-medium text-indigo-300">Selamat datang kembali</p>
                        <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Halo, {{ auth()->user()->name }}!</h1>
                        <p class="mt-3 max-w-lg text-sm leading-6 text-slate-300 sm:text-base">
                            Siapkan pikiranmu. Semua ide dan catatan penting bisa kamu kelola dalam satu tempat.
                        </p>
                        <a href="{{ route('catatan') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-indigo-50">
                            Buat catatan baru
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    </div>
                </section>

                <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Catatan aktif</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight">{{ $jumlahAktif }}</p>
                            </div>
                            <div class="grid size-11 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-slate-400">Siap untuk dilihat atau diedit</p>
                    </article>

                    <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Dipindahkan</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight">{{ $jumlahTerhapus }}</p>
                            </div>
                            <div class="grid size-11 place-items-center rounded-xl bg-amber-50 text-amber-600">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M3 6h18M8 6V3h8v3M19 6l-1 15H6L5 6M10 11v5M14 11v5"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-slate-400">Masih bisa dipulihkan</p>
                    </article>

                    <article class="rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm sm:col-span-2 xl:col-span-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500">Status penyimpanan</p>
                                <p class="mt-2 text-xl font-bold tracking-tight">Tersimpan aman</p>
                            </div>
                            <div class="grid size-11 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-5 text-xs text-slate-400">Data terhubung ke database</p>
                    </article>
                </section>

                <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
                    <div class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 sm:px-6">
                            <div>
                                <h2 class="font-bold">Catatan Terbaru</h2>
                                <p class="mt-1 text-xs text-slate-400">Aktivitas catatan terakhir</p>
                            </div>
                            <a href="{{ route('catatan') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800">Lihat semua</a>
                        </div>

                        @if ($catatanAktif->isEmpty())
                            <div class="grid place-items-center px-6 py-14 text-center">
                                <div class="grid size-12 place-items-center rounded-full bg-slate-100 text-slate-400">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                </div>
                                <p class="mt-4 font-semibold">Belum ada catatan</p>
                                <p class="mt-1 text-sm text-slate-400">Mulai dengan membuat catatan pertamamu.</p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-100">
                                @foreach ($catatanAktif as $catatan)
                                    <a href="{{ route('catatan') }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-slate-50 sm:px-6">
                                        <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-semibold">{{ $catatan->judul }}</p>
                                            <p class="mt-1 truncate text-xs text-slate-400">{{ $catatan->isi }}</p>
                                        </div>
                                        <span class="hidden shrink-0 text-xs text-slate-400 sm:block">{{ $catatan->updated_at->diffForHumans() }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <aside class="rounded-2xl bg-linear-to-br from-indigo-600 to-violet-700 p-6 text-white shadow-lg shadow-indigo-100">
                        <div class="grid size-11 place-items-center rounded-xl bg-white/15">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                        </div>
                        <h2 class="mt-5 text-lg font-bold">Mulai catatan baru</h2>
                        <p class="mt-2 text-sm leading-6 text-indigo-100">Tuangkan ide, daftar tugas, atau pengingat pentingmu sekarang.</p>
                        <a href="{{ route('catatan') }}" class="mt-5 flex items-center justify-between rounded-xl bg-white px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-50">
                            Buka editor
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    </aside>
                </section>
            </div>
        </main>
    </div>

    @fluxScripts
</body>
</html>