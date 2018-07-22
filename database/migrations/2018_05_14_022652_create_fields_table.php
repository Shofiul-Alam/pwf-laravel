<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('label', 400)->nullable();
			$table->string('type', 200)->nullable();
			$table->string('class_name', 500)->nullable();
			$table->string('default_value', 100)->nullable();
			$table->string('required', 45)->nullable();
			$table->string('description', 400)->nullable();
			$table->string('placeholder', 100)->nullable();
			$table->string('name', 200)->nullable();
			$table->string('access', 45)->nullable();
			$table->string('inline', 45)->nullable();
			$table->string('value', 500)->nullable();
			$table->string('min', 45)->nullable();
			$table->string('max', 45)->nullable();
			$table->integer('form_id')->index('fk_field_form1_idx');
            $table->timestamps();
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('fields');
	}

}
