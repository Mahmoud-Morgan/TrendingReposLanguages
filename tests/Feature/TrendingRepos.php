<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrendingRepos extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTrendingReposApiRoute()
    {
        $response = $this->get('/api/trending_github_repos_languages');

        $response->assertStatus(200);
    }

}
