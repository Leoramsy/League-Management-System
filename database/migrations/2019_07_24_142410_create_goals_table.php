<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fixture_id')->constrained();
            $table->bigInteger('team_id')->constrained();
            $table->bigInteger('player_id')->constrained()->nullable();
            $table->boolean('own_goal')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('goals');
    }

}
