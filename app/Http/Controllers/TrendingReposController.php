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
        return gettype($this->response['items']);
    }
}
