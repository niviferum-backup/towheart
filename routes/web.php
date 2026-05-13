<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', fn() => redirect()->route('floor', ['floor' => 1]));

Route::get('/floor/{floor}', [GameController::class, 'showFloor'])
    ->name('floor')
    ->whereNumber('floor');

Route::post('/floor/{floor}/solve', [GameController::class, 'solveFloor'])
    ->name('floor.solve')
    ->whereNumber('floor');

Route::post('/floor/{floor}/check', [GameController::class, 'checkFloor'])
    ->name('floor.check')
    ->whereNumber('floor');

Route::post('/floor/{floor}/next', [GameController::class, 'markIntro'])
    ->name('floor.next')
    ->whereNumber('floor');
