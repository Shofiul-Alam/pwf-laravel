<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectSkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_skill', function(Blueprint $table)
		{
			$table->foreign('project_id', 'fk_allocated_skill_competency_project1')->references('id')->on('projects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('skill_id', 'fk_allocated_skill_competency_skill_competency1')->references('id')->on('skills')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('project_skill', function(Blueprint $table)
		{
			$table->dropForeign('fk_allocated_skill_competency_project1');
			$table->dropForeign('fk_allocated_skill_competency_skill_competency1');
		});
	}

}
