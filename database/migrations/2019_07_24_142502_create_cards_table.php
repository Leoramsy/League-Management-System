<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('card_type_id')->unsigned();
            $table->bigInteger('fixture_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('player_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('cards');
    }

}
