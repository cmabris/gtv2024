<div class="ml-8 bottom-5">
    <x-jet-dropdown width="96">
        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer">
                <img class="w-8 h-8 sm:w-10 sm:h-10" src="https://img.icons8.com/material-outlined/24/inbox.png" alt="inbox"/>
                @if($emailCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs sm:text-sm font-bold text-red-100 bg-red-600 rounded-full">
                        {{ $emailCount }}
                    </span>
                @endif
            </span>
        </x-slot>

        <x-slot name="content">
            <ul>
                @forelse($emails as $email)
                    <li class="flex p-2 border-b border-gray-200">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $email->subject }}</h1>
                            <p class="">{{ $email->created_at->format('d-m-Y H:i') }}</p>
                            <p class="text-gray-600">{{ Str::limit($email->body, 50) }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene peticiones
                        </p>
                    </li>
                @endforelse
            </ul>
            @if($emailCount > 0)
                <div class="px-3 py-2">
                    <a href="{{ route('admin.emails') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Ver peticiones
                    </a>
                </div>
            @endif
        </x-slot>
    </x-jet-dropdown>
</div>