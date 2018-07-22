<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
            $table->integer('id', true);
			$table->string('company_name', 200)->nullable();
			$table->string('company_abn_no', 45)->nullable();
			$table->string('office_phone', 45)->nullable();
			$table->string('mobile', 45)->nullable();
			$table->string('contact_details', 200)->nullable();
			$table->string('acn_no', 45)->nullable();
			$table->string('tfn_no', 45)->nullable();
			$table->string('credit_limit', 45)->nullable();
			$table->string('client_avater_name', 45)->nullable();
			$table->string('client_avater_url', 200)->nullable();
			$table->string('client_avater_type', 45)->nullable();
			$table->string('client_avater_size', 45)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('user_id')->index('fk_client_user1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('clients');
	}

}
