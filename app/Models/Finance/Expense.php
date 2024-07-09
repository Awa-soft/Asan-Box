<?php

namespace App\Models\Finance;

use App\Traits\Core\HasCurrency;
use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes,HasCurrency,HasUser,Ownerable;

    public function expenseType():BelongsTo
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
