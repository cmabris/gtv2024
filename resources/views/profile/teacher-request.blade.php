<x-jet-action-section>
    <x-slot name="title">
        {{ __('Fetch Teacher') }}
    </x-slot>

    <x-slot name="description">
        {{ __(' Application for the Position of Teacher') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('By clicking, you send a request to our administrators, who will grant you access as a teacher.') }}
        </div>

        <div class="mt-5">
            <x-jet-button wire:click="confirmSendEmail" wire:loading.attr="disabled">
                {{ __('Petition') }}
            </x-jet-button>
        </div>

        <!-- Change User Confirmation Modal -->
        <!-- Change User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="SendEmailToAdmin">
            <x-slot name="title">
                {{ __('Petition to admin email') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to send a email to change your role to Teacher?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('SendEmailToAdmin')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="sendEmail" wire:loading.attr="disabled">
                    {{ __('Send email') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
