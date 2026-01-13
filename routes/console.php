<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create:admin', function () {
    $this->call('app:create-admin-user');
})->purpose('Créer un utilisateur administrateur');
