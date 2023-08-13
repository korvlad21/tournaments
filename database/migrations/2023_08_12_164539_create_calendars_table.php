<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
            $table->unsignedBigInteger('place_id')->nullable();
            $table->foreign('place_id')
                ->references('id')
                ->on('places');
            $table->unsignedBigInteger('playoff_id')->nullable();
            $table->foreign('playoff_id')
                ->references('id')
                ->on('playoffs');
            $table->integer('number');
            $table->integer('number_tour');
            $table->dateTime('date_game');
            $table->unsignedBigInteger('team1_id');
            $table->foreign('team1_id')
                ->references('id')
                ->on('teams');
            $table->unsignedBigInteger('team2_id');
            $table->foreign('team2_id')
                ->references('id')
                ->on('teams');
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
        Schema::dropIfExists('calendars');
    }
}
