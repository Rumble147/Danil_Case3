<?php

use App\Models\Catatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

it('renders the notes page with saved notes for an authenticated user', function () {
    $user = User::factory()->create();
    Catatan::create(['judul' => 'Rencana Minggu Ini', 'isi' => 'Belajar Laravel']);
    Cache::forget('catatan.aktif.v2');

    $response = $this->actingAs($user)->get(route('catatan'));

    $response->assertOk();
    $response->assertSee('Semua catatan, satu tempat.');
    $response->assertSee('Rencana Minggu Ini');
    $response->assertSee('Simpan catatan');
});

it('shows an invitation to write when there are no notes', function () {
    $user = User::factory()->create();
    Cache::forget('catatan.aktif.v2');

    $response = $this->actingAs($user)->get(route('catatan'));

    $response->assertOk();
    $response->assertSee('Belum ada catatan');
    $response->assertSee('Tulis catatan pertama');
});
