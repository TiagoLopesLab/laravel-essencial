<x-layouts.app>
    <x-slot name="header">
        <x-h2>
            {{ __('Email List') }}
        </x-h2>
    </x-slot>

    <x-card class="flex flex-col gap-8">
        <div class="flex justify-between">
            <x-link-button :href="route('email-list.create')">
                {{ __('Create a new Email List') }}
            </x-link-button>

            <x-form :action="route('email-list.index')" method="get" class="w-2/5">
                <x-text-input name="search" id="search" :placeholder="__('Search')" :value="$search" />
            </x-form>
        </div>
        @unless($emailLists->isEmpty() && blank($search))
            <x-table :headers="['#', __('Title'), __('Quantity'), __('Actions')]">
                @foreach($emailLists as $emailList)
                    <tr>
                        <x-table.td>{{ $emailList->id }}</x-table.td>
                        <x-table.td>{{ $emailList->title }}</x-table.td>
                        <x-table.td>{{ $emailList->subscribers_count }}</x-table.td>
                        <x-table.td>
                            <x-link-button :href="route('subscribers.index', $emailList)">
                                {{ __('View Subscribers') }}
                            </x-link-button>
                        </x-table.td>
                    </tr>
                @endforeach
            </x-table>

            {{ $emailLists->links() }}
        @else
            <div class="flex justify-center">
                <x-link-button :href="route('email-list.create')">
                    {{ __('Create your first email list') }}
                </x-link-button>
            </div>
        @endunless
    </x-card>
</x-layouts.app>
