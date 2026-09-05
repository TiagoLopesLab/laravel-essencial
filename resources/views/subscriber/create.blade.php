<x-layouts.app>
    <x-slot:header>
        <x-h2>
            {{ __('Email List') }} > {{ $emailList->title }} > {{ __('Create new subscriber') }}
        </x-h2>
    </x-slot:header>

    <x-card>
        <x-form :action="route('subscribers.store', $emailList)" enctype="multipart/form-data">
            <div class="space-y-4">
                <div>
                    <x-input.label for="name" :value="__('Name')" />
                    <x-input.text name="name" id="name" class="block mt-1 w-full" :value="old('name')" autofocus />
                    <x-input.error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input.label for="email" :value="__('Email')" />
                    <x-input.text name="email" id="email" type="email" class="block mt-1 w-full" />
                    <x-input.error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <x-button.link :href="route('subscribers.index', $emailList)">
                    {{ __('Cancel') }}
                </x-button.link>

                <x-button type="submit">
                    {{ __('Save') }}
                </x-button>
            </div>
        </x-form>
    </x-card>
</x-layouts.app>
