<?php

use App\Models\Matchday\Fixture;
use App\Models\Matchday\FixtureType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFixtureTypeIdToFixturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->bigInteger('fixture_type_id')->nullable()->default(NULL)->after('away_team_id');
        });
        // Update the current fixtures as group stages
        $group_stages = FixtureType::where('slug', FixtureType::GROUP_STAGES)->first();
        Fixture::where('completed', TRUE)->update(['fixture_type_id' => $group_stages->id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('fixtures', function (Blueprint $table) {
            if (Schema::hasColumn('fixtures', 'fixture_type_id')) {                
                $table->dropColumn('fixture_type_id');
            }
        });
    }

}
