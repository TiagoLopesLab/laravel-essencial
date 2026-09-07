<x-layouts.app>
    <x-slot:header>
        <x-h2>
            {{ __('Create new template') }}
        </x-h2>
    </x-slot:header>

    <x-card>
        <x-form :action="route('templates.store')">
            <div class="space-y-4">
                <div>
                    <x-input.label for="name" :value="__('Name')" />
                    <x-input.text name="name" id="name" class="block mt-1 w-full" :value="old('name')" autofocus />
                    <x-input.error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input.label for="body" :value="__('Body')" />
                    <x-input.richtext name="body" id="body" />
                    <x-input.error :messages="$errors->get('body')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-button.link :href="route('templates.index')">
                    {{ __('Cancel') }}
                </x-button.link>

                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </x-form>
    </x-card>
</x-layouts.app>
