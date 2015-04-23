<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->tinyInteger('user_role_id');
            $table->string('remember_token',100)->nullable();
            $table->timestamps();
		});

        Schema::create('user_roles', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('role_name');
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
		Schema::drop('users');
	}

}
