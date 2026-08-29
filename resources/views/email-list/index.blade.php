<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Email List') }}
        </x-h2>
    </x-slot>

    <x-card>
        @unless($emailLists->isEmpty())
            <x-table :headers="['#', __('Title'), __('Quantity'), __('Actions')]">
                @foreach($emailLists as $emailList)
                    <tr>
                        <x-table.td>{{ $emailList->id }}</x-table.td>
                        <x-table.td>{{ $emailList->title }}</x-table.td>
                        <x-table.td>{{ $emailList->subscribers()->count() }}</x-table.td>
                        <x-table.td>
                            <x-primary-button type="button">{{ __('Update') }}</x-primary-button>
                            <x-secondary-button type="button">{{ __('Delete') }}</x-secondary-button>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-table>
        @else
            <div class="flex justify-center">
                <x-link-button :href="route('email-list.create')">
                    {{ __('Create your first email list') }}
                </x-link-button>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
