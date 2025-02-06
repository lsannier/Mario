<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Realisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <main>
        <div class="card">
            <h2 style="font-size: 20px;font-weight: bold;">Liste des réalisateurs</h2>
            <!-- URL: http://localhost:8080/toad/director/all -->
            <!-- Data: [{"director_id":1,"nom":"Spielberg","prenom":"Steven","date_naissance":"1946-12-18 00:00:00","nationnalite":"Américain"},{"director_id":2,"nom":"Nolan","prenom":"Christopher","date_naissance":"1970-07-30 00:00:00","nationnalite":"Britannique"},{"director_id":3,"nom":"Cameron","prenom":"James","date_naissance":"1954-08-16 00:00:00","nationnalite":"Canadien"},{"director_id":4,"nom":"Spielberg","prenom":"Steven","date_naissance":"1946-12-18 00:00:00","nationnalite":"Américain"},{"director_id":5,"nom":"Nolan","prenom":"Christopher","date_naissance":"1970-07-30 00:00:00","nationnalite":"Britannique"},{"director_id":6,"nom":"Cameron","prenom":"James","date_naissance":"1954-08-16 00:00:00","nationnalite":"Canadien"}] -->
            
            <!-- Search bar -->
             <div class="flex flex-row">
                <input type="text" id="search" placeholder="Rechercher un réalisateur">
                <button id="reset" onclick="document.getElementById('search').value = '';">Réinitialiser</button>
            </div>
            <br>
            <table>
                <tr id="director_header">
                    <th id="nom_header">Nom</th>
                    <th id="prenom_header">Prénom</th>
                    <th id="nb_fils_directeur_header">Nombre de films</th>
                </tr>
                @php
                    $directors = file_get_contents('http://localhost:8080/toad/director/all');
                    $filmDirectors = file_get_contents('http://localhost:8080/toad/film_director/all');
                    $directors = json_decode($directors, true);
                    $filmDirectors = json_decode($filmDirectors, true);
                    foreach ($directors as $director) {
                        $nb_fils_directeur = 0;
                        foreach ($filmDirectors as $filmDirector) {
                            if ($director['director_id'] == $filmDirector['directorId']) {
                                $nb_fils_directeur++;
                            }  
                        }
                        echo '<tr id="director_' . $director['director_id'] . '" data-id="' . $director['director_id'] . '">';
                        echo '<td id="nom_' . $director['director_id'] . '">' . htmlspecialchars($director['nom']) . '</td>';
                        echo '<td id="prenom_' . $director['director_id'] . '">' . htmlspecialchars($director['prenom']) . '</td>';
                        echo '<td id="nb_fils_directeur_' . $director['director_id'] . '">' . htmlspecialchars($nb_fils_directeur) . '</td>';
                        echo '</tr>';
                    }
                @endphp
            </table>
            <script>
                document.getElementById('search').addEventListener('input', function() {
                    const searchValue = this.value.toLowerCase();
                    document.querySelectorAll('tr').forEach(row => {
                        if(row.id == 'director_header') {return;}
                        const nom = document.getElementById('nom_' + row.dataset.id).innerText.toLowerCase();
                        const prenom = document.getElementById('prenom_' + row.dataset.id).innerText.toLowerCase();
                        if (nom.includes(searchValue) || prenom.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
                document.getElementById('reset').addEventListener('click', function() {
                    document.getElementById('search').value = '';
                });
            </script>
        </div>
    </main>
    </div>
</x-app-layout>
