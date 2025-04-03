<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    // dd("hello world")   ;
    return view('login_staff');
});

Route::post('/login_staff', [ApiController::class, 'login'])->name('login_staff');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/filmlist', function () {
    return view('filmlist');
})->middleware(['auth', 'verified'])->name('filmlist');

Route::get('/inventory', function () {
    return view('inventory');
})->middleware(['auth', 'verified'])->name('inventory');

Route::get('/director', function () {
    return view('director');
})->middleware(['auth', 'verified'])->name('director');

Route::get('/filmDetails', function () {
    return view('filmDetails');
})->middleware(['auth', 'verified'])->name('filmDetails');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/filmCreate', function () {
    return view('filmCreate');
})->middleware(['auth', 'verified'])->name('filmCreate');

Route::get('/filmEdit', function () {
    $response = Http::get('http://localhost:8080/toad/film/getById', [
        'id' => request()->film_id
    ]);

    $directors = Http::get('http://localhost:8080/toad/director/all');
    $directors = $directors->json();

    if ($response->failed()) {
        // return redirect()->route('dashboard')->with('error', 'Erreur lors de la récupération du film');
    }

    $film = $response->json();

    /** Exe
     * [▼ // routes\web.php:52
     * "filmId" => 1
     * "title" => "ACADEMY DINOSAUR"
     * "description" => "A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies"
     * "releaseYear" => 2006
     * "languageId" => 1
     * "originalLanguageId" => 1
     * "rentalDuration" => 6
     * "rentalRate" => 0.99
     * "length" => 86
     * "replacementCost" => 20.99
     * "rating" => "PG"
     * "specialFeatures" => "Deleted Scenes,Behind the Scenes"
     * "lastUpdate" => "2024-10-04T09:05:15.000+00:00"
     * "idDirector" => null
     * ]
     */

    return view('filmEdit', ['film' => $film, 'directors' => $directors]);
})->middleware(['auth', 'verified'])->name('filmEdit');

Route::post('/addFilm', function () {
    $response = Http::post('http://localhost:8080/toad/film/add', [
        'title' => request()->title,
        'description' => request()->description,
        'releaseYear' => (int)request()->releaseYear,
        'languageId' => 1,
        'originalLanguageId' => 1,
        'rentalDuration' => 6,
        'rentalRate' => (double)request()->rentalRate,
        'length' => (int)request()->length,
        'replacementCost' => (double)request()->replacementCost,
        'rating' => request()->rating,
        'specialFeatures' => request()->specialFeatures,
        'lastUpdate' => Carbon::now()->format('Y-m-d H:i:s'),
        'idDirector' => request()->idDirector
    ]);
});

Route::put('/updateFilm/{id}', function ($id) {
    $params = [
        'title' => request()->title,
        'description' => request()->description,
        'releaseYear' => (int)request()->release_year,
        'languageId' => 1,
        'originalLanguageId' => 1,
        'rentalDuration' => 6,
        'rentalRate' => (double)request()->rental_rate,
        'length' => (int)request()->length,
        'replacementCost' => (double)request()->replacement_cost,
        'rating' => request()->rating,
        'lastUpdate' => Carbon::now()->format('Y-m-d H:i:s'),
        'idDirector' => request()->id_director
    ];
    // dd($params);
    $query_string = http_build_query($params);
    $endpoint = 'http://localhost:8080/toad/film/update/'.$id."?".$query_string;
    $response = Http::put($endpoint);

    dd($endpoint, $response->json());
    // return redirect()->route('filmlist');
});

Route::delete('/deleteFilm/{id}', function ($id) {
    $response = Http::delete('http://localhost:8080/toad/film/delete', [
        'id' => $id,
    ]);
});

require __DIR__.'/auth.php';
