<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the styled login page', function () {
    $response = $this->get(route('login'));

    $response->assertOk();
    $response->assertSee('Masuk ke akunmu');
    $response->assertSee('Alamat email');
    $response->assertSee('Daftar sekarang');
    $response->assertDontSee('Ide hebat dimulai dari sebuah catatan.');
});

it('shows the login error after invalid credentials', function () {
    $response = $this->from(route('login'))->post(route('login'), [
        'email' => 'nadia@example.com',
        'password' => 'incorrect-password',
    ]);

    $response->assertRedirect(route('login'));
    $this->get(route('login'))->assertSee('Email atau password salah.');
});
