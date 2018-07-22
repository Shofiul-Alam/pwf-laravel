<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timesheets', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('date', 45)->nullable();
			$table->string('day', 45)->nullable();
			$table->time('start_time', 6)->nullable();
			$table->time('end_time', 6)->nullable();
			$table->time('break_time', 6)->nullable();
			$table->boolean('isWeekend')->nullable();
			$table->integer('hours')->nullable();
			$table->integer('overtime')->nullable();
			$table->string('comment', 500)->nullable();
			$table->string('timesheet_image_name', 45)->nullable();
			$table->string('timesheet_image_url', 200)->nullable();
			$table->string('timesheet_image_type', 45)->nullable();
			$table->integer('timesheet_image_size')->nullable();
			$table->boolean('is_approved')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('allocated_date_id')->index('fk_timesheet_allocated_date1_idx');
			$table->integer('order_id')->index('fk_timesheet_order1_idx');
			$table->integer('project_id')->index('fk_timesheet_project1_idx');
			$table->integer('client_id')->index('fk_timesheet_client1_idx');
			$table->integer('employee_id')->index('fk_timesheet_employee1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('timesheets');
	}

}
