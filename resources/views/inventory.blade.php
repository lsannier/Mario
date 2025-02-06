<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des films') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <main>
        <div class="card">
            <h2>Liste des DVD</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Genre</th>
                        <th>Époque</th>
                        <th>Quantité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                    // Fetch /toad/films/all

                    // Response array of objects
                    // Each object has the following properties: {"filmId":1,"title":"ACADEMY DINOSAUR","description":"A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies","releaseYear":2006,"languageId":1,"originalLanguageId":1,"rentalDuration":6,"rentalRate":0.99,"length":86,"replacementCost":20.99,"rating":"PG","specialFeatures":"Deleted Scenes,Behind the Scenes","lastUpdate":"2024-10-04T09:05:15.000+00:00","idDirector":null}

                        
                    $response = file_get_contents('http://localhost:8080/toad/film/all');
                    $dvds = json_decode($response, true);

                    foreach ($dvds as $dvd) {
                        echo '<tr>';
                        echo '<td><a href="/filmDetails?id=' . $dvd['filmId'] . '" target="_blank" style="text-decoration: none; color: inherit;">' . htmlspecialchars($dvd['title']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($dvd['description']) . '</td>';
                        echo '<td>' . htmlspecialchars($dvd['releaseYear']) . '</td>';
                        echo '<td>' . htmlspecialchars($dvd['languageId']) . '</td>';
                        echo '<td><a href="#" class="btn">Modifier</a></td>';
                        echo '</tr>';
                    }

                    @endphp
                    <!-- <tr>
                        <td>Retour vers le futur</td>
                        <td>Science-fiction</td>
                        <td>Années 80</td>
                        <td>5</td>
                        <td>
                            <a href="#" class="btn">Modifier</a>
                        </td>
                    </tr>
                    <tr>
                        <td>E.T. l'extra-terrestre</td>
                        <td>Science-fiction</td>
                        <td>Années 80</td>
                        <td>3</td>
                        <td>
                            <a href="#" class="btn">Modifier</a>
                        </td>
                    </tr> -->
                    <!-- Ajoutez plus de lignes selon vos besoins -->
                </tbody>
            </table>
        </div>
    </main>
    </div>
</x-app-layout>
