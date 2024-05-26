<div>
    <div>
        <div class="flex items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Listado de Emails</h1>

        </div>

        <div class="mb-3">
            <div class="inline">
                <select class="text-black  bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
                    <option value="id">ID</option>
                    <option value="body">CUERPO DEL MENSAJE</option>
                    <option value="created_at">FECHA DE CREACIÓN</option>
                    <option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
                </select>
            </div>

            <x-jet-input class="py-1 border-black" type="text" wire:model="search"
                placeholder="Buscar ..."></x-jet-input>

            <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
        </div>

        @if(count($emails))
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
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('from')">
                        From
                        @if($sortField === 'from' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up">
                        @elseif($sortField === 'from' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </x-slot>

                <x-slot name="tbody">
                    @foreach($emails as $email)
                        <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $email->id }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $email->from }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex gap-4">
                                <span class="font-medium text-blue-600 cursor-pointer" wire:click="show('{{ $email->id }}')">
                                    <i class="fa-solid fa-eye"></i>
                                </span>
                                <span class="font-medium text-red-600 cursor-pointer" wire:click="$emit('delete', '{{ $email->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @else
            <div>
                <strong>No se encontraron registros</strong>
            </div>
        @endif

        @if($emails->hasPages())
            <div class="px-6 py-3">
                {{ $emails->links() }}
            </div>
        @endif
    </div>


   
</div>