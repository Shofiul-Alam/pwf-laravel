<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToValueArrsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('value_arrs', function(Blueprint $table)
		{
			$table->foreign('field_id', 'fk_value_arr_field1')->references('id')->on('fields')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('value_arrs', function(Blueprint $table)
		{
			$table->dropForeign('fk_value_arr_field1');
		});
	}

}
