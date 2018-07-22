<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('qualifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->dateTime('issue_date')->nullable();
			$table->dateTime('expire_date')->nullable();
			$table->string('qualification_details', 400)->nullable();
			$table->string('qualification_image', 45)->nullable();
			$table->string('qualificatioin_image_url', 200)->nullable();
			$table->string('qualification_image_type', 45)->nullable();
			$table->string('qualification_image_size', 45)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('employee_id')->index('fk_qualification_employee_idx');
			$table->integer('skill_id')->index('fk_qualification_skill_competency1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('qualifications');
	}

}
