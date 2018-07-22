<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValueArrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('value_arrs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('label', 45)->nullable();
			$table->string('value', 45)->nullable();
			$table->string('selected', 45)->nullable();
			$table->string('correct', 45)->nullable();
			$table->integer('field_id')->index('fk_value_arr_field1_idx');
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
		Schema::dropIfExists('value_arrs');
	}

}
