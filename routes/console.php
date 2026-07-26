<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('warung:make-admin', function () {
    $name = $this->ask('Nama admin');
    $email = $this->ask('Email admin');
    $password = $this->secret('Kata sandi (minimal 8 karakter)');

    if (! filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen((string) $password) < 8) {
        $this->error('Masukkan email yang valid dan kata sandi minimal 8 karakter.');

        return self::FAILURE;
    }

    User::updateOrCreate(
        ['email' => $email],
        ['name' => $name, 'password' => $password, 'is_admin' => true],
    );

    $this->info("Admin {$email} siap digunakan untuk masuk.");
})->purpose('Membuat atau memperbarui akun admin Warung Pak Do');
