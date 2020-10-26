<?php

use App\Models\Team\Position;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('slug');
            $table->timestamps();
        });

        Position::create(['description' => 'Goalkeeper', 'slug' => Position::GOAL_KEEPER]);
        Position::create(['description' => 'Left Back', 'slug' => Position::LEFT_BACK]);
        Position::create(['description' => 'Right Back', 'slug' => Position::RIGHT_BACK]);
        Position::create(['description' => 'Center Back', 'slug' => Position::CENTER_BACK]);
        Position::create(['description' => 'Defensive Midfielder', 'slug' => Position::DEFENSIVE_MIDFIELDER]);
        Position::create(['description' => 'Left Midfielder', 'slug' => Position::LEFT_MIDFIELDER]);
        Position::create(['description' => 'Right Midfielder', 'slug' => Position::RIGHT_MIDFIELDER]);
        Position::create(['description' => 'Attacking Midfielder', 'slug' => Position::ATTACKING_MIDFIELDER]);
        Position::create(['description' => 'Striker', 'slug' => Position::STRIKER]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('positions');
    }

}
