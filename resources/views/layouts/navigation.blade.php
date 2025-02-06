<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <header>
        <h1>Mario - Gestion des DVD</h1>
    </header>

    <nav>
        <ul class="flex items-center" id="nav-links">
            <div class="flex items-center">
                <li><a href="/dashboard">Accueil</a></li>
                <li><a href="/inventory">Inventaire</a></li>
                <li><a href="/filmlist">Films</a></li>
            </div>
            <div class="flex items-center">
                <li><a href="/director">Réalisateurs</a></li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <a href="javascript:void(0)" onclick="event.preventDefault(); this.closest('form').submit();">Déconnexion</a>
                </form>
            </div>
            <!-- <li><a href="#">Suivi des locations</a></li> -->
            <!-- <li><a href="#">Déconnexion</a></li> -->
        </ul>
        <style>
            #nav-links {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            /* Media query sur tablette */
            @media (max-width: 768px) {
                #nav-links {
                    flex-direction: column;
                }
            }
        </style>
    </nav>


