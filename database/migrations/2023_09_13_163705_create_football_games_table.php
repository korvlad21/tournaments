<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootballGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('football_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
                ->references('id')
                ->on('games');
            $table->unsignedBigInteger('team1_id');
            $table->foreign('team1_id')
                ->references('id')
                ->on('teams');
            $table->unsignedBigInteger('team2_id');
            $table->foreign('team2_id')
                ->references('id')
                ->on('teams');
            $table->integer('score1')->nullable();
            $table->integer('score2')->nullable();
            $table->string('status', 30)->default('WAIT');
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
        Schema::dropIfExists('football_games');
    }
}
