<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_color_id')->constrained('team_colors');
            $table->foreignId('away_color_id')->constrained('team_colors');
            $table->string('name');
            $table->string('nick_name');
            $table->string('home_ground');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone_number');
            $table->string('logo')->nullable();
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('teams');
    }

}
