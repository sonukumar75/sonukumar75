<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('lab:summary', function (): void {
    $this->info('Civil Laboratory SaaS command bus is ready.');
})->purpose('Show civil lab platform readiness.');
