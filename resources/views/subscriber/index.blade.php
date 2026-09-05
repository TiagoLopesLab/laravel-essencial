<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            <a href="{{ route('email-list.index') }}">{{ __('Email List') }}</a> > {{ $emailList->title }} > {{ __('Subscribers') }}
        </x-h2>
    </x-slot>

    <x-card class="flex flex-col gap-8">
        <div class="flex justify-between items-center">
            <x-button.link :href="route('subscribers.create', $emailList)">
                {{ __('Create a new Subscriber') }}
            </x-button.link>

            <x-form :action="route('subscribers.index', $emailList)" method="get" class="w-2/5" x-data x-ref="form">
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
        <x-table :headers="['#', __('Name'), __('Email'), __('Actions')]">
            @foreach($subscribers as $subscriber)
                <tr>
                    <x-table.td>{{ $subscriber->id }}</x-table.td>
                    <x-table.td>{{ $subscriber->name }}</x-table.td>
                    <x-table.td>{{ $subscriber->email }}</x-table.td>
                    <x-table.td>
                        <x-form method="delete" :action="route('subscriber.destroy', [$emailList, $subscriber])">
                            <x-button.secondary type="submit" class="w-fit" :disabled="$subscriber->trashed()">
                                {{ __('Delete') }}
                            </x-button.secondary>
                        </x-form>
                    </x-table.td>
                </tr>
            @endforeach
        </x-table>

        {{ $subscribers->links() }}
    </x-card>
</x-layouts.app>
