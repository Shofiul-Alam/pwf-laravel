<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('first_name', 45)->nullable();
			$table->string('last_name', 45)->nullable();
			$table->string('mobile', 45)->nullable();
			$table->dateTime('dob')->nullable();
			$table->string('address', 200)->nullable();
			$table->string('nationality', 45)->nullable();
			$table->string('emergency_contact_name', 200)->nullable();
			$table->string('emergency_contact_phone', 45)->nullable();
			$table->string('bank_account_no', 45)->nullable();
			$table->string('bank_name', 45)->nullable();
			$table->string('bank_bsb', 45)->nullable();
			$table->string('tfn_no', 45)->nullable();
			$table->string('abn_no', 45)->nullable();
			$table->string('super_no', 45)->nullable();
			$table->string('super_provider', 45)->nullable();
			$table->string('is_commited_crime', 45)->nullable();
			$table->string('crime_details', 400)->nullable();
			$table->string('isAboriginal', 45)->nullable();
			$table->string('isIslander', 45)->nullable();
			$table->string('avater_name', 45)->nullable();
			$table->string('avater_url', 200)->nullable();
			$table->string('avater_file_type', 45)->nullable();
			$table->string('avater_file_size', 45)->nullable();
            $table->string('lat', 45)->nullable();
            $table->string('long', 45)->nullable();
			$table->dateTime('avater_updated_at')->nullable();
			$table->boolean('isApproved');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('user_id')->index('fk_employee_user1_idx')->unique();
			$table->integer('position_id')->index('fk_employee_position1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employees');
	}

}
