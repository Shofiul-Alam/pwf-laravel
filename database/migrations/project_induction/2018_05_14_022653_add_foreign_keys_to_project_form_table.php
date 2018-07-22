<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectFormTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_form', function(Blueprint $table)
		{
			$table->foreign('project_id', 'fk_project_form_project1')->references('id')->on('projects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('form_id', 'fk_project_form_form1')->references('id')->on('forms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('project_form', function(Blueprint $table)
		{
			$table->dropForeign('fk_project_form_project1');
			$table->dropForeign('fk_project_form_form1');
		});
	}

}
