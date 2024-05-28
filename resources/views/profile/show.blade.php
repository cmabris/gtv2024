<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-jet-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-jet-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

            <x-jet-section-border />

            <div class="mt-10 sm:mt-0">
                @if(auth()->user()->hasRole('GTVisor') && (auth()->user()->toArray()['previous_role'] == null))
                @elseif(auth()->user()->hasRole('GTVisor'))
                    @livewire('profile.revert-gtvisor-user')
                @else
                    @livewire('profile.create-gtvisor-user')
                @endif
            </div>
                <x-jet-section-border />

                @role('Alumno')

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.teacher-request')
                </div>

                @endrole


        </div>
    </div>
</x-app-layout>
