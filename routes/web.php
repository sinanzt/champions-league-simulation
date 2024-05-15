<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FixturesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\StandingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/generate-simulation', [HomeController::class, 'generateSimulation'])->name('generateSimulation');

Route::get('/{simulation}/fixtures', [FixturesController::class, 'index'])->name('fixtures');

Route::get('/{simulation}/standings', [StandingController::class, 'index'])->name('standings');

Route::post('/{simulation}/play-week', [SimulationController::class, 'playWeek'])->name('simulation.playWeek');
Route::post('/{simulation}/play-all', [SimulationController::class, 'playAll'])->name('simulation.playAll');
Route::post('/{simulation}/reset', [SimulationController::class, 'reset'])->name('simulation.reset');
