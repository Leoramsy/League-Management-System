<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssistsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('assists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixture_id')->constrained('fixtures');
            $table->foreignId('team_id')->constrained('teams');
            $table->foreignId('player_id')->constrained('players');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('assists');
    }

}
