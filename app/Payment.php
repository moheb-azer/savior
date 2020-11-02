<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
	use SoftDeletes;
    protected $fillable = ['supplier_id', 'cash', 'balance'];
	
	public function supplier() 
	{
		return $this->belongsTo('App\Supplier');
	}
}
