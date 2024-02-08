<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    private $testRoute = '/api/test';

    public function test_route_response_local()
    {
        app()->detectEnvironment(fn() => 'local');
        $response = $this->get($this->testRoute);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_queue_configuration()
    {
        app()->detectEnvironment(fn() => 'local');
        $response = $this->get($this->testRoute . '/queue-connection');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'data' => [
                    'queue_connection' => 'redis'
                ]
            ]);
    }

    public function test_route_response_error()
    {
        app()->detectEnvironment(fn() => 'local');
        $response = $this->get($this->testRoute . '/failed');
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    public function test_route_response_no_content()
    {
        app()->detectEnvironment(fn() => 'local');
        $response = $this->get($this->testRoute . '/no_content');
        $response->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();
    }

    // public function testRedisQueue()
    // {
    //     app()->detectEnvironment(fn () => 'local');
    //     $response = $this->get($testRoute.'/redis-queue');
    //     $response->assertStatus(Response::HTTP_OK);
    // }


    public function test_route_response_not_local()
    {
        app()->detectEnvironment(fn() => 'production');
        $response = $this->get($this->testRoute);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_queue_configuration_not_local()
    {
        // Simule l'nvironnement de production
        app()->detectEnvironment(fn() => 'production');
        $response = $this->get($this->testRoute . '/queue-connection');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    public function test_route_response_error_not_local()
    {
        app()->detectEnvironment(fn() => 'production');
        $response = $this->get($this->testRoute . '/failed');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
    public function test_route_response_no_content_not_local()
    {
        app()->detectEnvironment(fn() => 'production');
        $response = $this->get($this->testRoute . '/no_content');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }


    // public function testRedisQueueNotLocal()
    // {
    //     app()->detectEnvironment(fn () => 'production');
    //     $response = $this->get($testRoute.'/redis-queue');
    //     $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    // }
}
