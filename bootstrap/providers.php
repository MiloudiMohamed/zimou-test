<?php

use Illuminate\Concurrency\ConcurrencyServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    ConcurrencyServiceProvider::class,
];
