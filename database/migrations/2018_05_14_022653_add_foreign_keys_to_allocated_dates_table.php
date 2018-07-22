<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAllocatedDatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('allocated_dates', function(Blueprint $table)
		{
			$table->foreign('employee_allocation_id', 'fk_allocated_date_employee_allocation1')->references('id')->on('employee_allocations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('employee_id', 'fk_allocated_date_employee1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('allocated_dates', function(Blueprint $table)
		{
			$table->dropForeign('fk_allocated_date_employee_allocation1');
			$table->dropForeign('fk_allocated_date_employee1');
		});
	}

}
