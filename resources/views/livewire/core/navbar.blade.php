<div class="flex items-center gap-4">
    <x-filament::icon-button icon="iconpark-buy" href="{{ route('filament.admin.pages.purchase-page') }}" tag="a"
        size="xl" label="Filament" color="warning" tooltip="{{ trans('POS/lang.purchase_pos.singular_label') }}" />
    <x-filament::icon-button icon="mdi-point-of-sale" href="{{ route('filament.admin.pages.sale-page') }}" tag="a"
        size="xl" label="Filament" color="primary" tooltip="{{ trans('POS/lang.sale_pos.singular_label') }}"  />

</div>
