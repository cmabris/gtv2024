<x-jet-action-section>
    <x-slot name="title">
        {{ __('GTVisor user') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Change to a GTVisor user.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once you click this button, you will become a GTVisor user and will have access to the map menu. To revert, go back to the profile and you will have a button to return to your original role.') }}
        </div>

        <div class="mt-5">
            <x-jet-button wire:click="confirmChangeUser" wire:loading.attr="disabled">
                {{ __('Change') }}
            </x-jet-button>
        </div>

        <!-- Change User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Change to GTVisor') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to change your role to GTVisor?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="changeUser" wire:loading.attr="disabled">
                    {{ __('Change to GTVisor') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
