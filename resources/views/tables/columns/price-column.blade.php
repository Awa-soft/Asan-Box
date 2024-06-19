<div class="flex flex-col gap-1 text-sm">
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coin /></div>
        <p>{{ $getState()->single_price }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
    <div class="flex items-center gap-1">
        <div class="text-3xl"><x-tabler-coins /></div>
        <p>{{ $getState()->multiple_price }}{{ \App\Models\Settings\Currency::where("base", true)->first()->symbol }}</p>
    </div>
</div>
