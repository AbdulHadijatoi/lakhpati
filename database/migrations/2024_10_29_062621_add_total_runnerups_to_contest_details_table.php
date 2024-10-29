<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalRunnerupsToContestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contest_details', function (Blueprint $table) {
            $table->unsignedInteger('total_second_winners')->default(0);
            $table->unsignedInteger('total_third_winners')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contest_details', function (Blueprint $table) {
            $table->dropColumn(['total_second_winners', 'total_third_winners']);
        });
    }
}
