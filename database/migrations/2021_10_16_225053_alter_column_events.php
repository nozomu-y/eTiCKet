<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->time('open_at')->nullable()->change();
            $table->time('start_at')->nullable()->change();
            $table->time('end_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->datetime('open_at')->nullable()->change();
            $table->datetime('start_at')->nullable()->change();
            $table->datetime('end_at')->nullable()->change();
        });
    }
}
