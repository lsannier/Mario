<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight text-center">
            {{ __('Gestion des locations par client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (isset($error))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                            {{ $error }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Sélectionner un client</h3>

                        <!-- Autocomplete input -->
                        <form action="{{ route('admin.customer-rentals') }}" method="GET" autocomplete="off">
                            <div class="relative">
                                <input type="text" id="customerAutocomplete" name="customer_name"
                                       class="mb-4 border-gray-300 rounded-md shadow-sm w-full"
                                       placeholder="Rechercher un client par nom..." autocomplete="off"
                                       value="{{ isset($selectedCustomerName) ? $selectedCustomerName : '' }}">
                                <input type="hidden" id="customerIdHidden" name="customer_id" value="{{ isset($selectedCustomerId) ? $selectedCustomerId : '' }}">
                                <div id="autocompleteList" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto hidden"></div>
                            </div>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Afficher les locations
                            </button>
                        </form>
                    </div>

                    <script>
                        const customers = @json($customers ?? []);
                        const input = document.getElementById('customerAutocomplete');
                        const list = document.getElementById('autocompleteList');
                        const hiddenId = document.getElementById('customerIdHidden');

                        input.addEventListener('input', function() {
                            const val = this.value.toLowerCase();
                            list.innerHTML = '';
                            if (!val) {
                                list.classList.add('hidden');
                                hiddenId.value = '';
                                return;
                            }
                            let matches = customers.filter(c =>
                                (`${c.firstName} ${c.lastName}`.toLowerCase().includes(val))
                            );
                            if (matches.length === 0) {
                                list.classList.add('hidden');
                                hiddenId.value = '';
                                return;
                            }
                            matches.forEach(c => {
                                const option = document.createElement('div');
                                option.className = 'px-4 py-2 cursor-pointer hover:bg-blue-100';
                                option.textContent = `${c.firstName} ${c.lastName}`;
                                option.dataset.id = c.customerId;
                                option.addEventListener('mousedown', function(e) {
                                    input.value = this.textContent;
                                    hiddenId.value = this.dataset.id;
                                    list.classList.add('hidden');
                                });
                                list.appendChild(option);
                            });
                            list.classList.remove('hidden');
                        });

                        // Hide list on blur
                        input.addEventListener('blur', function() {
                            setTimeout(() => list.classList.add('hidden'), 100);
                        });

                        // Clear hiddenId if input is changed manually
                        input.addEventListener('change', function() {
                            if (!customers.some(c => `${c.firstName} ${c.lastName}` === input.value)) {
                                hiddenId.value = '';
                            }
                        });
                    </script>

                    @if(empty($selectedCustomerId))
                        <div class="mt-4 text-center p-4 bg-yellow-50 rounded">
                            <p>Sélectionnez un client pour afficher ses locations.</p>
                        </div>
                    @elseif(isset($rentals) && count($rentals) > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium mb-4">Locations du client</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr>
                                            <th class="py-2 px-4 border-b text-left">ID Location</th>
                                            <th class="py-2 px-4 border-b text-left">Film</th>
                                            <th class="py-2 px-4 border-b text-left">Date de location</th>
                                            <th class="py-2 px-4 border-b text-left">Date de retour</th>
                                            <th class="py-2 px-4 border-b text-left">Date de retour effective</th>
                                            <th class="py-2 px-4 border-b text-left">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rentals as $rental)
                                            <tr>
                                                <td class="py-2 px-4 border-b">{{ $rental['rentalId'] }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    @if(isset($films[$rental['inventoryId']]))
                                                        {{ $films[$rental['inventoryId']]['title'] }}
                                                    @else
                                                        Film ID: {{ $rental['inventoryId'] }}
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-b">{{ date('d/m/Y H:i', strtotime($rental['rentalDate'])) }}</td>
                                                <td class="py-2 px-4 border-b">{{ date('d/m/Y H:i', strtotime($rental['returnDate'])) }}</td>
                                                <td class="py-2 px-4 border-b">
                                                    @if(isset($rental['actualReturnDate']) && $rental['actualReturnDate'])
                                                        {{ date('d/m/Y H:i', strtotime($rental['actualReturnDate'])) }}
                                                    @else
                                                        Non retourné
                                                    @endif
                                                </td>
                                                <td class="py-2 px-4 border-b">
                                                    @if(!isset($rental['actualReturnDate']) || !$rental['actualReturnDate'])
                                                        <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded">En cours</span>
                                                    @elseif(strtotime($rental['actualReturnDate']) <= strtotime($rental['returnDate']))
                                                        <span class="px-2 py-1 bg-green-200 text-green-800 rounded">Retourné à temps</span>
                                                    @else
                                                        <span class="px-2 py-1 bg-red-200 text-red-800 rounded">Retard</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 text-center p-4 bg-blue-50 rounded">
                            <p>Aucune location trouvée pour ce client.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    function filterCustomers() {
        const input = document.getElementById('customerSearch');
        const filter = input.value.toLowerCase();
        const select = document.getElementById('customerSelect');
        const options = select.getElementsByTagName('option');

        for (let i = 0; i < options.length; i++) {
            const text = options[i].textContent || options[i].innerText;
            if (text.toLowerCase().indexOf(filter) > -1 || options[i].value === '') {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }
    </script>
</x-app-layout>
