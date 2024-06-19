<?php

namespace App\Models\CRM;

use App\Models\Logistic\Branch;
use App\Models\Scopes\OwnerableScope;
use App\Models\User;
use App\Traits\HasUser;
use App\Traits\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bourse extends Model
{
    use HasFactory, SoftDeletes,Ownerable,HasUser;

}
