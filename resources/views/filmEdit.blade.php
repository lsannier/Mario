<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modification d\'un film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <main>
            <div class="card">
                <form method="POST" action="http://localhost:8000/updateFilm/{{ $film['filmId'] }}">
                    @csrf
                    @method('PUT')
                    <div class="film_edit">

                        <div class="mb-4">
                            <label for="title" class="block">Titre</label>
                            <input type="text" name="title" id="title" required class="w-full border rounded px-3 py-2" value="{{ $film['title'] }}">
                        </div>


                        <div class="mb-4">
                            <label for="description" class="block">Description</label>
                            <textarea name="description" id="description" required class="w-full border rounded px-3 py-2">{{ $film['description'] }}</textarea>
                        </div>


                        <div class="mb-4">
                            <label for="releaseYear" class="block">Année de sortie</label>
                            <input type="number" name="release_year" id="releaseYear" required class="border rounded px-3 py-2" value="{{ $film['releaseYear'] }}">
                        </div>


                        <div class="mb-4">
                            <label for="length" class="block">Durée (minutes)</label>
                            <input type="number" name="length" id="length" required class="border rounded px-3 py-2" value="{{ $film['length'] }}">
                        </div>


                        <div class="mb-4">
                            <label for="rentalRate" class="block">Prix de location</label>
                            <input type="number" step="0.01" name="rental_rate" id="rentalRate" required class="border rounded px-3 py-2" value="{{ $film['rentalRate'] }}">
                        </div>


                        <div class="mb-4">
                            <label for="replacementCost" class="block">Prix de remplacement</label>
                            <input type="number" step="0.01" name="replacement_cost" id="replacementCost" required class="border rounded px-3 py-2" value="{{ $film['replacementCost'] }}">
                        </div>


                        <div class="mb-4">
                            <label for="rating" class="block">Classification</label>
                            <select name="rating" id="rating" required class="border rounded px-3 py-2">
                                <option value="G" {{ $film['rating'] == 'G' ? 'selected' : '' }}>G</option>
                                <option value="PG" {{ $film['rating'] == 'PG' ? 'selected' : '' }}>PG</option>

                                <option value="PG-13" {{ $film['rating'] == 'PG-13' ? 'selected' : '' }}>PG-13</option>
                                <option value="R" {{ $film['rating'] == 'R' ? 'selected' : '' }}>R</option>
                                <option value="NC-17" {{ $film['rating'] == 'NC-17' ? 'selected' : '' }}>NC-17</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="id_director" class="block">Réalisateur</label>
                            <select name="id_director" id="id_director" required class="border rounded px-3 py-2">
                                @foreach ($directors as $director)
                                    <option value="{{ $director['director_id'] }}">{{ $director['nom'] }} {{ $director['prenom'] }}</option>
                                @endforeach
                            </select>
                        </div>




                        <div class="mb-4">
                            <label for="specialFeatures" class="block">Caractéristiques spéciales</label>

                            <input type="text" name="special_features" id="specialFeatures" class="w-full border rounded px-3 py-2" value="{{ $film['specialFeatures'] }}">
                        </div>


                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Modifier le film
                            </button>
                            <a href="{{ route('filmlist') }}" class="ml-4 text-blue-500 hover:underline">Retour à la liste des films</a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
