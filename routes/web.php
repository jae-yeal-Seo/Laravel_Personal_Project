<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\WorryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::inertia('/write', 'WriteWorry')->name('writeworry');

Route::inertia('/writeresolution', 'WriteResolution')->name('writeresolution');

Route::post('/createWorry', 'WorryController@store')->name('worry.store');

Route::post('/createResolution', 'ResolutionController@store')->name('resolution.store');

Route::get('/feelinggraph', 'ChartController@index')->name('feelinggraph');

Route::get('/feelingrealgraph', 'ChartController@realindex')->name('feelingrealgraph');

Route::get('/feelingrealdaygraph', 'ChartController@realdayindex')->name('feelingrealdaygraph');

Route::get('/feelingrealmonthgraph', 'ChartController@realmonthindex')->name('feelingrealmonthgraph');

Route::get('/feelingrealyeargraph', 'ChartController@realyearindex')->name('feelingrealyeargraph');

Route::get('/worryresolutionHashTags/{id}', 'ResolutionController@worryresolutionHashTags')->name('worryresolutionHashTags.index');

Route::get('/getresolution/{id}', 'ResolutionController@show')->name('getresolution.show');

Route::post('/checkmyfeeling', 'WorryController@checkMood')->name('checkmyfeeling');

Route::post('/postmyfeeling', 'ChartController@create')->name('createchart');

Route::post('/getdayfeeling', 'ChartController@dayfeeling')->name('getdayfeeling');

Route::post('/getmonthfeeling', 'ChartController@monthfeeling')->name('getmonthfeeling');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
