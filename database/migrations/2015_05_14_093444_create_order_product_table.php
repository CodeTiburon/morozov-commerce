<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_product', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('order_id');
            $table->integer('order_product_id');
            $table->integer('quantity');
            $table->decimal('total_price', 5, 2);
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
		Schema::drop('order_product');
	}

}
