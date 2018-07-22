<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectContactTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_contact', function(Blueprint $table)
		{


			$table->integer('project_id')->index('fk_allocated_project_contact_project1_idx');
			$table->integer('contact_id')->index('fk_allocated_project_contact_contact1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('project_contact');
	}

}
