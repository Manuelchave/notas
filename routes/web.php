<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NotaController;
use App\Models\Nota;

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
        'phpVersion' => PHP_VERSION
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {

    //select categoria, count(id) as total from Notas where useres_id=$auth group by category
    
    $total_noticias = Nota::select(DB::raw('categoria, count(id) as total'))
        ->where('users_id',Auth::id())
        ->orderBy('total', 'desc')
        ->groupBy('categoria')
        ->get();

    return Inertia::render('Dashboard', [
        'total_noticias' => $total_noticias
    ]);
    
})->name('dashboard');

Route::resource('nota', NotaController::class);