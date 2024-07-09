<?php

use Illuminate\Support\Facades\Route;

Route::middleware('api')
     ->prefix('api')
     ->group(function () {
         // Define your API routes here
         // Example: Route::get('/example', [ExampleController::class, 'index']);
     });
