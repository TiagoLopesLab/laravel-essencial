<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Templates') }}
        </x-h2>
    </x-slot>

    <x-card class="flex flex-col gap-8">
        <div class="flex justify-between items-center">
            <x-button.link :href="route('templates.create')">
                {{ __('Create a new Template') }}
            </x-button.link>

            <x-form :action="route('templates.index')" method="get" class="w-2/5" x-data x-ref="form">
                <x-input.checkbox
                    name="show_trash"
                    value="1"
                    :label="__('Show deleted records')"
                    @click="$refs.form.submit()"
                    :checked="$showTrash"
                />
                <x-input.text name="search" id="search" :placeholder="__('Search')" :value="$search" />
            </x-form>
        </div>
        @unless($templates->isEmpty() && blank($search))
            <x-table :headers="['#', __('Name'), __('Actions')]">
                @foreach($templates as $template)
                    <tr>
                        <x-table.td>{{ $template->id }}</x-table.td>
                        <x-table.td>{{ $template->name }}</x-table.td>
                        <x-table.td class="flex gap-4">
                            <x-button.link :href="route('templates.show', $template)">
                                {{ __('Preview') }}
                            </x-button.link>
                            <x-button.link :href="route('templates.edit', $template)">
                                {{ __('Edit') }}
                            </x-button.link>
                            <x-form method="delete" :action="route('templates.destroy', $template)">
                                <x-button.secondary type="submit" class="w-fit" :disabled="$template->trashed()">
                                    {{ __('Delete') }}
                                </x-button.secondary>
                            </x-form>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-table>

            {{ $templates->links() }}
        @else
            <div class="flex justify-center">
                <x-button.link :href="route('templates.create')">
                    {{ __('Create your first template') }}
                </x-button.link>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
