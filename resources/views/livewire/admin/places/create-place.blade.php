<div>
    <x-dialog-modal wire:model.live="createForm.open">
        <x-slot name="title">
            <span class="text-2xl">Añadir lugar</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div>
                    <x-label>
                        Nombre
                    </x-label>
                    <x-input type="text" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"
                                 wire:model.live="createForm.name" />
                    <x-input-error for="createForm.name" class="mt-2" />
                </div>
                <div>
                    <x-label>
                        Descripción
                    </x-label>
                    <textarea wire:model.live="createForm.description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"></textarea>
                    <x-input-error for="createForm.description" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button color="blue"
                      wire:click="save">
                Crear
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @push('scripts')
        <script>
            Livewire.on('placeCreated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'El lugar ha sido creado.',
                    'success'
                )
            });
        </script>
    @endpush
</div>
