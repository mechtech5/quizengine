<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('player_1')->nullable();
            $table->unsignedInteger('score_1')->nullable();
            $table->unsignedInteger('player_2')->nullable();
            $table->unsignedInteger('score_2')->nullable();
            $table->unsignedInteger('winner')->nullable();
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
        Schema::dropIfExists('rounds');
    }
}
