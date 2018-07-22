<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeInductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_inductions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('induction_details', 400)->nullable();
			$table->string('induction_file_name', 45)->nullable();
			$table->string('induction_file_type', 45)->nullable();
			$table->string('induction_file_url', 200)->nullable();
			$table->string('indcution_file_size', 45)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('employee_id')->index('fk_employee_induction_employee1_idx');
			$table->integer('form_id')->index('fk_employee_induction_form1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employee_inductions');
	}

}
