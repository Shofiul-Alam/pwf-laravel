<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeeAllocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employee_allocations', function(Blueprint $table)
		{
			$table->foreign('task_id', 'fk_employee_allocation_task1')->references('id')->on('tasks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('employee_allocations', function(Blueprint $table)
		{
			$table->dropForeign('fk_employee_allocation_task1');
		});
	}

}
