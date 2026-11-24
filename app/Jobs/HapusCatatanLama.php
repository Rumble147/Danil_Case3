<?php

namespace App\Jobs;

use App\Models\Catatan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HapusCatatanLama implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $hari = 30)
    {
    }

    public function handle(): void
    {
        $jumlah = Catatan::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays($this->hari))
            ->forceDelete();

        Cache::forget('catatan.aktif.v2');

        Log::info("HapusCatatanLama: {$jumlah} catatan dihapus permanen.");
    }
}