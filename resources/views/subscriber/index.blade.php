<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            <a href="{{ route('email-list.index') }}">{{ __('Email List') }}</a> > {{ $emailList->title }} > {{ __('Subscribers') }}
        </x-h2>
    </x-slot>

    <x-card class="flex flex-col gap-8">
        <div class="flex justify-between">
            <x-link-button :href="route('subscribers.create', $emailList)">
                {{ __('Create a new Subscriber') }}
            </x-link-button>

            <x-form :action="route('subscribers.index', $emailList)" :post="false" class="w-2/5">
                <x-text-input name="search" id="search" :placeholder="__('Search')" :value="$search" />
            </x-form>
        </div>
        <x-table :headers="['#', __('Name'), __('Email'), __('Actions')]">
            @foreach($subscribers as $subscriber)
                <tr>
                    <x-table.td>{{ $subscriber->id }}</x-table.td>
                    <x-table.td>{{ $subscriber->name }}</x-table.td>
                    <x-table.td>{{ $subscriber->email }}</x-table.td>
                    <x-table.td>
                        <x-primary-button type="button">{{ __('Update') }}</x-primary-button>
                        <x-secondary-button type="button">{{ __('Delete') }}</x-secondary-button>
                    </x-table.td>
                </tr>
            @endforeach
        </x-table>

        {{ $subscribers->links() }}
    </x-card>
</x-layouts.app>
