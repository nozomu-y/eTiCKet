<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CollectType;

class UpdateEventsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('collect_name')->default(CollectType::DISABLED);
            $table->integer('collect_email')->default(CollectType::DISABLED);
            $table->integer('collect_phone_number')->default(CollectType::DISABLED);
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
            $table->dropColumn('collect_name');
            $table->dropColumn('collect_email');
            $table->dropColumn('collect_phone_number');
        });
    }
}
