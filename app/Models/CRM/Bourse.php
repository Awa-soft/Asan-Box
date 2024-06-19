<?php

namespace App\Models\CRM;

use App\Traits\Core\HasUser;
use App\Traits\Core\Ownerable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bourse extends Model
{
    use HasFactory, SoftDeletes,Ownerable,HasUser;

}
