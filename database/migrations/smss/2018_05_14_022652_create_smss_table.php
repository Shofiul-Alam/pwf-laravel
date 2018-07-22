<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmssTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smss', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('message', 400)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('allocated_date_id')->index('fk_sms_allocated_date_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('smss');
	}

}
