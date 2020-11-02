<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
	use SoftDeletes;
    protected $fillable = ['customer_id', 'cash', 'balance'];
	
	public function customer() 
	{
		return $this->belongsTo('App\Customer');
	}
}
