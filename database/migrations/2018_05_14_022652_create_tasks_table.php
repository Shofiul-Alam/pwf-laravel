<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 45)->nullable();
			$table->decimal('charge_rate', 11, 0)->nullable();
			$table->decimal('pay_rate', 11, 0)->nullable();
			$table->integer('number_of_employee')->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->time('start_time', 6)->nullable();
			$table->time('end_time', 6)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('order_id')->index('fk_task_order1_idx');
			$table->integer('position_id')->index('fk_task_position1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tasks');
	}

}
