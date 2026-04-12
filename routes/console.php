<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

// Programar limpieza diaria de Telescope - elimina registros de más de 7 días
// excepto excepciones y errores 500+ que se mantienen indefinidamente
Schedule::command('telescope:prune-custom --hours=168')->daily(); // 168 horas = 7 días