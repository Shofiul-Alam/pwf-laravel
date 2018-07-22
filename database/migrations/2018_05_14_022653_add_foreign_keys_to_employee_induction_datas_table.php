<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeeInductionDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employee_induction_datas', function(Blueprint $table)
		{
			$table->foreign('employee_id', 'fk_employee_induction_data_employee1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('field_id', 'fk_employee_induction_data_field1')->references('id')->on('fields')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('form_id', 'fk_employee_induction_data_form1')->references('id')->on('forms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('value_arr_id', 'fk_employee_induction_data_value_arr1')->references('id')->on('value_arrs')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('employee_induction_datas', function(Blueprint $table)
		{
			$table->dropForeign('fk_employee_induction_data_employee1');
			$table->dropForeign('fk_employee_induction_data_field1');
			$table->dropForeign('fk_employee_induction_data_form1');
			$table->dropForeign('fk_employee_induction_data_value_arr1');
		});
	}

}
