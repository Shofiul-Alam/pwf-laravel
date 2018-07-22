<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_skill', function(Blueprint $table)
		{


			$table->integer('skill_id')->index('fk_allocated_skill_competency_skill_competency1_idx');
			$table->integer('project_id')->index('fk_allocated_skill_competency_project1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_skill');
	}

}
