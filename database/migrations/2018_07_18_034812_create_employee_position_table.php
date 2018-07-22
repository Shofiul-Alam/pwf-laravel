<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeePositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_position', function(Blueprint $table)
		{
			$table->integer('employees_id')->index('fk_employee_position_employees_idx');
			$table->integer('positions_id')->index('fk_employee_position_positions1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employee_position');
	}

}
