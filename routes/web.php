<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CohortController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/test', [CohortController::class, 'show']);
Route::get('/{any}', function () {
    return view('welcome'); // Assuming 'react_app' is the name of your Blade view for React
})->where('any', '.*');
