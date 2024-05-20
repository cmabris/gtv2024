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
            <x-jet-button wire:click="confirmChangeUser" wire:loading.attr="disabled">
                {{ __('Petition') }}
            </x-jet-button>
        </div>

        <!-- Change User Confirmation Modal -->

    </x-slot>
</x-jet-action-section>
