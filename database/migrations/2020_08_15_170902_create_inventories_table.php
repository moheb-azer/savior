<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_type', 30);
            $table->integer('p_id');
            $table->date('date');
            $table->integer('units');
            $table->float('unit_cost',8,2);
            $table->float('total_cost',8,2);
            $table->integer('balance_units');
            $table->float('average_cost',8,2);
            $table->float('balance_cost',8,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
