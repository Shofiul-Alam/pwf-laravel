<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_contact', function(Blueprint $table)
		{

			$table->integer('client_id')->index('fk_allocated_client_contact_client1_idx');
			$table->integer('contact_id')->index('fk_allocated_client_contact_contact1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('client_contact');
	}

}
