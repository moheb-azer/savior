<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        's_name','s_phone1', 's_phone2', 's_address', 's_email'
    ];
}
