<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name')->nullable();
            $table->string('slug');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('verified_user')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->binary('avatar')->nullable();
            $table->string('phone', 20)->nullable();
            $table->enum('sex', ['Муж', 'Жен'])->nullable();
            $table->date('birthday')->nullable();
            $table->text('description')->nullable();
            $table->text('сategories')->nullable();
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
        Schema::dropIfExists('users');
    }
}
