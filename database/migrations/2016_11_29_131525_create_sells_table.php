<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sells', function(Blueprint $table) {
            $table->increments('id');
            $table->string('client');
            $table->string('payment_method');
            $table->timestamps();
        });

        Schema::create('product_sell', function(Blueprint $table) {
            $table->integer('product_id');
            $table->integer('sell_id');
            $table->integer('amount');
            $table->float('value');
            
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sell_id')->references('id')->on('sells');
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
		Schema::drop('sells');
	}

}
