<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')
                ->references('id')
                ->on('tournaments');
            $table->unsignedBigInteger('team_id');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams');
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
        Schema::dropIfExists('tournament_teams');
    }
}
