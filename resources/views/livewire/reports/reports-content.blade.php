<div>
    <div class="grid items-start grid-cols-1 gap-4 xl:grid-cols-3">
        @foreach($formNames as $name =>$key)
            <x-filament::section>
                <x-slot name="icon">
                    @svg($key::getNavigationIcon(),'h-8 text-primary-500' )
                </x-slot>
                <x-slot name="heading">
                    {{ trans($localizationFolder . '/lang.reports.'.$name) }}
                </x-slot>
                {{$this->{$name.'Form'} }}
                <x-slot name="footerActions">
                    <x-filament::button type="submit" wire:click="{{$name.'Search'}}()" class="mt-5">
                        {{ trans('filament-actions::modal.actions.submit.label') }}
                    </x-filament::button>
                </x-slot>
            </x-filament::section>
        @endforeach
        <div>
 </div>
