<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClientContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('client_contact', function(Blueprint $table)
		{
			$table->foreign('client_id', 'fk_allocated_client_contact_client1')->references('id')->on('clients')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('contact_id', 'fk_allocated_client_contact_contact1')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('client_contact', function(Blueprint $table)
		{
			$table->dropForeign('fk_allocated_client_contact_client1');
			$table->dropForeign('fk_allocated_client_contact_contact1');
		});
	}

}
