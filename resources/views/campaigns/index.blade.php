<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Campaigns') }}
        </x-h2>
    </x-slot>

    <x-card class="flex flex-col gap-8">
        <div class="flex justify-between items-center">
            <x-button.link :href="route('campaigns.create')">
                {{ __('Create a new Campaign') }}
            </x-button.link>

            <x-form :action="route('campaigns.index')" method="get" class="w-2/5" x-data x-ref="form">
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
        @unless($campaigns->isEmpty() && blank($search))
            <x-table :headers="['#', __('Name'), __('Actions')]">
                @foreach($campaigns as $campaign)
                    <tr>
                        <x-table.td>{{ $campaign->id }}</x-table.td>
                        <x-table.td>{{ $campaign->name }}</x-table.td>
                        <x-table.td class="flex gap-4">
                            <x-form method="delete" :action="route('campaigns.destroy', $campaign)">
                                <x-button.secondary type="submit" class="w-fit" :disabled="$campaign->trashed()">
                                    {{ __('Delete') }}
                                </x-button.secondary>
                            </x-form>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-table>

            {{ $campaigns->links() }}
        @else
            <div class="flex justify-center">
                <x-button.link :href="route('campaigns.create')">
                    {{ __('Create your first campaign') }}
                </x-button.link>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
