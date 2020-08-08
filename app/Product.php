<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'p_code','p_name','cat_id','subcat_id', 'brand_id', 'description'
    ];
}
