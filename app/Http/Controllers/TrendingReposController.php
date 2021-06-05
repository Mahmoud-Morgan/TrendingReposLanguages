<?php

namespace App\Http\Controllers;


use App\Http\Resources\TrendingLanguagesResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class TrendingReposController extends Controller
{
    private $response;

    public function __construct()
    {
        try {
            $this->setResponse();
        } catch (Exception $e) {
            throw new ServiceUnavailableHttpException($e->getMessage());
        }
    }

    private function setResponse()
    {
        $lastMonth = Carbon::now()->subMonth()->format('Y-m-d');
        $url = 'https://api.github.com/search/repositories?q=created:>' . $lastMonth . '&sort=stars&order=desc';
        $response = Http::get($url);
        if ($response->status() == 200) {
            $this->response = $response->json();
        } else {
            throw new ServiceUnavailableHttpException();
        }
    }


    public function trendingLanguages()
    {
        $groupedRepos = $this->groupRepos('language', $this->response['items']);
        return TrendingLanguagesResource::collection($groupedRepos);
    }

    private function groupRepos($key, $repos): array
    {
        $groupedRepos = array();
        foreach ($repos as $repo) {
            if (array_key_exists($key, $repo) && $repo[$key] != null) {
                $groupedReposKey = array_search($repo[$key], array_column($groupedRepos, $key));
                // check condition by type ,to distinguish between "0 = false" and "0 -> index "
                if (gettype($groupedReposKey) != "boolean") {
                    $groupedRepos[$groupedReposKey]['count']++;
                    $groupedRepos[$groupedReposKey]['repos'][] = $repo;
                } else {
                    $groupedRepos[] = [
                        'language' => $repo[$key],
                        'count' => 1,
                        'repos' => [$repo]
                    ];
                }
            }
        }
        return $this->sortGroupedRepos($groupedRepos);
    }

    private function sortGroupedRepos(array $groupedRepos): array
    {
        $columns = array_column($groupedRepos, 'count');
        array_multisort($columns, SORT_DESC, $groupedRepos);
        return $groupedRepos;
    }


}
