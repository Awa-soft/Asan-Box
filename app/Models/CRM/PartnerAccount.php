<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Traits\Core\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerAccount extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;

    public function partner():BelongsTo{
        return $this->belongsTo(Partner::class);
    }

    public function partnership():BelongsTo{
        return $this->belongsTo(Partnership::class);
    }


}
