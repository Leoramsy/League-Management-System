<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\Models\System\League;
use App\Models\System\News;
use App\Models\Matchday\Fixture;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {
        $files = File::files(public_path('images/home'));
        $images = [];
        foreach ($files as $file) {
            $images[] = '/images/home/' . $file->getRelativePathname();
        }
        $news = News::select("news.*", DB::raw("IFNULL(users.name, 'Admin') AS author"), DB::raw("DATE_FORMAT(news.published_date, '%d %M %Y') AS date"))
                ->leftJoin('users', 'news.created_by', '=', 'users.id')
                ->where('news.featured', TRUE)
                ->where('news.active', TRUE)                
                ->orderBy('news.published_date', 'DESC')
                ->get();
        $leagues = selectTwoOptions(League::where('active', TRUE)->get());
        return view('client.home', compact('leagues', 'images', 'news'));
    }

    public function data(Request $request) {
        try {
            $data = [];
            switch ($request->type) {
                case 'fixtures':
                    $fixtures_query = Fixture::select('fixtures.*', 'match_days.description AS match_day', 'home_team.name AS home_team', 'away_team.name AS away_team')
                            ->join('match_days', 'fixtures.match_day_id', '=', 'match_days.id')
                            ->join('teams AS home_team', 'fixtures.home_team_id', '=', 'home_team.id')
                            ->join('teams AS away_team', 'fixtures.away_team_id', '=', 'away_team.id')
                            ->where('match_days.league_id', $request->league_id)
                            ->where('fixtures.completed', FALSE)
                            ->where('match_days.completed', FALSE)
                            ->where('fixtures.postponed', FALSE)
                            ->orderBy('fixtures.kick_off', 'ASC');

                    if (isset($request->team_id) && $request->team_id > 0) {
                        $fixtures_query->where('home_team.id', $request->team_id)->orWhere('away_team.id', $request->team_id);
                    }

                    $fixtures = $fixtures_query->get();

                    foreach ($fixtures as $fixture) {
                        $data[] = $this->processFixtures($fixture);
                    }

                    break;

                case 'results':
                    $results = Fixture::select('fixtures.*', 'home_team.home_ground AS venue', 'match_days.description AS match_day', 'home_team.name AS home_team', 'away_team.name AS away_team')
                            ->join('match_days', 'fixtures.match_day_id', '=', 'match_days.id')
                            ->join('teams AS home_team', 'fixtures.home_team_id', '=', 'home_team.id')
                            ->join('teams AS away_team', 'fixtures.away_team_id', '=', 'away_team.id')
                            ->where('match_days.league_id', $request->league_id)
                            ->whereNotNull('fixtures.home_team_score')
                            ->whereNotNull('fixtures.away_team_score')
                            ->where('fixtures.completed', TRUE)
                            ->where('match_days.completed', FALSE)
                            ->where('fixtures.postponed', FALSE)
                            ->orderBy('match_days.id', 'ASC')
                            ->get();

                    foreach ($results as $result) {
                        $data[] = $this->processResults($result);
                    }
                    break;
                case 'logs':
                    $logs = DB::select("SELECT team_id AS team_id,
                                                    t.name team_name,
                                                    count(*) AS played,
                                                    SUM(scored)AS scored_total,
                                                    SUM(conceided) AS conceided_total,
                                                    count(CASE WHEN scored > conceided
                                                      THEN 1 END) AS  wins,
                                                    count(CASE WHEN scored = conceided
                                                      THEN 1 END) AS draw,
                                                    count(CASE WHEN scored < conceided
                                                      THEN 1 END) AS lost,
                                                    sum(scored) - sum(conceided) AS balance,
                                                    sum(
                                                        CASE WHEN scored > conceided
                                                          THEN 3
                                                        ELSE 0 END
                                                        + CASE WHEN scored = conceided
                                                          THEN 1
                                                          ELSE 0 END) AS points,
                                                    count(CASE WHEN place = 'home'
                                                      THEN 1 END) AS home_matches,
                                                    count(CASE WHEN place = 'home' AND scored > conceided
                                                      THEN 1 END) AS home_wins,
                                                    count(CASE WHEN place = 'home' AND scored = conceided
                                                      THEN 1 END) AS home_draws,
                                                    count(CASE WHEN place = 'home' AND scored < conceided
                                                      THEN 1 END) AS home_lost,
                                                    SUM(CASE WHEN place = 'home'
                                                      THEN scored
                                                        ELSE 0 END) AS home_scored,
                                                    SUM(CASE WHEN place = 'home'
                                                      THEN conceided
                                                        ELSE 0 END) AS home_conceided,
                                                    count(CASE WHEN place = 'away'
                                                      THEN 1 END) AS away_matches,
                                                    count(CASE WHEN place = 'away' AND scored > conceided
                                                      THEN 1 END) AS away_wins,
                                                    count(CASE WHEN place = 'away' AND scored = conceided
                                                      THEN 1 END) AS away_draws,
                                                    count(CASE WHEN place = 'away' AND scored < conceided
                                                      THEN 1 END) AS away_lost,
                                                    SUM(CASE WHEN place = 'away'
                                                      THEN scored
                                                        ELSE 0 END) AS away_scored,
                                                    SUM(CASE WHEN place = 'away'
                                                      THEN conceided
                                                        ELSE 0 END) AS away_conceided,
                                                    GROUP_CONCAT((CASE
                                                         WHEN scored > conceided
                                                           THEN 'W'
                                                         WHEN scored = conceided
                                                           THEN 'D'
                                                         WHEN scored < conceided
                                                           THEN 'L'
                                                         END) ORDER BY kick_off DESC separator '') streak
                                                  FROM
                                                    (
                                                      (SELECT                                                         
                                                         hm.home_team_id team_id,
                                                         hm.home_team_score   scored,
                                                         hm.away_team_score   conceided,
                                                         'home'          place,
                                                         kick_off 
                                                       FROM fixtures hm
                                                       JOIN match_days ON hm.match_day_id = match_days.id                                                       
                                                       WHERE match_days.league_id = '" . $request->league_id . "')
                                                      UNION ALL
                                                      (SELECT                                                         
                                                         am.away_team_id team_id,
                                                         am.away_team_score   scored,
                                                         am.home_team_score   conceided,
                                                         'away' place,
                                                         kick_off 
                                                       FROM fixtures am
                                                       JOIN match_days ON am.match_day_id = match_days.id                                                       
                                                       WHERE match_days.league_id = '" . $request->league_id . "')
                                                    ) m
                                                    JOIN teams t ON t.id = team_id
                                                  GROUP BY team_id, t.name
                                                  ORDER BY points DESC, balance DESC");

                    foreach ($logs as $index => $log) {
                        $data[] = $this->processLogs($log, $index + 1);
                    }
                    break;
                default:
                    throw new Exception("Invalid Data Type Encountered");
            }

            return response()->json(["data" => $data]);
        } catch (Exception $ex) {
            return response()->json(["error" => $ex->getMessage()]);
        }
    }

    private function processlogs($data, $position) {
        return [
            "DT_RowId" => "row_" . $data->team_id,
            "fixtures" => [
                "position" => $position,
                "played" => $data->wins + $data->draw + $data->lost,
                "won" => $data->wins,
                "draw" => $data->draw,
                "lost" => $data->lost,
                "points" => $data->points,
                "goals_for" => (is_null($data->scored_total) ? 0 : $data->scored_total),
                "goals_against" => (is_null($data->conceided_total) ? 0 : $data->conceided_total),
                "difference" => (is_null($data->balance) ? 0 : $data->balance),
                "form" => str_pad($data->streak, 3, '-', STR_PAD_LEFT),
            ],
            "teams" => [
                "name" => $data->team_name,
            ]
        ];
    }

    private function processResults($data) {
        return [
            "DT_RowId" => "row_" . $data->id,
            "fixtures" => [
                "id" => $data->id,
                "home_team_score" => $data->home_team_score,
                "away_team_score" => $data->away_team_score,
                "date" => (is_null($data->kick_off) ? 'TBA' : $data->kick_off->format('d/m/Y')),
            ],
            "home_team" => [
                "name" => $data->home_team,
            ],
            "away_team" => [
                "name" => $data->away_team,
            ],
            "match_days" => [
                "description" => $data->match_day,
            ]
        ];
    }

    private function processFixtures($data) {
        return [
            "DT_RowId" => "row_" . $data->id,
            "fixtures" => [
                "id" => $data->id,
                "date" => (is_null($data->kick_off) ? 'TBA' : $data->kick_off->format('d/m/Y')),
                "kick_off" => (is_null($data->kick_off) ? 'TBA' : $data->kick_off->format('d/m/Y H:i')),
                "venue" => (is_null($data->venue) ? 'KPK Unit G' : $data->venue)
            ],
            "home_team" => [
                "name" => $data->home_team,
            ],
            "away_team" => [
                "name" => $data->away_team,
            ],
            "match_days" => [
                "description" => $data->match_day,
            ]
        ];
    }

}
