<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\Auth\LoginGateway;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/', function () {
    return redirect('/admin/login');
});

