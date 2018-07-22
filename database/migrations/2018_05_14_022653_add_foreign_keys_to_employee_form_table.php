<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeeFormTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employee_form', function(Blueprint $table)
		{
			$table->foreign('employee_id', 'fk_induction_permission_employee1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('form_id', 'fk_induction_permission_form1')->references('id')->on('forms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('employee_form', function(Blueprint $table)
		{
			$table->dropForeign('fk_induction_permission_employee1');
			$table->dropForeign('fk_induction_permission_form1');
		});
	}

}
