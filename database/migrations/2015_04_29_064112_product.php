<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('product', function(Blueprint $table)
        {
            $table->increments('id');
            $table->foreign('id')->references('id')->on('product_to_category');
            $table->foreign('id')->references('id')->on('product_image');
            $table->string('name');
            $table->string('model');
            $table->mediumText('description');
            $table->integer('quantity');
            $table->integer('product_image_id');
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
        Schema::drop('product');
	}

}
