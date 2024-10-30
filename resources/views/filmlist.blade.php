<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des films') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    <br>
                    <br>
                    <h1 class="text-3xl font-bold mb-12 text-[#ff2d20] dark:text-[#ff2d20] text-center mx-auto my-8">{{ __("Voici la liste des films disponibles.") }}</h1>
                    <br>

                    <br>

                    <div class="overflow-x-auto">
                        <table class="min-w-full mt-4 border-collapse bg-white dark:bg-gray-800 shadow-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#ff2d20] to-[#ff6b5d] text-white">
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">ID</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Titre</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Description</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Année de sortie</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Durée de location</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Tarif de location</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-700 text-left">Évaluation</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $currentPage = request()->get('page', 1);
                                    $perPage = 10;
                                    $response = file_get_contents('http://localhost:8080/toad/film/all');
                                    $films = json_decode($response);
                                    $totalFilms = count($films);
                                    $totalPages = ceil($totalFilms / $perPage);
                                    $films = array_slice($films, ($currentPage - 1) * $perPage, $perPage);
                                @endphp
                                @if(isset($films) && count($films) > 0)
                                    @foreach ($films as $film)
                                        <tr class="hover:bg-[#fff5f5] dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $film->filmId }}</td>
                                            <td class="px-6 py-4 font-medium text-[#ff2d20] dark:text-[#ff2d20]">{{ $film->title }}</td>
                                            <td class="px-6 py-4">{{ $film->description }}</td>
                                            <td class="px-6 py-4">{{ $film->releaseYear }}</td>
                                            <td class="px-6 py-4">{{ $film->rentalDuration }}</td>
                                            <td class="px-6 py-4">{{ $film->rentalRate }}</td>
                                            <td class="px-6 py-4">{{ $film->rating }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Aucun film disponible</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <nav class="relative z-0 inline-flex shadow-sm rounded-md">
                            @if($currentPage > 1)
                            <a href="?page=1" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &lt;&lt;
                            </a>
                            <a href="?page={{ $currentPage - 1 }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &lt;
                            </a>
                            @endif

                            @php
                                $start = max(1, min($currentPage - 2, $totalPages - 4));
                                $end = min($totalPages, max(5, $currentPage + 2));
                            @endphp

                            @for ($i = $start; $i <= $end; $i++)
                                <a href="?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 {{ $i == $currentPage ? 'bg-[#ff2d20] text-white border-[#ff2d20]' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600' }} text-sm font-medium transition ease-in-out duration-150">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($end < $totalPages)
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200">...</span>
                            @endif

                            @if($currentPage < $totalPages)
                            <a href="?page={{ $currentPage + 1 }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &gt;
                            </a>
                            <a href="?page={{ $totalPages }}" class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition ease-in-out duration-150">
                                &gt;&gt;
                            </a>
                            @endif
                        </nav>
                    </div>
                    <br>

                    <br>

                    <br>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
