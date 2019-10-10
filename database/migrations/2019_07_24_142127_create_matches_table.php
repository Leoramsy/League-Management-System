<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('match_day_id')->unsigned();
            $table->bigInteger('home_team_id')->unsigned();
            $table->bigInteger('away_team_id')->unsigned();
            $table->integer('home_team_score');
            $table->integer('away_team_score');
            $table->boolean('drawn_match')->default(FALSE);
            $table->boolean('completed')->default(FALSE);
            $table->boolean('postponed')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fixtures');
    }

}
