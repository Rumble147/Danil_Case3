<?php

use App\Models\Catatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the dashboard with active and deleted note totals', function () {
    $user = User::factory()->create(['name' => 'Nadia']);
    Catatan::create(['judul' => 'Rencana Minggu Ini', 'isi' => 'Belajar Laravel']);
    Catatan::create(['judul' => 'Ide Sampingan', 'isi' => 'Membuat proyek kecil']);
    Catatan::create(['judul' => 'Catatan Lama', 'isi' => 'Sudah tidak dipakai'])->delete();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertViewIs('dashboard');
    $response->assertSee('Halo, Nadia!');
    $response->assertSee('Rencana Minggu Ini');
    $response->assertViewHas('jumlahAktif', 2);
    $response->assertViewHas('jumlahTerhapus', 1);
});
