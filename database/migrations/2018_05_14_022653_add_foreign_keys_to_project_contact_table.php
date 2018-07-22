<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProjectContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('project_contact', function(Blueprint $table)
		{
			$table->foreign('contact_id', 'fk_allocated_project_contact_contact1')->references('id')->on('contacts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('project_id', 'fk_allocated_project_contact_project1')->references('id')->on('projects')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('project_contact', function(Blueprint $table)
		{
			$table->dropForeign('fk_allocated_project_contact_contact1');
			$table->dropForeign('fk_allocated_project_contact_project1');
		});
	}

}
