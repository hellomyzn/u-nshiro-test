<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostListControllerTest extends TestCase
{
        
    /**
     * index
     *
     * @return void
     * @test
     */
    public function index_page(){
        $response = $this->get('/post-list');
        $response->assertOk();
    }
}
