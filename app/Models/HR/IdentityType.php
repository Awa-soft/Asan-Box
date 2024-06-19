<?php

namespace App\Models\HR;

use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable;


}
