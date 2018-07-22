<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToQualificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('qualifications', function(Blueprint $table)
		{
			$table->foreign('employee_id', 'fk_qualification_employee')->references('id')->on('employees')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('skill_id', 'fk_qualification_skill_competency1')->references('id')->on('skills')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('qualifications', function(Blueprint $table)
		{
			$table->dropForeign('fk_qualification_employee');
			$table->dropForeign('fk_qualification_skill_competency1');
		});
	}

}
