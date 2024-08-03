<?php

namespace App\Models\Core;

use App\Models\CRM\Bourse;
use App\Models\CRM\Contact;
use App\Models\CRM\Partner;
use App\Models\Finance\BoursePayment;
use App\Models\Finance\CashManagement;
use App\Models\Finance\Expense;
use App\Models\Finance\Payment;
use App\Models\HR\Employee;
use App\Models\HR\EmployeeActivity;
use App\Models\HR\EmployeeSalary;
use App\Models\Logistic\Branch;
use App\Models\POS\PurchaseExpense;
use App\Models\POS\PurchaseInvoice;
use App\Models\POS\SaleInvoice;
use App\Models\Settings\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\App;
use Sushi\Sushi;

class MoneyBox extends Model
{
    use HasFactory;
    use Sushi;

    protected $appends = ['user','currency'];
    protected $connection = 'mysql'; // replace with your actual connection name

    protected $schema = [
        'amount' => 'decimal',
    ];

    public function getRows()
    {
        $rows = [];
        $boursePayments = BoursePayment::where('type','payment')->get()->map(function ($record){
            return [
                'id'=>$record->invoice_number,
                'name'=>$record->bourse->name,
                'makeble_type'=>Bourse::class,
                'makeble_id'=>$record->bourse_id,
                'date'=>$record->date,
                'type'=>'send',
                'user_id'=>$record->user_id,
                'amount'=>$record->amount,
                'currency_id'=>$record->currency_id,
                'ownerable_type'=>Branch::class,
                'ownerable_id'=>$record->branch_id,
                'title'=>trans('Finance/lang.bourse_payment.singular_label'),
                'branch'=>$record->branch->name
            ];
        })->toArray();
        $cashManagement = CashManagement::all()->map(function ($record){
           return [
               'id'=>$record->id,
               'makeble_type'=>Partner::class,
               'makeble_id'=>$record->partnerAccountAll->partner_id,
               'name'=>$record->partnerAccountAll->partner->name,
               'date'=>$record->created_at,
               'type'=>$record->type == 'deposit' ? 'receive':'send',
               'user_id'=>$record->user_id,
               'amount'=>$record->amount,
               'currency_id'=>$record->currency_id,
               'ownerable_type'=>Branch::class,
               'ownerable_id'=>$record->partnerAccountAll->partnershipAll->branch_id,
               'title'=>trans('Finance/lang.cash_management.plural_label'),
               'branch'=>$record->partnerAccountAll->partnershipAll->branch->name
           ];
        })->toArray();
        $expenses = Expense::all()->map(function ($record){
           return [
               'id'=>$record->id,
               'makeble_type'=>null,
               'makeble_id'=>null,
               'name'=>null,
               'date'=>$record->date,
               'type'=>'send',
               'user_id'=>$record->user_id,
               'amount'=>$record->amount,
               'currency_id'=>$record->currency_id,
               'ownerable_type'=>Branch::class,
               'ownerable_id'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable_id : $record->ownerable->financial_branch_id,
               'title'=>trans('Finance/lang.expense.singular_label'),
               'branch'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable->name : $record->ownerable->financialBranch->name,

           ];
        })->toArray();
        $payment = Payment::all()->map(function($record){
            return [
                'id'=>$record->invoice_number,
                'name'=>$record->contact->{'name_'.App::getLocale()},
                'makeble_type'=>Contact::class,
                'makeble_id'=>$record->contact_id,
                'date'=>$record->date,
                'type'=>$record->type,
                'user_id'=>$record->user_id,
                'amount'=>$record->amount,
                'currency_id'=>$record->currency_id,
                'ownerable_type'=>Branch::class,
                'ownerable_id'=>$record->branch_id,
                'title'=>trans('Finance/lang.payment.singular_label'),
                'branch'=>$record->branch->name

            ];
        })->toArray();
        $salaryAdvance = EmployeeActivity::where('type','advance')
            ->get()
            ->map(function ($record){
                return [
                    'id'=>$record->id,
                    'name'=>$record->employee->name,
                    'makeble_type'=>Employee::class,
                    'makeble_id'=>$record->employee_id,
                    'date'=>$record->date,
                    'type'=>'send',
                    'user_id'=>$record->user_id,
                    'amount'=>$record->amount,
                    'currency_id'=>$record->currency_id,
                    'ownerable_type'=>Branch::class,
                    'ownerable_id'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable_id : $record->ownerable->financial_branch_id,
                    'title'=>trans('lang.employees') . ' - ' . trans('lang.advance'),
                    'branch'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable->name : $record->ownerable->financialBranch->name,
                ];
            })->toArray();

        $salary = EmployeeSalary::all()
            ->map(function ($record){
                return [
                    'id'=>$record->id,
                    'name'=>$record->employee->name,
                    'makeble_type'=>Employee::class,
                    'makeble_id'=>$record->employee_id,
                    'date'=>$record->payment_date,
                    'type'=>'send',
                    'user_id'=>$record->user_id,
                    'amount'=>$record->payment_amount,
                    'currency_id'=>$record->currency_id,
                    'ownerable_type'=>Branch::class,
                    'ownerable_id'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable_id : $record->ownerable->financial_branch_id,
                    'title'=>trans('lang.employees') . ' - ' . trans('lang.salary'),
                    'branch'=>$record->ownerable_type == 'App\Models\Logistic\Branch'? $record->ownerable->name : $record->ownerable->financialBranch->name,
                ];
            })->toArray();

        $sale = SaleInvoice::all()
            ->map(function ($record){
                return [
                    'id'=>$record->invoice_number,
                    'name'=>$record->contact->{'name_'.App::getLocale()},
                    'makeble_type'=>Contact::class,
                    'makeble_id'=>$record->contact_id,
                    'date'=>$record->date,
                    'type'=>$record->type != 'return'? 'receive' : 'send',
                    'user_id'=>$record->user_id,
                    'amount'=>$record->paid_amount,
                    'currency_id'=>$record->currency_id,
                    'ownerable_type'=>Branch::class,
                    'ownerable_id'=>$record->branch_id,
                    'title'=>$record->type != 'return'?trans('POS/lang.sale_invoice.singular_label') : trans("POS/lang.sale_return.singular_label"),
                    'branch'=>$record->branch->name

                ];
            })->toArray();

        $purchase = PurchaseInvoice::all()
            ->map(function ($record){
                return [
                    'id'=>$record->invoice_number,
                    'makeble_type'=>Contact::class,
                    'name'=>$record->contact->{'name_'.App::getLocale()},
                    'makeble_id'=>$record->contact_id,
                    'date'=>$record->date,
                    'type'=>$record->type == 'return'? 'receive' : 'send',
                    'user_id'=>$record->user_id,
                    'amount'=>$record->paid_amount,
                    'currency_id'=>$record->currency_id,
                    'ownerable_type'=>Branch::class,
                    'ownerable_id'=>$record->branch_id,
                    'title'=>$record->type != 'return'?trans('POS/lang.purchase.singular_label') : trans("POS/lang.purchase_return.singular_label"),
                    'branch'=>$record->branch->name

                ];
            })->toArray();

        $purchaseExpense = PurchaseExpense::all()
            ->map(function ($record){
                return [
                    'id'=>$record->invoice?->invoice_number,
                   'makeble_type'=>Contact::class,
                   'makeble_id'=>$record->invoice?->contact_id,
                    'name'=>$record->invoice?->contact?->{'name_'.App::getLocale()},
                    'date'=>$record->created_at,
                    'type'=>'send',
                    'user_id'=>$record->user_id,
                    'amount'=>$record->amount,
                    'currency_id'=>$record->currency_id,
                    'ownerable_type'=>Branch::class,
                    'ownerable_id'=>$record->invoice?->branch_id,
                    'title'=>trans('POS/lang.purchase_expense.singular_label'),
                    'branch'=>$record->invoice?->branch?->name

                ];
            })->toArray();
       return array_merge($rows, $boursePayments,$cashManagement,$expenses,$payment,$salaryAdvance,$salary,$sale,$purchase);

    }

   public function getUserAttribute():User
   {
       return User::where('id',$this->user_id)->first();
   }

   public function getCurrencyAttribute():Currency
   {
       return Currency::where('id',$this->currency_id)->withTrashed()->first();
   }

    public function ownerable():MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function makeble():MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

}
