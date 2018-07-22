<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSmssTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smss', function(Blueprint $table)
        {
            $table->foreign('allocated_date_id', 'fk_smss_allocated_date1')->references('id')->on('allocated_dates')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('smss', function(Blueprint $table)
        {
            $table->dropForeign('fk_smss_allocated_date1');
        });
    }

}
