<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInductionDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_induction_datas', function(Blueprint $table)
		{
            $table->integer('id', true);
			$table->string('value', 45)->nullable();
			$table->integer('field_id')->index('fk_employee_induction_data_field1_idx');
			$table->integer('value_arr_id')->nullable()->index('fk_employee_induction_data_value_arr1_idx');
			$table->integer('form_id')->index('fk_employee_induction_data_form1_idx');
			$table->integer('employee_id')->index('fk_employee_induction_data_employee1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employee_induction_datas');
	}

}
