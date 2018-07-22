<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAllocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_allocations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->boolean('request_send_partially')->nullable()->comment('		');
			$table->boolean('request_send_all')->nullable();
			$table->string('sms', 400)->nullable();
			$table->boolean('cancalAll')->nullable();
			$table->boolean('acceptPartially')->nullable();
			$table->boolean('acceptAll')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('task_id')->index('fk_employee_allocation_task1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employee_allocations');
	}

}
