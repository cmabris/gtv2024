<nav class="bg-blue-500 border-gray-200 px-2 sm:px-4 py-2.5 dark:bg-gray-800">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
        <!-- Logo -->
        <div class="hidden md:block" id="logo">
            <a href="{{ route('welcome') }}" class="self-center text-2xl font-semibold whitespace-nowrap text-white">GTV</a>
        </div>
        <!-- Mobile menu button -->
        <button id="menu-toggle" class="md:hidden flex items-center text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Mobile menu -->
        <div class="w-full md:flex md:w-auto hidden" id="mobile-menu">
            <ul class="flex flex-col md:border-4 md:border-r-indigo-500/50 mt-4 md:flex-row md:space-x-6 md:mt-0 md:text-md md:font-bold">
                @role('Administrador')
                <li>
                    <a href="{{ route('users.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Usuarios</a>
                </li>
                <li>
                    <a href="{{ route('video-items.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeo Items</a>
                </li>
                @endrole
                @hasanyrole('Administrador|Profesor')
                <li>
                    <a href="{{ route('thematic-areas.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Áreas temáticas</a>
                </li>
                <li>
                    <a href="{{ route('visit.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Visitas</a>
                </li>
                @endhasanyrole
                @hasanyrole('Administrador|Profesor|Alumno')
                <li>
                    <a href="{{ route('points.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Puntos de Interés</a>
                </li>
                <li>
                    <a href="{{ route('places.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Lugares</a>
                </li>
                <li>
                    <a href="{{ route('videos.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vídeos</a>
                </li>
                <li>
                    <a href="{{ route('photographies.index') }}" class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-gray-200 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Foto</a>
                </li>
                @endhasanyrole
            </ul>
        </div>

        <!-- Profile photo -->
        <div class="hidden md:block ml-8 relative mt-0 flex items-center" id="profile-photo">
            @auth
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-10 w-10 md:h-8 md:w-8 lg:w-4 lg:h-4 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->login }}" />
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-sm text-gray-400">
                            @if (auth()->user()->roles->first())
                                {{ auth()->user()->roles->first()->name }}
                            @endif
                        </div>

                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            @endauth
            @role('Administrador')
                <div class="space-x-4">
                @livewire('admin.unread-email-counter')
                </div>
            @endrole
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var menu = document.getElementById('mobile-menu');
        var logo = document.getElementById('logo');
        var profilePhoto = document.getElementById('profile-photo');
        var menuToggle = document.getElementById('menu-toggle');

        menuToggle.addEventListener('click', function () {
            menu.classList.toggle('hidden');
            if (menu.classList.contains('hidden')) {
                logo.classList.remove('hidden');
                profilePhoto.classList.remove('hidden');
            } else {
                logo.classList.add('hidden');
                profilePhoto.classList.add('hidden');
            }
        });

        function updateLayout() {
            if (window.innerWidth < 1024) {
                menuToggle.classList.remove('hidden');
                menu.classList.add('hidden');
                logo.classList.add('hidden');
                profilePhoto.classList.add('hidden');
            } else {
                menuToggle.classList.add('hidden');
                logo.classList.remove('hidden');
                profilePhoto.classList.remove('hidden');
                menu.classList.remove('hidden');
            }
        }

        updateLayout();

        window.addEventListener('resize', updateLayout);
    });
</script>

