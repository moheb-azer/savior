<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'c_name','c_phone1', 'c_phone2', 'c_address', 'c_email'
    ];

}
