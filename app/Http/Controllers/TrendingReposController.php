<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrendingReposController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->setResponse();
    }

    private function setResponse()
    {
        //TODO error handling
        $lastMonth = Carbon::now()->subMonth()->format('Y-m-d');
        $url ='https://api.github.com/search/repositories?q=created:>'.$lastMonth.'&sort=stars&order=desc';
        $this->response =  Http::get($url)->json();

    }


    public function trendingLanguages()
    {
        $groupedRepos =  $this->groupRepos('language',$this->response['items']);
        dd($groupedRepos);

    }

    private function groupRepos($key, $repos)
    {
        $groupedRepos = array();
        foreach($repos as $repo) {
            if(array_key_exists($key, $repo) && $repo[$key] != null){
                $groupedReposKey = array_search($repo[$key], array_column($groupedRepos, $key));
                // check condition by type ,to distinguish between "0 = false" and "0 -> index "
                if(gettype($groupedReposKey) != "boolean"){
                    $groupedRepos[$groupedReposKey]['count']++;
                    $groupedRepos[$groupedReposKey]['repos'][]=$repo;
                }else{
                    $groupedRepos[]=[
                        'language'=>$repo[$key],
                        'count'=>1,
                        'repos'=>[$repo]
                    ];
                }
            }
        }
        return $this->sortGroupedRepos($groupedRepos);
    }

    private function sortGroupedRepos(array $groupedRepos)
    {
        $columns = array_column($groupedRepos, 'count');
        array_multisort($columns, SORT_DESC,$groupedRepos);
        return $groupedRepos;
    }


}
