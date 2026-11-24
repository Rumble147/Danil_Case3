<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 flex items-center justify-center p-4">
    <form method="POST" action="{{ route('register') }}" class="w-full max-w-sm bg-white p-6 rounded-xl shadow space-y-4">
        @csrf
        <h1 class="text-2xl font-bold">Register</h1>

        <flux:input type="text" name="name" label="Nama" value="{{ old('name') }}" placeholder="Nama" />
        <flux:input type="email" name="email" label="Email" value="{{ old('email') }}" placeholder="Email" />
        <flux:input type="password" name="password" label="Password" placeholder="Password" />
        <flux:input type="password" name="password_confirmation" label="Ulangi password" placeholder="Ulangi password" />

        <flux:button type="submit" variant="primary" class="w-full">Daftar</flux:button>

        <p class="text-sm text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600">Login</a></p>
    </form>
    @fluxScripts
</body>
</html>