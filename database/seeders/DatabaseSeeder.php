<?php

namespace Database\Seeders;

use App\Models\Catatan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Akun Demo', 'password' => Hash::make('password123')]
        );

        $data = [
            ['judul' => 'Belajar Laravel', 'isi' => 'Mempelajari migration, seeder, dan Livewire.'],
            ['judul' => 'Tugas Case 3', 'isi' => 'Membuat aplikasi catatan dengan login dan soft-delete.'],
            ['judul' => 'Jadwal Kuliah', 'isi' => 'Cek jadwal Dasar Komputer dan Pemrograman.'],
        ];

        foreach ($data as $item) {
            Catatan::firstOrCreate(['judul' => $item['judul']], $item);
        }

        Cache::forget('catatan.aktif.v2');
    }
}