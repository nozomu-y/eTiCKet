<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePersonalInformationsPrimaryKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal_informations', function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table('personal_informations', function (Blueprint $table) {
            $table->id()->first();
            $table->unique(['event_id', 'ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_informations', function (Blueprint $table) {
            $table->dropUnique(['event_id','ticket_id']);
            $table->dropColumn('id');
            $table->primary(['event_id', 'ticket_id']);
        });
    }
}
