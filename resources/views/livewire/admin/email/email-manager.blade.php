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

    <!-- Modal -->
    @if($showModal)
        <div x-data="{ showModal: @entangle('showModal') }">
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-50 transition-opacity ease-out duration-300" x-show="showModal">
                <div class="bg-white p-6 rounded shadow-lg transform transition-all ease-in-out duration-300"
                    x-show="showModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90">

                    <div>
                        <!-- Page Content -->
                        <main>
                            <div class="mt-4 p-4 max-w-lg text-center space-y-4 bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 mx-auto">
                                <h5 class="text-4xl font-bold whitespace-nowrap text-gray-800">GTV</h5>
                                <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400 font-bold">{{ $email->subject }}</p>
                                <div class="relative w-36 h-36 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mx-auto">
                                    <svg class="w-36 h-36 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Nombre: <span class="text-gray-500">{{ $user->name }}</span></p>
                                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Email: <span class="text-gray-500">{{ $user->email }}</span></p>
                                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Role: <span class="text-gray-500">{{ $user->roles->first()->name    }}</span></p>
                                </div>

                                <div>
                                    <a href="{{ route('users.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                        Ir a usuarios
                                    </a>
                                    <button wire:click="closeModal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Cerrar</button>
                                </div>
                            </div>
                        </main>
                    </div>

                    
                </div>
            </div>
        </div>
    @endif
</div>
