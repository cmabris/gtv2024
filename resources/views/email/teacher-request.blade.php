<div>
    <div>
        <div class="flex items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-700">Listado de Emails</h1>
        </div>

        <div class="mb-3">
            <div class="inline">
                <select class="text-black bg-blue-100 hover:bg-grey-200 focus:ring-4 focus:ring-blue-300
                    font-medium rounded-lg text-sm py-1.5 dark:bg-blue-600 dark:hover:bg-blue-700
                    focus:outline-none dark:focus:ring-blue-800 ml-auto" wire:model="searchColumn">
                    <option value="id">ID</option>
                    <option value="body">CUERPO DEL MENSAJE</option>
                    <option value="created_at">FECHA DE CREACIÓN</option>
                    <option value="updated_at">FECHA DE ACTUALIZACIÓN</option>
                </select>
            </div>

            <x-jet-input class="py-1 border-black" type="text" wire:model="search" placeholder="Buscar ..."></x-jet-input>

            <x-jet-button wire:click="resetFilters">Eliminar filtros</x-jet-button>
        </div>

        @if(count($emails))
            <x-table>
                <x-slot name="thead">
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('id')">
                        ID
                        @if($sortField === 'id' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up"></i>
                        @elseif($sortField === 'id' && $sortDirection === 'desc')
                            <i class="fa-solid fa-arrow-down"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sort('from')">
                        From
                        @if($sortField === 'from' && $sortDirection === 'asc')
                            <i class="fa-solid fa-arrow-up"></i>
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

    <!-- Modal -->
    <div x-data="{ showModal: @entangle('showModal') }" x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg dark:bg-gray-800 max-w-lg mx-auto p-8">
            @if ($email)
                <h5 class="text-4xl font-bold whitespace-nowrap text-gray-800">GTV</h5>
                <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400 font-bold">Request for change of role to teacher</p>
                <div class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                    <svg class="w-36 h-36 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <div class="space-y-1">
                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">ID: <span class="text-gray-500">{{ $email->id }}</span></p>
                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">From: <span class="text-gray-500">{{ $email->from }}</span></p>
                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Body: <span class="text-gray-500">{{ $email->body }}</span></p>
                    <button wire:click="closeModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Close
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>