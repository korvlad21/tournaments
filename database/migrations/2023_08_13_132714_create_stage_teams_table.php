<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStageTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stage_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id');
            $table->foreign('stage_id')
                ->references('id')
                ->on('stages');
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
        Schema::dropIfExists('stage_teams');
    }
}
