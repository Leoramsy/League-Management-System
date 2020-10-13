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
            $table->id();
            $table->foreignId('match_day_id')->constrained('match_days');
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->dateTime('kick_off')->nullable();
            $table->integer('home_team_score')->nullable()->default(null);
            $table->integer('away_team_score')->nullable()->default(null);
            $table->boolean('drawn_match')->default(FALSE);
            $table->boolean('completed')->default(FALSE);
            $table->boolean('postponed')->default(FALSE);
            $table->timestamps();

            $table->unique(['match_day_id', 'home_team_id', 'away_team_id']);
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
