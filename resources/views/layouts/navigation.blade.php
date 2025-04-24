<nav x-data="{ open: false }" class="bg-white">
    <!-- Primary Navigation Menu -->
    <header>
        <h1>Mario - Gestion des DVD</h1>
    </header>

    <nav>
        <ul class="flex items-center" id="nav-links">
            <div class="flex items-center">
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('films.index')" :active="request()->routeIs('films')" style="color:white">
                            {{ __('Films') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('stocks')" :active="request()->routeIs('stocks')" style="color:white">
                            {{ __('Gestion des stocks') }}
                        </x-nav-link>
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <li><a href="/director">Réalisateurs</a></li>
                <form action="{{ route('deconnexion') }}" method="POST">
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


