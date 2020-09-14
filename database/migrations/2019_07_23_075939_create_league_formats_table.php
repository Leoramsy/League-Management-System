<?php

use App\Models\System\LeagueFormat;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeagueFormatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('league_formats', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('slug');
            $table->timestamps();
        });

        // create league formats
        LeagueFormat::create(["description" => "Season", "slug" => LeagueFormat::SEASON]);
        LeagueFormat::create(["description" => "Tournament", "slug" => LeagueFormat::TOURNAMENT]);
        LeagueFormat::create(["description" => "Round Robin", "slug" => LeagueFormat::ROUND_ROBIN]);
        LeagueFormat::create(["description" => "Elimination", "slug" => LeagueFormat::ELIMINATION]);
        LeagueFormat::create(["description" => "Knock Out", "slug" => LeagueFormat::KNOCK_OUT]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('league_formats');
    }

}
