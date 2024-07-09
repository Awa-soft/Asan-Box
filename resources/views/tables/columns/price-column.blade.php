<div class="flex flex-col gap-1 text-sm">
    @if($getState() == "price")
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coin /></div>
        <p>{{ $getRecord()->min_price }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coins /></div>
        <p>{{ $getRecord()->max_price }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
    @else
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coin /></div>
        <p>{{ $getRecord()->installment_min }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coins /></div>
        <p>{{ $getRecord()->installment_max }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
    @endif
</div>
