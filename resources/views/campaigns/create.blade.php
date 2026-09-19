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
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input.label for="name" :value="__('Name')" />
                        <x-input.text name="name" id="name" class="block mt-1 w-full" :value="old('name')" autofocus />
                        <x-input.error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input.label for="subject" :value="__('Subject')" />
                        <x-input.text name="subject" id="subject" class="block mt-1 w-full" />
                        <x-input.error :messages="$errors->get('subject')" class="mt-2" />
                    </div>

                    <div>
                        <x-input.label for="email_list_id" :value="__('Email List')" />
                        <x-input.text name="email_list_id" id="email_list_id" class="block mt-1 w-full" :value="old('email_list_id')" />
                        <x-input.error :messages="$errors->get('email_list_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input.label for="email" :value="__('Email')" />
                        <x-input.text name="email" id="email" type="email" class="block mt-1 w-full" />
                        <x-input.error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

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
