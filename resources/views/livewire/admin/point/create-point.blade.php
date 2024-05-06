<div>
    <x-dialog-modal wire:model.live="createForm.open">
        <x-slot name="title">
            <span class="text-2xl">Añadir Punto de Interes</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div>
                    <x-label>
                        Nombre
                    </x-label>
                    <input wire:model.live="createForm.name" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1">
                    <x-input-error for="createForm.name" class="mt-2" />

                    <x-label>
                        Distancia
                    </x-label>
                    <input wire:model.live="createForm.distance" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1">
                    <x-input-error for="createForm.distance" class="mt-2" />
                </div>
                <div>
                    <x-label>
                        Longitud
                    </x-label>
                    <input wire:model.live="createForm.longitude" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"></input>
                    <x-input-error for="createForm.longitude" class="mt-2" />
                </div>

                <div>
                    <x-label>
                        Latitud
                    </x-label>
                    <input wire:model.live="createForm.latitude" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"></input>
                    <x-input-error for="createForm.latitude" class="mt-2" />
                </div>

                <div>
                    <x-label>
                        Lugar
                    </x-label>
                    <select wire:model.live="createForm.place" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1">
                        <option value="" selected disabled>Elige uno</option>
                        @foreach($places as $place)
                            <option value="{{ $place->id }}">{{ $place->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="createForm.place" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button color="blue" wire:click="save">
                Crear
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @push('scripts')
        <script>
            Livewire.on('PointCreated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'El Punto ha sido creado.',
                    'success'
                )
            });
        </script>
    @endpush
</div>
