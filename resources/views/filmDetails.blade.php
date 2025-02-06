<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails du film') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <main>
        @php
            // L'id du film se trouve dans l'url
            $filmId = $_GET['id'];

            $films = file_get_contents('http://localhost:8080/toad/film/all');
            $films = collect(json_decode($films, true));
            $film = $films->firstWhere('filmId', $filmId);
            // echo collect($film);

            // Structure de données: {"filmId":4,"title":"AFFAIR PREJUDICE","description":"A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank","releaseYear":2006,"languageId":1,"originalLanguageId":1,"rentalDuration":5,"rentalRate":2.99,"length":117,"replacementCost":26.99,"rating":"G","specialFeatures":"Commentaries,Behind the Scenes","lastUpdate":"2024-10-04T09:05:15.000+00:00","idDirector":null}
        @endphp
        <div class="card">
            <!-- <h2>Liste des DVD</h2> -->
            <p>
                <div class="film_details">
                    <h2 style="font-size: 20px;font-weight: bold;">{{ $film['title'] }} ({{ $film['releaseYear'] }})</h2>
                    <p>Description: {{ $film['description'] }}</p>
                    <p>Durée: {{ $film['length'] }} minutes</p>
                    <p>Prix de location: {{ $film['rentalRate'] }} €</p>
                    <p>Prix de remplacement: {{ $film['replacementCost'] }} €</p>
                    <p>Note: {{ $film['rating'] }}</p>
                    <p>Caractéristiques spéciales: {{ $film['specialFeatures'] }}</p>
                    <a href="{{ route('filmlist') }}" class="btn" style="text-decoration: none; color: blue;">Retour à la liste des films</a>
                </div>
            </p>
        </div>
    </main>
    </div>
</x-app-layout>
