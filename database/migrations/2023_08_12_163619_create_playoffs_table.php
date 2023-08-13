<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playoffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_win_play_off_id')->nullable();
            $table->foreign('team_win_play_off_id')
                ->references('id')
                ->on('playoffs');
            $table->unsignedBigInteger('team_lost_play_off_id')->nullable();
            $table->foreign('team_lost_play_off_id')
                ->references('id')
                ->on('playoffs');
            $table->unsignedTinyInteger('level')->length(3);
            $table->integer('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playoffs');
    }
}
