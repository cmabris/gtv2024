<div>
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Listado de puntos de interés</h1>

        <button type="button"
            class="ml-12 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ml-auto"
            wire:click="$emitTo('admin.point.create-point', 'openCreationModal')">
            Añadir
        </button>

        <button wire:click="toggleMapVisibility"
            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
            {{ $showMap ? 'Ocultar Mapa' : 'Mostrar Mapa' }}
        </button>


    </div>

    <div class="mb-3">
        <div class="inline">
            <select
                class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto"
                wire:model="searchColumn">
                <option value="id">ID</option>
                <option value="distance">DISTANCIA</option>
                <option value="latitude">LATITUD</option>
                <option value="longitude">LONGITUD</option>
                <option value="place_id">SITIO</option>
                <option value="creator">CREADOR</option>
                <option value="updater">ACTUALIZADOR</option>
                <option value="created_at">FECHA DE CREACIÓN</option>
                <option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
            </select>
        </div>

        <x-jet-input class="py-1 border-black" type="text" wire:model="search"
            placeholder="Buscar ..."></x-jet-input>

        <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
    </div>


    @push('scripts')
        <!-- Script para inicializar el mapa Leaflet -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
            // Obtener las coordenadas del primer punto para centrar el mapa
            var firstPoint = {!! json_encode($points->first()) !!};
            var initialLat = firstPoint.latitude;
            var initialLng = firstPoint.longitude;

            // Definir las coordenadas máximas y mínimas para limitar el mapa
            var southWest = L.latLng(-90, -180);
            var northEast = L.latLng(90, 180);
            var bounds = L.latLngBounds(southWest, northEast);

            // // Inicializar el mapa Leaflet centrado en la primera coordenada y con límites máximos
            var map = L.map('map', {
                minZoom: 1.5, // Establece el zoom mínimo permitido
                maxZoom: 18, // Establece el zoom máximo permitido
                maxBounds: bounds // Establece los límites máximos del mapa
            }).setView([initialLat, initialLng], 10); // Se ajustó el nivel de zoom a 10

            // Agregar la capa de basemaps al mapa ya que con esta si que aparece en español
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://carto.com/"></a> ',
            }).addTo(map);

            // Iterar sobre los puntos y agregar marcadores
            @foreach ($points as $point)
                L.marker([{{ $point->latitude }}, {{ $point->longitude }}])
                    .addTo(map)
                    .bindPopup(
                        '<img src="{{ $point->photographies->first()->route ?? '' }}" alt="Fotografía del punto de interés">' +
                        '<br><b>Nombre:</b> {{ $point->name }}' +
                        '<br><b>Descripción del lugar:</b> {{ $point->place->description }}' +
                        '<br><b>Latitud:</b> {{ $point->latitude }}' +
                        '<br><b>Longitud:</b> {{ $point->longitude }}'
                    );
            @endforeach
        </script>
    @endpush
    @livewire('admin.point.create-point')

    @if (count($points))
        @livewire('admin.point.edit-point')

        <x-table>
            <x-slot name="thead">
                <th scope="col" class="px-6 py-3">
                    QR
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('id')">
                    ID
                    @if ($sortField === 'id' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'id' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('distance')">
                    Distancia
                    @if ($sortField === 'distance' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'distance' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('latitude')">
                    Latitud
                    @if ($sortField === 'latitude' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'latitude' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('longitude')">
                    Longitud
                    @if ($sortField === 'longitude' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'longitude' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('place_id')">
                    Sitio
                    @if ($sortField === 'place_id' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'place_id' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('creator')">
                    Creador
                    @if ($sortField === 'creator' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'creator' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('updater')">
                    Actualizador
                    @if ($sortField === 'updater' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'updater' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('created_at')">
                    Fecha creación
                    @if ($sortField === 'created_at' && $sortDirection === 'asc')
                        <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'created_at' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                    @endif
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only">Actions</span>
                </th>
            </x-slot>

            <x-slot name="tbody">
                @foreach ($points as $point)
                    <tr
                        class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {!! QrCode::size(100)->generate(json_encode($point, JSON_PRETTY_PRINT)) !!}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->id }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->name }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->distance }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->latitude }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->longitude }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->place->name }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ \App\Models\User::find($point->creator)->name }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            @if ($point->updater)
                                {{ \App\Models\User::find($point->updater)->name }}
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $point->created_at }}
                        </td>
                        <td
                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex gap-4 mt-10">
                            <span class="font-medium text-yellow-400 cursor-pointer"
                                wire:click="$emitTo('admin.point.edit-point', 'openEditModal', '{{ $point->id }}')">
                                <i class="fa-solid fa-pencil"></i>
                            </span>
                            <span class="font-medium text-red-500 cursor-pointer"
                                wire:click="$emit('deletePoint', '{{ $point->id }}')">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

        @if ($points->hasPages())
            <div class="mt-6">
                {{ $points->links() }}
            </div>
        @endif
    @else
        <p class="mt-4">No se han encontrado resultados</p>
    @endif
    <div style="width: 100%; height: 70vh; display: {{ $showMap ? 'block' : 'none' }};">
        <div id="map" style="width: 100%; height: 100%;" wire:ignore></div>
    </div>

    <div class="flex items-center mb-6">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    </div>
    {{-- Modal show --}}
    <x-jet-dialog-modal wire:model="detailsModal.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del Punto de Interes #{{ $detailsModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-jet-label>
                        Nombre: {{ $detailsModal['name'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Distancia: {{ $detailsModal['distance'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Latitud: {{ $detailsModal['latitude'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Longitud: {{ $detailsModal['longitude'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Sitio: {{ $detailsModal['placeName'] }} ({{ $detailsModal['placeId'] }})
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Creador: {{ $detailsModal['creatorName'] }} ({{ $detailsModal['creatorId'] }})
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Actualizador:
                        @if ($detailsModal['updaterName'])
                            {{ $detailsModal['updaterName'] }} ({{ $detailsModal['updaterId'] }})
                        @else
                            {{ 'ninguno' }}
                        @endif
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Fecha de creación: {{ $detailsModal['createdAt'] }}
                    </x-jet-label>
                </div>
                <div>
                    <x-jet-label>
                        Fecha de actualización: {{ $detailsModal['updatedAt'] }}
                    </x-jet-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModal.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-jet-dialog-modal>

    @push('scripts')
        <script>
            Livewire.on('deletePoint', pointId => {
                Swal.fire({
                    title: '¿Quieres eliminar este punto?',
                    text: 'Esta operación es irreversible',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.point.show-point', 'delete', pointId)
                        Swal.fire(
                            '¡Hecho!',
                            'El punto ha sido borrado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
