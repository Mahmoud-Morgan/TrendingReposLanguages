<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrendingReposTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTrendingReposApiRoute()
    {
        $response = $this->get('/api/trending_github_repos_languages');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'language',
                    'number_of_repos',
                    'repos_using_the_language'=>[
                        '*'=>[
                            'full_name',
                            'language',
                            'url'
                        ]
                    ]
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

}
