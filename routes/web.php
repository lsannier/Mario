<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('login_staff');
});
Route::post('/login_staff', [ApiController::class, 'login'])->name('login_staff');

Route::post('/deconnexion', function(){
    return view('login_staff');
})->name('deconnexion');

    Route::get('/films/create', [ApiController::class, 'create'])->name('films.create');
    Route::post('/films', [ApiController::class, 'store'])->name('films.store');
    Route::get('/films/{film}/edit', [ApiController::class, 'edit'])->name('films.edit');
    Route::put('/films/{id}', [ApiController::class, 'update'])->name('films.update');
    Route::delete('/films/{id}', [ApiController::class, 'destroy'])->name('films.destroy');
    Route::get('/films/{film}', [ApiController::class, 'getFilmDetail'])->name('detail');
    Route::get('/films', [ApiController::class, 'getFilms'])->name('films.index');

    Route::get('/stocks', [ApiController::class, 'getStock'])->name('stocks');

Route::get('/admin/customer-rentals', [ApiController::class, 'customerRentals'])->name('admin.customer-rentals');

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/films/{filmId}', [ApiController::class, 'getFilmDetail'])->name('detail');
