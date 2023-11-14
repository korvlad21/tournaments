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
            $table->unsignedBigInteger('team1_win_play_off_id')->nullable();
            $table->unsignedBigInteger('team2_win_play_off_id')->nullable();
            $table->boolean('team1_exist');
            $table->boolean('team2_exist');
            $table->unsignedTinyInteger('level')->length(3);
            $table->integer('number');
            $table->unsignedBigInteger('game_id')->nullable();
            $table->foreign('game_id')
                ->references('id')
                ->on('games');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
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
