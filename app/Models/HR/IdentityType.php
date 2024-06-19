<?php

namespace App\Models\HR;

use App\Traits\HasUser;
use App\Traits\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    use HasFactory;
    use HasUser;
    use Ownerable;
    

}
