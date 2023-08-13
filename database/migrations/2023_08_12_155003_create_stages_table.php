<?php

use App\Helpers\Stage\StageHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable();
            $table->foreign('tournament_id')
                ->references('id')
                ->on('tournaments');
            $table->integer('number');
            $table->string('name');
            $table->enum('type', [
                StageHelper::TYPE_ROUND_ROBIN,
                StageHelper::TYPE_SWITZERLAND_SYSTEM,
                StageHelper::TYPE_SINGLE_ELIMINATION,
                StageHelper::TYPE_DOUBLE_ELIMINATION
            ]);
            $table->integer('count_group');
            $table->integer('count_teams');
            $table->text('settings')->nullable();
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
        Schema::dropIfExists('stages');
    }
}
