<div>
    <div>
        <div class="flex items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Listado de áreas temáticas</h1>

            <button wire:click="$toggle('createForm.open')" type="button" class="text-white bg-blue-700
                hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm
                px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none
                dark:focus:ring-blue-800 ml-auto">
                Añadir
            </button>
        </div>

        <div class="mb-3">
            <div class="inline">
                <select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model.live="searchColumn">
                    <option value="id">ID</option>
                    <option value="name">NOMBRE</option>
                    <option value="description">DESCRIPCIÓN</option>
                    <option value="created_at">FECHA DE CREACIÓN</option>
                    <option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
                </select>
            </div>

            <x-input class="py-1 border-black" type="text" wire:model.live="search"
                placeholder="Buscar ..."></x-input>

            <x-button wire:click="resetFilters">Eliminar filtros</x-button>

        </div>

        @if(count($thematicAreas))
            <x-table>
                <x-slot name="thead">
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('id')">
                        ID
                        @if($sortField === 'id' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'id' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('name')">
                        Nombre
                        @if($sortField === 'name' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'name' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('description')">
                        Descripción
                        @if($sortField === 'description' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'description' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('created_at')">
                        Fecha creación
                        @if($sortField === 'created_at' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'created_at' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('updated_at')">
                        Fecha actualización
                        @if($sortField === 'updated_at' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'updated_at' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </x-slot>

                <x-slot name="tbody">
                    @foreach($thematicAreas as $thematicArea)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $thematicArea->id }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $thematicArea->name }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $thematicArea->description }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $thematicArea->created_at }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $thematicArea->updated_at }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex gap-4">
                                <span class="font-medium text-blue-600 cursor-pointer" wire:click="show('{{ $thematicArea->id }}')">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                                    <span class="font-medium text-yellow-400 cursor-pointer"
                                          wire:click="edit('{{ $thematicArea->id }}')">
                                    <i class="fa-solid fa-pencil"></i>
                                </span>
                                    <span class="font-medium text-red-500 cursor-pointer"
                                          wire:click="$dispatch('deleteThematicArea', '{{ $thematicArea->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>

            @if($thematicAreas->hasPages())
                <div class="mt-6">
                    {{ $thematicAreas->links() }}
                </div>
            @endif
        @else
            <p class="mt-4">No se han encontrado resultados</p>
        @endif
    </div>

    <x-dialog-modal wire:model.live="showModal.open">
        <x-slot name="title">
            <span class="text-2xl">Detalle del área temática #{{ $showModal['id'] }}</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label>
                        Nombre: {{ $showModal['name'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Descripción: {{ $showModal['description'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Fecha de creación: {{ $showModal['createdAt'] }}
                    </x-label>
                </div>

                <div class="mb-4">
                    <x-label>
                        Fecha de actualización: {{ $showModal['updatedAt'] }}
                    </x-label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="$toggle('showModal.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="createForm.open">
        <x-slot name="title">
            <span class="text-2xl">Crear área temática</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label>
                        Nombre
                    </x-label>

                    <input wire:model.live="createForm.name" type="text" id="name" minlength="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                    <x-input-error for="createForm.name" class="mt-2" />
                </div>
                <div>
                    <x-label>
                        Descripción
                    </x-label>

                    <textarea wire:model.live="createForm.description" rows="4" class="block p-2.5 w-full
                    text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500
                    focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"></textarea>

                    <x-input-error for="createForm.description" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button style="margin-right: 10px;" wire:click="save">
                Crear
            </x-button>
            <x-button wire:click="$toggle('createForm.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="editModal.open">
        <x-slot name="title">
            <span class="text-2xl">Actualizar área temática</span>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="mb-4">
                    <x-label>
                        Nombre
                    </x-label>

                    <input wire:model.live="editForm.name" type="text" id="name" minlength="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>

                    <x-input-error for="editForm.name" class="mt-2" />
                </div>
                <div>
                    <x-label>
                        Descripción
                    </x-label>

                    <textarea wire:model.live="editForm.description" rows="4" class="block p-2.5 w-full
                    text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500
                    focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                    dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"></textarea>

                    <x-input-error for="editForm.description" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button style="margin-right: 10px;" wire:click="update({{ $editModal['id'] }})">
                Actualizar
            </x-button>
            <x-button wire:click="$toggle('editModal.open')">
                Cerrar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            Livewire.on('thematicAreaCreated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'El área temática ha sido creada.',
                    'success'
                )
            });
        </script>

        <script>
            Livewire.on('thematicAreaUpdated', () => {
                Swal.fire(
                    '¡Hecho!',
                    'El área temática ha sido actualizada.',
                    'success'
                )
            });
        </script>

        <script>
            Livewire.on('deleteThematicArea', thematicAreaId => {
                Swal.fire({
                    title: '¿Quieres eliminar esta área temática?',
                    text: 'Esta operación es irreversible',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: "Cancelar",
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('admin.thematic-area.thematic-areas', 'delete', thematicAreaId)
                        Swal.fire(
                            '¡Hecho!',
                            'El área temática ha sido eliminada.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
