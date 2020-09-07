<?php

use Faker\Factory;
use App\Models\Team\Color;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamColorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('team_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color_code');
            $table->timestamps();
        });

        // create 10 sample colors
        for ($i = 0; $i < 10; $i ++) {
            $faker = Factory::create();
            Color::create(['name' => $faker->colorName, 'color_code' => $faker->hexColor]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('team_colors');
    }

}
