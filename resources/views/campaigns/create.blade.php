<x-layouts.app>
    <x-slot:header>
        <x-h2>
            {{ __('Campaign') }} > {{ __('Create new campaign') }}
        </x-h2>
    </x-slot:header>

    <x-card>
        <x-tabs :tabs="[
            __('Setup') => route('campaigns.create'),
            __('Email Body') => route('campaigns.create', ['tab' => 'template']),
            __('Schedule') => route('campaigns.create', ['tab' => 'schedule']),
        ]">
            <x-form :action="route('campaigns.store')">
                @include('campaigns.create.' . $form)

                <div class="flex items-center gap-4">
                    <x-button.link :href="route('campaigns.index')">
                        {{ __('Cancel') }}
                    </x-button.link>

                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </x-form>
        </x-tabs>
    </x-card>
</x-layouts.app>
