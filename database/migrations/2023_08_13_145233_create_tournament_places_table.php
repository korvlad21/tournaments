<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_places', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')
                ->references('id')
                ->on('tournaments');
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')
                ->references('id')
                ->on('places');
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
        Schema::dropIfExists('tournament_places');
    }
}
