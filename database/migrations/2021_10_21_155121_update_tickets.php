<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropPrimary();
            $table->unsignedBigInteger('ticket_id')->change();
            $table->primary(['ticket_id', 'event_id'],'DUMMY_NAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropPrimary();
            $table->bigIncrements('ticket_id')->change();
            $table->primary('ticket_id');
        });
    }
}
