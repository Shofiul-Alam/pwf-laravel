<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEmployeePositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employee_position', function(Blueprint $table)
		{
			$table->foreign('employees_id', 'fk_employee_position_employees')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('positions_id', 'fk_employee_position_positions1')->references('id')->on('positions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('employee_position', function(Blueprint $table)
		{
			$table->dropForeign('fk_employee_position_employees');
			$table->dropForeign('fk_employee_position_positions1');
		});
	}

}
