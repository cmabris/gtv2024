<x-jet-action-section>
    <x-slot name="title">
        {{ __('GTVisor user') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Change a gtvisor user.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once you click this button, the user will become a gtvisor user and will be able to access the map menu. If you want to go back to being a user you were before, go back to the profile and you will have a button that will return you to your original user.') }}
        </div>

        <div class="mt-5">
            <x-jet-button wire:click="confirmChangeUser" wire:loading.attr="disabled">
                {{ __('Change') }}
            </x-jet-danger-button>
        </div>

        <!-- Change User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Change gtvisor') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure about that, if you want to go back to being a user you were before, go back to the profile and you will have a button that will return you to your original user.') }}

            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-3" wire:click="changeUser" wire:loading.attr="disabled">
                    {{ __('Change to gtvisor') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>