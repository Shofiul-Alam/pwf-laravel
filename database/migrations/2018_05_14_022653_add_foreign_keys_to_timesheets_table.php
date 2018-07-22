<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTimesheetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('timesheets', function(Blueprint $table)
		{
			$table->foreign('allocated_date_id', 'fk_timesheet_allocated_date1')->references('id')->on('allocated_dates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('client_id', 'fk_timesheet_client1')->references('id')->on('clients')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('employee_id', 'fk_timesheet_employee1')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('order_id', 'fk_timesheet_order1')->references('id')->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('project_id', 'fk_timesheet_project1')->references('id')->on('projects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('timesheets', function(Blueprint $table)
		{
			$table->dropForeign('fk_timesheet_allocated_date1');
			$table->dropForeign('fk_timesheet_client1');
			$table->dropForeign('fk_timesheet_employee1');
			$table->dropForeign('fk_timesheet_order1');
			$table->dropForeign('fk_timesheet_project1');
		});
	}

}
