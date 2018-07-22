<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocatedDatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('allocated_dates', function(Blueprint $table)
		{
            $table->integer('id', true);
			$table->date('date')->nullable();
			$table->string('day', 45)->nullable();
			$table->string('respond', 400)->nullable();
			$table->boolean('cancel_allocation')->nullable();
			$table->boolean('accept_allocation')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('employee_allocation_id')->index('fk_allocated_date_employee_allocation1_idx');
			$table->integer('employee_id')->index('fk_allocated_date_employee1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('allocated_dates');
	}

}
