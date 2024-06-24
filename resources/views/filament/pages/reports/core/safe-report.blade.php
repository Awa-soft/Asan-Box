<x-filament-panels::page>
{{ $this->SafeForm }}
<div class="grid grid-cols-4 gap-5">
    @foreach ($currencies as $currency)
    <livewire:core.currency-overview :symbol="$currency->symbol" :name="$currency->name" :amount="$currency->amount" />
    @endforeach

</div>
</x-filament-panels::page>
