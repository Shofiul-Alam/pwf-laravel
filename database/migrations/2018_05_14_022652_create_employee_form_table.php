<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeFormTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_form', function(Blueprint $table)
		{
            $table->integer('id', true);
			$table->integer('form_id')->index('fk_induction_permission_form1_idx');
			$table->integer('employee_id')->index('fk_induction_permission_employee1_idx');
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
		Schema::dropIfExists('employee_form');
	}

}
