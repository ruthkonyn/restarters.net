<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrotaskSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('microtask_surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('task', 32)->index();
            $table->text('payload');
            $table->string('session_id', 191);
            $table->ipAddress('ip_address');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('microtask_surveys');
    }
}
