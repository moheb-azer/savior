<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_products', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_id');
            $table->integer('p_id');
            $table->integer('units');
            $table->decimal('unit_cost',8,2);
            $table->decimal('total_cost',8,2);
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
        Schema::dropIfExists('purchased_products');
    }
}
