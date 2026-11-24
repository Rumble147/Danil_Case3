<?php

use App\Models\Catatan;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app')] class extends Component
{
    public $judul = '';
    public $isi = '';
    public $editId = null;
    public $formKey = 0;

    private function bersihkanCache()
    {
        Cache::forget('catatan.aktif.v2');
    }

    public function simpan()
    {
        $this->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
        ]);

        Catatan::updateOrCreate(
            ['id' => $this->editId],
            ['judul' => $this->judul, 'isi' => $this->isi]
        );

        $this->bersihkanCache();

        $this->judul = '';
        $this->isi = '';
        $this->editId = null;
        $this->resetValidation();
        $this->formKey++;
    }

    public function edit($id)
    {
        $c = Catatan::findOrFail($id);
        $this->editId = $c->id;
        $this->judul = $c->judul;
        $this->isi = $c->isi;
        $this->formKey++;
    }

    public function hapus($id)
    {
        Catatan::findOrFail($id)->delete();
        $this->bersihkanCache();
    }

    public function restore($id)
    {
        Catatan::withTrashed()->findOrFail($id)->restore();
        $this->bersihkanCache();
    }

    public function hapusPermanen($id)
    {
        Catatan::withTrashed()->findOrFail($id)->forceDelete();
        $this->bersihkanCache();
    }

    public function with(): array
    {
        $aktif = Cache::remember('catatan.aktif.v2', 300, fn () => [
            'data' => Catatan::latest()->get()->toArray(),
            'waktu' => now()->format('H:i:s'),
        ]);

        return [
            'catatans' => $aktif['data'],
            'waktuCache' => $aktif['waktu'],
            'terhapus' => Catatan::onlyTrashed()->latest()->get(),
        ];
    }
};
?>

<div class="min-h-screen bg-[#f4f7fb] text-slate-950">
    <header class="border-b border-slate-200/80 bg-white">
        <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-5 sm:px-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z"/>
                        <path d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                </span>
                <span>
                    <span class="block font-bold tracking-tight">CatatanKu</span>
                    <span class="hidden text-xs text-slate-400 sm:block">Ruang untuk semua idemu</span>
                </span>
            </a>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">Workspace pribadi</p>
                </div>
                <span class="grid size-10 place-items-center rounded-full bg-linear-to-br from-indigo-500 to-violet-600 text-sm font-bold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 transition hover:border-indigo-200 hover:text-indigo-700">
                    Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl space-y-8 px-5 py-8 sm:px-8 sm:py-10">
        <section class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-8 text-white shadow-xl shadow-slate-200 sm:px-9 sm:py-10">
            <div class="absolute -right-16 -top-20 size-64 rounded-full bg-indigo-500/30 blur-2xl"></div>
            <div class="absolute bottom-0 right-24 size-40 rounded-full bg-violet-500/20 blur-2xl"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="max-w-2xl">
                    <p class="mb-2 text-sm font-medium text-indigo-300">Ruang ide pribadimu</p>
                    <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">Semua catatan, satu tempat.</h1>
                    <p class="mt-3 text-sm leading-6 text-slate-300 sm:text-base">Tulis ide, simpan hal penting, dan rapikan pikiranmu kapan saja.</p>
                </div>
                <a href="#form-catatan" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg transition hover:-translate-y-0.5 hover:bg-indigo-50">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Catatan baru
                </a>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2">
            <article class="flex items-center justify-between rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Catatan aktif</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight">{{ count($catatans) }}</p>
                    <p class="mt-2 text-xs text-slate-400">Disimpan di catatanmu</p>
                </div>
                <span class="grid size-12 place-items-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                    </svg>
                </span>
            </article>
            <article class="flex items-center justify-between rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pembaruan daftar</p>
                    <p class="mt-2 text-xl font-bold tracking-tight">Tersinkron</p>
                    <p class="mt-2 text-xs text-slate-400">Cache diperbarui pukul {{ $waktuCache }}</p>
                </div>
                <span class="grid size-12 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M20 7v5h-5M4 17v-5h5"/>
                        <path d="M5.6 9a7 7 0 0 1 11.6-2L20 12M4 12l2.8 5a7 7 0 0 0 11.6-2"/>
                    </svg>
                </span>
            </article>
        </section>

        <section class="grid items-start gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
            <div class="rounded-2xl border border-slate-200/70 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 sm:px-6">
                    <div>
                        <h2 class="font-bold">Catatanmu</h2>
                        <p class="mt-1 text-xs text-slate-400">Kelola ide dan pengingat yang sudah kamu simpan.</p>
                    </div>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">{{ count($catatans) }} catatan</span>
                </div>

                @if (count($catatans))
                    <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-6">
                        @foreach ($catatans as $c)
                            <article class="group flex min-h-52 flex-col rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-100/60" wire:key="c{{ $c['id'] }}">
                                <div class="flex items-start justify-between gap-3">
                                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-100">
                                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path d="M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14l-4-3-4 3-4-3-4 3V5Z"/>
                                        </svg>
                                    </span>
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-medium text-slate-500">Catatan</span>
                                </div>
                                <h3 class="mt-4 line-clamp-1 font-bold">{{ $c['judul'] }}</h3>
                                <p class="mt-2 line-clamp-3 flex-1 whitespace-pre-line text-sm leading-6 text-slate-500">{{ $c['isi'] }}</p>
                                <div class="mt-5 flex flex-wrap gap-2 border-t border-slate-100 pt-4">
                                    <button type="button" wire:click="edit({{ $c['id'] }})" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                                        Edit catatan
                                    </button>
                                    <button type="button" wire:click="hapus({{ $c['id'] }})" wire:confirm="Hapus catatan ini?" class="rounded-lg px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-50 hover:text-red-700">
                                        Pindahkan ke sampah
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="grid place-items-center px-6 py-14 text-center">
                        <span class="grid size-14 place-items-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                        </span>
                        <h3 class="mt-4 font-bold">Belum ada catatan</h3>
                        <p class="mt-1 max-w-xs text-sm leading-6 text-slate-400">Catatan pertamamu bisa dimulai dari ide kecil hari ini.</p>
                        <a href="#form-catatan" class="mt-5 text-sm font-semibold text-indigo-600 transition hover:text-indigo-800">Tulis catatan pertama</a>
                    </div>
                @endif
            </div>

            <form id="form-catatan" wire:submit="simpan" wire:key="form-{{ $formKey }}" class="scroll-mt-24 rounded-2xl border border-slate-200/70 bg-white p-5 shadow-sm sm:p-6">
                <div class="mb-5">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-violet-50 text-violet-600">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="m16 4 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-bold">{{ $editId ? 'Edit catatan' : 'Tulis catatan' }}</h2>
                            <p class="mt-1 text-xs text-slate-400">{{ $editId ? 'Perbarui isi catatanmu.' : 'Simpan ide sebelum terlupa.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <flux:input wire:model="judul" label="Judul" placeholder="Contoh: Ide untuk akhir pekan" />
                    <flux:textarea wire:model="isi" label="Isi catatan" placeholder="Mulai tulis di sini..." rows="7" />
                    <div class="flex flex-col gap-2 pt-1">
                        <flux:button type="submit" variant="primary" class="w-full">
                            <span wire:loading.remove wire:target="simpan">{{ $editId ? 'Simpan perubahan' : 'Simpan catatan' }}</span>
                            <span wire:loading wire:target="simpan">Menyimpan...</span>
                        </flux:button>
                    </div>
                </div>
            </form>
        </section>

        @if ($terhapus->count())
            <section class="overflow-hidden rounded-2xl border border-slate-200/70 bg-white shadow-sm" x-data="{ buka: true }">
                <div class="flex items-center justify-between gap-4 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-amber-50 text-amber-600">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M3 6h18M8 6V3h8v3M19 6l-1 15H6L5 6M10 11v5M14 11v5"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-bold">Sampah</h2>
                            <p class="mt-1 text-xs text-slate-400">{{ $terhapus->count() }} catatan bisa dipulihkan</p>
                        </div>
                    </div>
                    <button type="button" @click="buka = !buka" class="rounded-lg px-3 py-2 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-50" x-text="buka ? 'Sembunyikan' : 'Tampilkan'"></button>
                </div>

                <div x-show="buka" class="divide-y divide-slate-100 border-t border-slate-100">
                    @foreach ($terhapus as $t)
                        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6" wire:key="t{{ $t->id }}">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-slate-700">{{ $t->judul }}</p>
                                <p class="mt-1 text-xs text-slate-400">Dihapus {{ $t->deleted_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" wire:click="restore({{ $t->id }})" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                                    Pulihkan
                                </button>
                                <button type="button" wire:click="hapusPermanen({{ $t->id }})" wire:confirm="Hapus permanen? Data tidak bisa dikembalikan." class="rounded-lg px-3 py-2 text-xs font-semibold text-red-500 transition hover:bg-red-50 hover:text-red-700">
                                    Hapus permanen
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</div>