<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'account_name' ,
        'account_number' ,
        'account_type' ,
    ];
}
