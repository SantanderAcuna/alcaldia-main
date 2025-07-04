<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('migrarseed', function () {
    Artisan::call('migrate:fresh');
    Artisan::call('db:seed');

    Artisan::call('auditoria:triggers');
})->describe('Migrar, sembrar y crear triggers de auditoría');
