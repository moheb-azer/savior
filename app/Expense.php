<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{   
    use SoftDeletes;
    protected $fillable = [
        'item_id','description','amount'
    ];
	
	public function expenseItem() {
		return $this->hasMany('App\ExpenseItem');
	}
}
