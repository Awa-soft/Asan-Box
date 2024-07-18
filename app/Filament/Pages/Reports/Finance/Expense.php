<?php

namespace App\Filament\Pages\Reports\Finance;

use App\Models\Settings\Currency;
use Carbon\Carbon;
use Filament\Pages\Page;
use function PHPUnit\Framework\isEmpty;

class Expense extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'reports/Finance/expense/{from}/{to}/{branch}/{currency}/{warehouse}/{expenseType}';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = '';

    public $data,$currencies;
    public $from,$to;

    public function mount($from,$to,$branch,$currency,$warehouse,$expenseType): void
    {
        $this->from = $from;
        $this->to = $to;
        $currency = json_decode($currency, 0);
        if (!userHasBranch()) {
            $branches = json_decode($branch, 0);
        } else {
            $branches = [getBranchId()];
        }
        if (!userHasWarehouse()) {
            $warehouses = json_decode($warehouse, 0);
        } else {
            $warehouses = [getWarehouseId()];
        }
        $this->data = \App\Models\Finance\Expense::when(!empty($branches) || !empty($warehouses), function ($q) use ($branches, $warehouses) {
            $q->where(function ($query) use ($branches, $warehouses) {
                if (!empty($branches)) {
                    $query->where('ownerable_type', 'App\Models\Logistic\Branch')
                        ->whereIn('ownerable_id', $branches);
                }
                if (!empty($warehouses)) {
                    $query->orWhere(function ($query) use ($warehouses) {
                        $query->where('ownerable_type', 'App\Models\Logistic\Warehouse')
                            ->whereIn('ownerable_id', $warehouses);
                    });
                }
            });
        })
            ->when(!isEmpty($currency),function($query) use($currency){
                return $query->whereIn('currency_id', $currency);
            })
            ->when($from != 'all', function ($query)use($from) {
                return $query->whereDate('date', '>=', Carbon::parse($from));
            })->when($to != 'all', function ($query)use($to) {
                return $query->whereDate('date', '<=', Carbon::parse($to));
            })->when(!isEmpty($expenseType),function ($query)use($expenseType) {
                return $query->whereIn('expense_type_id', $expenseType);
        })->get();
        $this->currencies = Currency::when(!isEmpty($currency), function ($q) use ($currency){
            return $q->whereIn('id', $currency);
        })->get();
    }
    protected static string $view = 'filament.pages.reports.finance.expense';
}
