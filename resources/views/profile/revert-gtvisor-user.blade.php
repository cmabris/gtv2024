<x-jet-action-section>
    <x-slot name="title">
        {{ __('Revert to User') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Revert your role to the previous user role.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('If you want to go back to your previous role, click this button.') }}
        </div>

        <div class="mt-5">
            <x-jet-button wire:click="confirmRevertUser" wire:loading.attr="disabled">
                {{ __('Revert') }}
            </x-jet-button>
        </div>

        <x-jet-dialog-modal wire:model="confirmingUserReversion">
            <x-slot name="title">
                {{ __('Revert Role') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to revert to your previous role?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserReversion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="revertUser" wire:loading.attr="disabled">
                    {{ __('Revert') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
