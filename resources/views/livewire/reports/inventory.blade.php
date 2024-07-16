<div>
    <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-3">
        @foreach($formNames as $key =>$name)
            @if($key == '0')
                <div class="col-span-2">
                    <x-filament::section>
                        <x-slot name="heading">
                            {{ trans('Inventory/lang.reports.'.$name) }}
                        </x-slot>
                        {{$this->{$name.'Form'} }}
                        <x-slot name="footerActions">
                            <x-filament::button type="submit" wire:click="{{$name.'Search'}}()" class="mt-5">
                                {{ trans('filament-actions::modal.actions.submit.label') }}
                            </x-filament::button>
                        </x-slot>
                    </x-filament::section>
                </div>
            @else
                <x-filament::section>
                    <x-slot name="heading">
                        {{ trans('Inventory/lang.reports.'.$name) }}
                    </x-slot>
                    {{$this->{$name.'Form'} }}
                    <x-slot name="footerActions">
                        <x-filament::button type="submit" wire:click="{{$name.'Search'}}()" class="mt-5">
                            {{ trans('filament-actions::modal.actions.submit.label') }}
                        </x-filament::button>
                    </x-slot>
                </x-filament::section>
            @endif

        @endforeach

    <div>
</div>
