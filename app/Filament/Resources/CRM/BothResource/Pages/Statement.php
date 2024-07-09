<?php

namespace App\Filament\Resources\CRM\BothResource\Pages;

use App\Filament\Resources\CRM\BothResource;
use App\Models\CRM\Contact;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class Statement extends Page
{
    protected static string $resource = BothResource::class;
    public $record,$from,$to;

    protected static string $view = 'filament.resources.c-r-m.customer-resource.pages.statement';
    public function getTitle(): string|Htmlable
    {
        return "";
    }
    public function mount($from, $to, $record){
        $this->from = $from;
        $this->to = $to;
        $this->record = $record;
    }
    public function render(): View
    {

        $contact = Contact::where('id',$this->record)
        ->with('purchases',function ($q){
            return $q->when($this->from != 'all', function($query) {
                return $query->whereDate('date', '>=', $this->from);
            })->when($this->to != 'all', function($query){
                return $query->whereDate('date', '<=', $this->to);
            });
        })->with('sales',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('date', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('date', '<=', $this->to);
                });
            })->with('sends',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('date', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('date', '<=', $this->to);
                });
            })->with('receives',function ($q){
                return $q->when($this->from != 'all', function($query) {
                    return $query->whereDate('date', '>=', $this->from);
                })->when($this->to != 'all', function($query){
                    return $query->whereDate('date', '<=', $this->to);
                });
            })->first();

            $data = array_merge(
                $contact->purchases->map(function($record){
                    return [
                        'invoice_number' => $record->invoice_number,
                        'type' => $record->type,
                        'amount' => $record->amount,
                        'date' => $record->date,
                        'note' => $record->note,
                        'paid_amount' => $record->paid_amount,
                        'balance' => $record->balance,
                        "currency" => $record->currency->toArray(),
                        "user" => $record->user->toArray(),

                    ];
                })->toArray(),
                $contact->sales->map(function($record){
                    return [
                        'invoice_number' => $record->invoice_number,
                        'type' => $record->type,
                        'date' => $record->date,
                        'amount' => $record->amount,
                        'paid_amount' => $record->amount,
                        'balance' => $record->balance,
                        'note' => $record->note,
                        "currency" => $record->currency->toArray(),
                        "user" => $record->user->toArray(),
                    ];
                })->toArray(),
                $contact->sends->map(function($record){
                    return [
                        'invoice_number' => $record->invoice_number,
                        'type' => $record->type,
                        'date' => $record->date,
                        'amount' => $record->amount,
                        'paid_amount' => $record->amount,
                        'balance' => $record->balance,
                        'note' => $record->note,
                        "currency" => $record->currency->toArray(),
                        "user" => $record->user->toArray(),
                    ];
                })->toArray(),
                $contact->receives->map(function($record){
                    return [
                        'invoice_number' => $record->invoice_number,
                        'type' => $record->type,
                        'date' => $record->date,
                        'amount' => $record->amount,
                        'paid_amount' => $record->amount,
                        'balance' => $record->balance,
                        'note' => $record->note,
                        "currency" => $record->currency->toArray(),
                        "user" => $record->user->toArray(),
                    ];
                })->toArray()
            );

            usort($data, function($a, $b) {
                return strcmp($a['date'], $b['date']);
            });

        if($data == null){
            abort(404);
        }

        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ])->with(['contact'=> $contact, 'data'=>$data]);
    }
}
