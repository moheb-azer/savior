<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'subcat_name','cat_id'
    ];
}
