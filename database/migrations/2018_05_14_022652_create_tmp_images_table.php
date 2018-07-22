<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_images', function(Blueprint $table)
		{
            $table->integer('id', true);
			$table->string('name', 45)->nullable();
			$table->string('type', 45)->nullable();
			$table->string('mime', 45)->nullable();
			$table->string('size', 45)->nullable();
			$table->string('url', 200)->nullable();
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
		Schema::dropIfExists('tmp_images');
	}

}
