<div>
    <h1 class="text-2xl font-semibold text-gray-700">Bienvenido <span class="text-blue-500 font-bold">{{ auth()->user()->name }}</span></h1>

    <div class="mt-6 space-y-10">
        @role('Administrador')

        {{--TABLA USUARIOS   ID-NOMBRE-EMAIL--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="3">
                        ÚLTIMOS USUARIOS REGISTRADOS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countusers}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        FOTO
                    </td>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        NOMBRE
                    </td>
                    <td class="px-6 py-3">
                        EMAIL
                    </td>
                </tr>
                @foreach($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            @if($user->profile_photo_path)
                                <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_path }}" alt="User avatar">
                            @else
                                <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                                    <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showUsers('{{ $user->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endrole

        @hasanyrole('Administrador|Profesor')
        {{--TABLA VISITAS   ID-SSOO-PUNTO DE INTERÉS--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMAS VISITAS REGISTRADAS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countvisits}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        SSOO
                    </td>
                    <td class="px-6 py-3">
                        PUNTO DE INTERÉS
                    </td>
                </tr>
                @foreach($visits as $visit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            <div>{{ $visit->id}}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div>{{ $visit->ssoo }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div >{{ $visit->point_of_interest_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showVisits('{{ $visit->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        {{--TABLA ÁREAS TEMÁTICAS   ID-NOMBRE-DESCRIPCIÓN--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMAS ÁREAS TEMÁTICAS CREADAS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countareas}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        NOMBRE
                    </td>
                    <td class="px-6 py-3">
                        DESCRIPCIÓN
                    </td>
                </tr>
                @foreach($thematicAreas as $thematicArea)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $thematicArea->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $thematicArea->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $thematicArea->description }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showAreas('{{ $thematicArea->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @endhasanyrole

        {{--TABLA PUNTOS DE INTERÉS   ID-DISTANCIA-SITIO--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMOS PUNTOS DE INTERÉS CREADOS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countpoints}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        DISTANCIA
                    </td>
                    <td class="px-6 py-3">
                        SITIO
                    </td>
                </tr>
                @foreach($points as $point)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{$point->id}}
                        </td>
                        <td class="px-6 py-4">
                            {{$point->distance}}
                        </td>
                        <td class="px-6 py-4">
                            {{$point->place->name}}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showPoints('{{ $point->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @hasanyrole('Administrador|Profesor')

        {{--TABLA LUGARES   ID-NOMBRE-DESCRIPCION--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMOS LUGARES CREADOS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countplaces}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        NOMBRE
                    </td>
                    <td class="px-6 py-3">
                        DESCRIPCIÓN
                    </td>
                </tr>
                @foreach($places as $place)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $place->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $place->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $place->description }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showPlaces('{{ $place->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @endhasanyrole

        {{--TABLA VIDEOS   ID-DESCRIPCIÓN-AREA--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMOS VIDEOS SUBIDOS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countvideos}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        DESCRIPCIÓN
                    </td>
                    <td class="px-6 py-3">
                        ÁREA TEMÁTICA
                    </td>
                </tr>
                @foreach($videos as $video)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $video->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $video->description }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $video->thematicArea->name }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showVideos('{{ $video->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{--TABLA FOTOGRAFÍAS   ID-PUNTO INTERÉS-ÁREA TEMÁTICA--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3" colspan="2">
                        ÚLTIMAS FOTOGRAFÍAS SUBIDAS
                    </th>
                    <th scope="col" class="px-6 py-3 text-right" colspan="2">
                        TOTAL - {{$countphotographies}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="px-6 py-3">
                        ID
                    </td>
                    <td class="px-6 py-3">
                        PUNTO INTERÉS
                    </td>
                    <td class="px-6 py-3">
                        ÁREA TEMÁTICA
                    </td>
                </tr>
                @foreach($photographies as $photography)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $photography->id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $photography->point_of_interest_id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $photography->thematic_area_id }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showPhotographies('{{ $photography->id }}')" class="text-orange-500 hover:text-orange-400 hover:underline ml-2 font-semibold">
                                Ver más
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>



    {{-- Modal showVideos --}}
    <x-dialog-modal wire:model.live="detailsModalVideos.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del vídeo #{{ $detailsModalVideos['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                @if($detailsModalVideos['route'] !== null)
                    @livewire('admin.video.video-preview', ['route' => $detailsModalVideos['route']])
                @endif
                <div>
                    <x-label>
                        Descripción: {{ $detailsModalVideos['description']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Ruta: {{ $detailsModalVideos['route'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Orden: {{ $detailsModalVideos['order'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Punto de interés: {{ $detailsModalVideos['pointOfInterest'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        @if( ! empty($detailsModalVideos['thematicAreaId']))
                            Área temática: {{ $detailsModalVideos['thematicAreaName'] }} ({{ $detailsModalVideos['thematicAreaId'] }})
                        @else
                            Área temática: <span class="text-red-600">Sin área temática</span>
                        @endif
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Creador: {{ $detailsModalVideos['creatorName'] }} ({{ $detailsModalVideos['creatorId'] }})
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Actualizador:
                        @if($detailsModalVideos['updaterName'])
                            {{ $detailsModalVideos['updaterName'] }} ({{ $detailsModalVideos['updaterId'] }})
                        @else
                            {{ 'ninguno' }}
                        @endif
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de creación: {{ $detailsModalVideos['createdAt'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de actualización: {{ $detailsModalVideos['updatedAt'] }}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModalVideos.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showTemathicAreas --}}
    <x-dialog-modal wire:model.live="detailsModalAreas.open">
        <x-slot name="title">
            <span class="text-2xl">Detalle del área temática #{{ $detailsModalAreas['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label>
                        Nombre: {{ $detailsModalAreas['name'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Descripción: {{ $detailsModalAreas['description'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Fecha de creación: {{ $detailsModalAreas['createdAt'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    @if($detailsModalAreas['updatedAt'] == NULL)
                        <x-label>
                            Fecha de actualización: No se ha actualizado
                        </x-label>
                    @else
                    <x-label>
                        Fecha de actualización: {{ $detailsModalAreas['updatedAt'] }}
                    </x-label>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('detailsModalAreas.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showUsers --}}
    <x-dialog-modal wire:model.live="detailsModalUsers.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del usuario #{{ $detailsModalUsers['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div class="my-8">
                    @if($detailsModalUsers['avatar'])
                        <img class="w-36 h-36 rounded-full mx-auto" src="{{ $detailsModalUsers['avatar'] }}" alt="User avatar">
                    @else
                        <div class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                            <svg class="w-36 h-36 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                    @endif
                </div>
                <div>
                    <x-label>
                        Nombre: {{ $detailsModalUsers['name']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Email: {{ $detailsModalUsers['email'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Rol: {{ $detailsModalUsers['rol'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de creación: {{ $detailsModalUsers['createdAt'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de actualización: {{ $detailsModalUsers['updatedAt'] }}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModalUsers.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showVisits --}}
    <x-dialog-modal wire:model.live="detailsModalVisits.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles de la Visita #{{ $detailsModalVisits['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-label>
                        Hora: {{ $detailsModalVisits['hour']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Id Dispositivo: {{ $detailsModalVisits['deviceid'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Version de la App: {{ $detailsModalVisits['appversion'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Agente: {{ $detailsModalVisits['useragent'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Sistema Operativo: {{ $detailsModalVisits['ssoo'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Version Sistema Operativo: {{ $detailsModalVisits['ssooversion'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Punto de Interest:
                        {!!QrCode::size(100)->generate(json_encode($detailsModalVisits['point_of_interest_id'], JSON_PRETTY_PRINT)) !!}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModalVisits.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showPoints --}}
    <x-dialog-modal wire:model.live="detailsModalPoints.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del Punto de Interes #{{ $detailsModalPoints['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-label>
                        Distancia: {{ $detailsModalPoints['distance']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Latitud: {{ $detailsModalPoints['latitude'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Longitud: {{ $detailsModalPoints['longitude'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Sitio: {{ $detailsModalPoints['placeName'] }} ({{ $detailsModalPoints['placeId'] }})
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Creador: {{ $detailsModalPoints['creatorName'] }} ({{ $detailsModalPoints['creatorId'] }})
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Actualizador:
                        @if($detailsModalPoints['updaterName'])
                            {{ $detailsModalPoints['updaterName'] }} ({{ $detailsModalPoints['updaterId'] }})
                        @else
                            {{ 'ninguno' }}
                        @endif
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de creación: {{ $detailsModalPoints['createdAt'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de actualización: {{ $detailsModalPoints['updatedAt'] }}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModalPoints.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showPlaces --}}
    <x-dialog-modal wire:model.live="detailsModalPlaces.open">
        <x-slot name="title">
            <span class="text-2xl">Detalles del lugar #{{ $detailsModalPlaces['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <div>
                    <x-label>
                        ID: {{ $detailsModalPlaces['id']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Nombre: {{ $detailsModalPlaces['name']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Descripción: {{ $detailsModalPlaces['description']}}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Creador: {{ $detailsModalPlaces['creatorName'] }} ({{ $detailsModalPlaces['creatorId'] }})
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Actualizador:
                        @if($detailsModalPlaces['updaterName'])
                            {{ $detailsModalPlaces['updaterName'] }} ({{ $detailsModalPlaces['updaterId'] }})
                        @else
                            {{ 'ninguno' }}
                        @endif
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Fecha de creación: {{ $detailsModalPlaces['createdAt'] }}
                    </x-label>
                </div>
                <div>
                    <x-label>
                        Última actualización: {{ $detailsModalPlaces['updatedAt'] }}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$set('detailsModalPlaces.open', false)">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal showPhotographies--}}
    <x-dialog-modal wire:model.live="detailsModalPhotographies.open">
        <x-slot name="title">
            <span class="text-2xl">Detalle de la fotografía #{{ $detailsModalPhotographies['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <a class="max-w-xs" href="{{ $detailsModalPhotographies['route'] }}" target="_blank">
                        <img src="{{ $detailsModalPhotographies['route'] }}">
                    </a>
                </div>

                <div class="mb-4">
                    <x-label>
                        Ruta: {{ $detailsModalPhotographies['route'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Orden: {{ $detailsModalPhotographies['order'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Punto de interes: {{ $detailsModalPhotographies['pointOfInterestId'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        @if( ! empty($detailsModalPhotographies['thematicAreaId']))
                            Área temática: {{ $detailsModalPhotographies['thematicAreaName'] }} (ID: {{ $detailsModalPhotographies['thematicAreaId'] }})
                        @else
                            Área temática: <span class="text-red-600">Sin área temática</span>
                        @endif
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Creador: {{ $detailsModalPhotographies['creatorName'] }} (ID: {{ $detailsModalPhotographies['creatorId'] }})
                    </x-label>
                </div>

                @if( ! is_null($detailsModalPhotographies['updaterId']))
                    <div class="mb-4">
                        <x-label>
                            Actualizador: {{ $detailsModalPhotographies['updaterName'] }} (ID: {{ $detailsModalPhotographies['updaterId'] }})
                        </x-label>
                    </div>
                @endif

                <div class="mb-4">
                    <x-label>
                        Fecha de creación: {{ $detailsModalPhotographies['createdAt'] }}
                    </x-label>
                </div>

                @if( ! is_null($detailsModalPhotographies['updaterId']))
                    <div class="mb-4">
                        <x-label>
                            Fecha de actualización: {{ $detailsModalPhotographies['updatedAt'] }}
                        </x-label>
                    </div>
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('detailsModalPhotographies.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
