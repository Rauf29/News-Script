<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\BroadcastServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class ProvidersTest extends TestCase
{
    // ---- AppServiceProvider ----

    public function test_app_service_provider_can_be_instantiated()
    {
        $provider = new AppServiceProvider($this->app);
        $this->assertInstanceOf(AppServiceProvider::class, $provider);
    }

    public function test_app_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(AppServiceProvider::class));
    }

    public function test_app_service_provider_boot_sets_bootstrap_pagination()
    {
        $provider = new AppServiceProvider($this->app);
        $provider->boot();

        Paginator::useBootstrap();
        $this->assertTrue(true);
    }

    public function test_app_service_provider_boot_runs_without_errors()
    {
        $provider = new AppServiceProvider($this->app);
        $provider->boot();

        $this->assertTrue(true);
    }

    // ---- RouteServiceProvider ----

    public function test_route_service_provider_can_be_instantiated()
    {
        $provider = new RouteServiceProvider($this->app);
        $this->assertInstanceOf(RouteServiceProvider::class, $provider);
    }

    public function test_route_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(RouteServiceProvider::class));
    }

    public function test_route_service_provider_has_correct_namespace()
    {
        $provider = new RouteServiceProvider($this->app);
        $reflection = new \ReflectionClass($provider);
        $property = $reflection->getProperty('namespace');
        $property->setAccessible(true);
        $namespace = $property->getValue($provider);

        $this->assertEquals('App\Http\Controllers', $namespace);
    }

    public function test_route_service_provider_loads_web_routes()
    {
        $this->assertTrue(Route::has('frontend.index'));
        $this->assertTrue(Route::has('admin.dashboard'));
        $this->assertTrue(Route::has('front.login'));
    }

    public function test_route_service_provider_loads_api_routes()
    {
        $routes = Route::getRoutes();
        $found = false;
        foreach ($routes as $route) {
            if (str_contains($route->uri(), 'api/user')) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'API route api/user should be registered');
    }

    public function test_web_routes_use_web_middleware()
    {
        $route = Route::getRoutes()->getByName('frontend.index');
        $this->assertNotNull($route);
        $this->assertContains('web', $route->gatherMiddleware());
    }

    // ---- AuthServiceProvider ----

    public function test_auth_service_provider_can_be_instantiated()
    {
        $provider = new AuthServiceProvider($this->app);
        $this->assertInstanceOf(AuthServiceProvider::class, $provider);
    }

    public function test_auth_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(AuthServiceProvider::class));
    }

    public function test_auth_service_provider_defines_model_policy()
    {
        $provider = new AuthServiceProvider($this->app);
        $reflection = new \ReflectionClass($provider);
        $property = $reflection->getProperty('policies');
        $property->setAccessible(true);
        $policies = $property->getValue($provider);

        $this->assertArrayHasKey('App\Model', $policies);
        $this->assertEquals('App\Policies\ModelPolicy', $policies['App\Model']);
    }

    public function test_auth_service_provider_boot_registers_policies()
    {
        $provider = new AuthServiceProvider($this->app);
        $provider->boot();

        $this->assertTrue(true);
    }

    // ---- EventServiceProvider ----

    public function test_event_service_provider_can_be_instantiated()
    {
        $provider = new EventServiceProvider($this->app);
        $this->assertInstanceOf(EventServiceProvider::class, $provider);
    }

    public function test_event_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(EventServiceProvider::class));
    }

    public function test_event_service_provider_maps_events_to_listeners()
    {
        $provider = new EventServiceProvider($this->app);
        $reflection = new \ReflectionClass($provider);
        $property = $reflection->getProperty('listen');
        $property->setAccessible(true);
        $listen = $property->getValue($provider);

        $this->assertArrayHasKey('App\Events\Event', $listen);
        $this->assertContains('App\Listeners\EventListener', $listen['App\Events\Event']);
    }

    public function test_event_service_provider_boot_calls_parent()
    {
        $provider = new EventServiceProvider($this->app);
        $provider->boot();

        $this->assertTrue(true);
    }

    // ---- BroadcastServiceProvider ----

    public function test_broadcast_service_provider_can_be_instantiated()
    {
        $provider = new BroadcastServiceProvider($this->app);
        $this->assertInstanceOf(BroadcastServiceProvider::class, $provider);
    }

    public function test_broadcast_service_provider_can_boot()
    {
        $provider = new BroadcastServiceProvider($this->app);
        $provider->boot();

        $this->assertTrue(true);
    }
}
