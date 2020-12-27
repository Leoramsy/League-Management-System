<?php

use App\Models\Matchday\FixtureType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixtureTypesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fixture_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('slug');
            $table->timestamps();
        });

        // Create static fixture types
        FixtureType::create(["description" => "Group Stages", "slug" => FixtureType::GROUP_STAGES]);
        FixtureType::create(["description" => "Round of 32", "slug" => FixtureType::ROUND_OF_32]);
        FixtureType::create(["description" => "Round of 16", "slug" => FixtureType::ROUND_OF_16]);
        FixtureType::create(["description" => "Quarter Finals", "slug" => FixtureType::QUARTER_FINALS]);
        FixtureType::create(["description" => "Quarter Finals First Leg", "slug" => FixtureType::QUARTER_FINALS_FIRST_LEG]);
        FixtureType::create(["description" => "Quarter Finals Second Leg", "slug" => FixtureType::QUARTER_FINALS_SECOND_LEG]);
        FixtureType::create(["description" => "Semi Finals", "slug" => FixtureType::SEMI_FINALS]);
        FixtureType::create(["description" => "Semi Finals First Leg", "slug" => FixtureType::SEMI_FINALS_FIRST_LEG]);
        FixtureType::create(["description" => "Semi Finals Second Leg", "slug" => FixtureType::SEMI_FINALS_SECOND_LEG]);
        FixtureType::create(["description" => "Final", "slug" => FixtureType::FINALE]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fixture_types');
    }

}
