<x-layouts.app>
    <x-slot:header>
        <x-h2>
            {{ __('Email List') }} > {{ __('Create new list') }}
        </x-h2>
    </x-slot:header>

    <x-card>
        <x-form :action="route('email-list.store')">
            <div class="space-y-4">
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input name="title" id="title" class="block mt-1 w-full" :value="old('title')" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="file" :value="__('File List')" />
                    <x-text-input name="file" id="file" type="file" class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-secondary-button type="reset">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button type="submit">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </x-form>
    </x-card>
</x-layouts.app>
