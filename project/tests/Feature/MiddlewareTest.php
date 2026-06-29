<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exceptions\Handler;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\Permissions;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\TrustHosts;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\Vendor;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieFactory;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\RouteCollection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mockery;

class MiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!\Illuminate\Support\Facades\Schema::hasTable('generalsettings')) {
            \Illuminate\Support\Facades\Schema::create('generalsettings', function ($table) {
                $table->id();
                $table->integer('is_maintain')->default(0);
                $table->string('title')->nullable();
                $table->string('time_zone')->nullable();
            });
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    private function registerMissingRoutes(): void
    {
        $router = $this->app['router'];
        if (!$router->has('front.index')) {
            $router->get('/', ['as' => 'front.index', 'uses' => function () { return 'front'; }]);
        }
        if (!$router->has('admin.dashboard')) {
            $router->get('admin/dashboard', ['as' => 'admin.dashboard', 'uses' => function () { return 'dashboard'; }]);
        }
        if (!$router->has('front-maintenance')) {
            $router->get('maintenance', ['as' => 'front-maintenance', 'uses' => function () { return 'maintenance'; }]);
        }
        if (!$router->has('login')) {
            $router->get('login', ['as' => 'login', 'uses' => function () { return 'login'; }]);
        }
    }

    private function makeMiddleware(string $class)
    {
        return $this->app->make($class);
    }

    // ---- Authenticate Middleware ----

    public function test_authenticate_redirects_to_login_route_when_not_expecting_json()
    {
        $this->registerMissingRoutes();

        $middleware = $this->makeMiddleware(Authenticate::class);
        $reflection = new \ReflectionMethod($middleware, 'redirectTo');
        $reflection->setAccessible(true);

        $request = Request::create('/admin');
        $result = $reflection->invoke($middleware, $request);

        $this->assertEquals(route('login'), $result);
    }

    public function test_authenticate_returns_null_when_expecting_json()
    {
        $this->registerMissingRoutes();

        $middleware = $this->makeMiddleware(Authenticate::class);
        $reflection = new \ReflectionMethod($middleware, 'redirectTo');
        $reflection->setAccessible(true);

        $request = Request::create('/api/data');
        $request->headers->set('Accept', 'application/json');
        $result = $reflection->invoke($middleware, $request);

        $this->assertNull($result);
    }

    public function test_authenticate_middleware_class_can_be_instantiated()
    {
        $middleware = $this->makeMiddleware(Authenticate::class);
        $this->assertInstanceOf(Authenticate::class, $middleware);
    }

    // ---- Permissions Middleware ----

    public function test_permissions_redirects_when_not_authenticated_as_admin()
    {
        $this->registerMissingRoutes();

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(false);
        Auth::shouldReceive('guard')->with('admin')->once()->andReturn($guardMock);

        $middleware = new Permissions();
        $request = Request::create('/admin/settings');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'general_settings');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_permissions_allows_super_admin_with_id_one()
    {
        $userMock = Mockery::mock();
        $userMock->id = 1;

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(true);
        $guardMock->shouldReceive('user')->once()->andReturn($userMock);
        Auth::shouldReceive('guard')->with('admin')->twice()->andReturn($guardMock);

        $middleware = new Permissions();
        $request = Request::create('/admin/dashboard');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'any_section');

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_permissions_allows_when_section_check_passes()
    {
        $userMock = Mockery::mock();
        $userMock->id = 2;
        $userMock->shouldReceive('sectionCheck')->with('categories')->once()->andReturn(true);

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(true);
        $guardMock->shouldReceive('user')->twice()->andReturn($userMock);
        Auth::shouldReceive('guard')->with('admin')->times(3)->andReturn($guardMock);

        $middleware = new Permissions();
        $request = Request::create('/admin/categories');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'categories');

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_permissions_redirects_when_section_check_fails()
    {
        $this->registerMissingRoutes();

        $userMock = Mockery::mock();
        $userMock->id = 2;
        $userMock->shouldReceive('sectionCheck')->with('forbidden_section')->once()->andReturn(false);

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(true);
        $guardMock->shouldReceive('user')->twice()->andReturn($userMock);
        Auth::shouldReceive('guard')->with('admin')->times(3)->andReturn($guardMock);

        $middleware = new Permissions();
        $request = Request::create('/admin/settings');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'forbidden_section');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    // ---- RedirectIfAuthenticated Middleware ----

    public function test_redirectIfAuthenticated_redirects_authenticated_users_to_front_index()
    {
        $this->registerMissingRoutes();

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('guard')->with(null)->once()->andReturn($guardMock);

        $middleware = new RedirectIfAuthenticated();
        $request = Request::create('/login');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_redirectIfAuthenticated_passes_unauthenticated_users()
    {
        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(false);
        Auth::shouldReceive('guard')->with(null)->once()->andReturn($guardMock);

        $middleware = new RedirectIfAuthenticated();
        $request = Request::create('/login');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_redirectIfAuthenticated_redirects_admin_to_admin_dashboard()
    {
        $this->registerMissingRoutes();

        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('guard')->with('admin')->once()->andReturn($guardMock);

        $middleware = new RedirectIfAuthenticated();
        $request = Request::create('/admin/login');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'admin');

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_redirectIfAuthenticated_passes_unauthenticated_admin()
    {
        $guardMock = Mockery::mock(\Illuminate\Contracts\Auth\Guard::class);
        $guardMock->shouldReceive('check')->once()->andReturn(false);
        Auth::shouldReceive('guard')->with('admin')->once()->andReturn($guardMock);

        $middleware = new RedirectIfAuthenticated();
        $request = Request::create('/admin/login');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next, 'admin');

        $this->assertEquals('OK', $response->getContent());
    }

    // ---- TrimStrings Middleware ----

    public function test_trimStrings_excludes_password_and_confirmation()
    {
        $middleware = new TrimStrings();
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('except');
        $property->setAccessible(true);
        $except = $property->getValue($middleware);

        $this->assertContains('password', $except);
        $this->assertContains('password_confirmation', $except);
    }

    public function test_trimStrings_extends_laravel_middleware()
    {
        $middleware = new TrimStrings();
        $this->assertInstanceOf(\Illuminate\Foundation\Http\Middleware\TrimStrings::class, $middleware);
    }

    // ---- VerifyCsrfToken Middleware ----

    public function test_verifyCsrfToken_excludes_payment_notification_urls()
    {
        $middleware = $this->makeMiddleware(VerifyCsrfToken::class);
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('except');
        $property->setAccessible(true);
        $except = $property->getValue($middleware);

        $this->assertContains('/checkout/payment/paytm-notify', $except);
        $this->assertContains('/checkout/payment/razorpay-notify', $except);
        $this->assertContains('/cflutter/notify', $except);
        $this->assertContains('/checkout/payment/ssl-notify', $except);
        $this->assertContains('/user/paytm-notify', $except);
        $this->assertContains('/user/razorpay-notify', $except);
        $this->assertContains('/uflutter/notify', $except);
        $this->assertContains('/user/ssl-notify', $except);
        $this->assertContains('/user/deposit/paytm-notify', $except);
        $this->assertContains('/user/deposit/razorpay-notify', $except);
        $this->assertContains('/dflutter/notify', $except);
        $this->assertContains('/user/deposit/ssl-notify', $except);
    }

    public function test_verifyCsrfToken_has_correct_count_of_excluded_urls()
    {
        $middleware = $this->makeMiddleware(VerifyCsrfToken::class);
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('except');
        $property->setAccessible(true);
        $except = $property->getValue($middleware);

        $this->assertCount(12, $except);
    }

    public function test_verifyCsrfToken_extends_laravel_middleware()
    {
        $middleware = $this->makeMiddleware(VerifyCsrfToken::class);
        $this->assertInstanceOf(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, $middleware);
    }

    // ---- MaintenanceMode Middleware ----

    public function test_maintenanceMode_redirects_when_maintenance_is_on()
    {
        $this->registerMissingRoutes();

        \DB::table('generalsettings')->insert(['id' => 1, 'is_maintain' => 1, 'title' => 'Test']);

        $middleware = new MaintenanceMode();
        $request = Request::create('/');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_maintenanceMode_passes_when_maintenance_is_off()
    {
        \DB::table('generalsettings')->insert(['id' => 1, 'is_maintain' => 0, 'title' => 'Test']);

        $middleware = new MaintenanceMode();
        $request = Request::create('/');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertEquals('OK', $response->getContent());
    }

    // ---- TrustHosts Middleware ----

    public function test_trustHosts_returns_subdomain_pattern()
    {
        $middleware = $this->makeMiddleware(TrustHosts::class);
        $hosts = $middleware->hosts();

        $this->assertIsArray($hosts);
        $this->assertNotEmpty($hosts);
    }

    public function test_trustHosts_extends_laravel_middleware()
    {
        $middleware = $this->makeMiddleware(TrustHosts::class);
        $this->assertInstanceOf(\Illuminate\Http\Middleware\TrustHosts::class, $middleware);
    }

    // ---- TrustProxies Middleware ----

    public function test_trustProxies_has_configured_proxies()
    {
        $middleware = new TrustProxies();
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('proxies');
        $property->setAccessible(true);
        $proxies = $property->getValue($middleware);

        $this->assertIsArray($proxies);
        $this->assertContains('192.168.1.1', $proxies);
        $this->assertContains('192.168.1.2', $proxies);
    }

    public function test_trustProxies_has_correct_headers_constant()
    {
        $middleware = new TrustProxies();
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('headers');
        $property->setAccessible(true);
        $headers = $property->getValue($middleware);

        $expected = Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO;

        $this->assertEquals($expected, $headers);
    }

    public function test_trustProxies_extends_laravel_middleware()
    {
        $middleware = new TrustProxies();
        $this->assertInstanceOf(\Illuminate\Http\Middleware\TrustProxies::class, $middleware);
    }

    // ---- CheckForMaintenanceMode Middleware ----

    public function test_checkForMaintenanceMode_has_empty_except_list()
    {
        $middleware = $this->makeMiddleware(CheckForMaintenanceMode::class);
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('except');
        $property->setAccessible(true);
        $except = $property->getValue($middleware);

        $this->assertIsArray($except);
        $this->assertEmpty($except);
    }

    public function test_checkForMaintenanceMode_extends_laravel_middleware()
    {
        $middleware = $this->makeMiddleware(CheckForMaintenanceMode::class);
        $this->assertInstanceOf(PreventRequestsDuringMaintenance::class, $middleware);
    }

    // ---- EncryptCookies Middleware ----

    public function test_encryptCookies_except_does_not_include_app_specific_cookies()
    {
        $parentReflection = new \ReflectionClass(\Illuminate\Cookie\Middleware\EncryptCookies::class);
        $parentProperty = $parentReflection->getProperty('except');
        $parentProperty->setAccessible(true);

        $middleware = $this->makeMiddleware(EncryptCookies::class);
        $reflection = new \ReflectionClass($middleware);
        $property = $reflection->getProperty('except');
        $property->setAccessible(true);
        $except = $property->getValue($middleware);

        $parentExcept = $parentProperty->getValue($middleware);

        $this->assertIsArray($except);
        $this->assertSame($parentExcept, $except);
    }

    public function test_encryptCookies_extends_laravel_middleware()
    {
        $middleware = $this->makeMiddleware(EncryptCookies::class);
        $this->assertInstanceOf(\Illuminate\Cookie\Middleware\EncryptCookies::class, $middleware);
    }

    // ---- Vendor Middleware ----

    public function test_vendor_passes_when_user_is_vendor()
    {
        $userMock = Mockery::mock();
        $userMock->shouldReceive('IsVendor')->once()->andReturn(true);

        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($userMock);

        $middleware = new Vendor();
        $request = Request::create('/vendor/dashboard');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_vendor_redirects_back_when_not_vendor()
    {
        $userMock = Mockery::mock();
        $userMock->shouldReceive('IsVendor')->once()->andReturn(false);

        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($userMock);

        $middleware = new Vendor();
        $request = Request::create('/vendor/dashboard');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    public function test_vendor_redirects_back_when_not_authenticated()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $middleware = new Vendor();
        $request = Request::create('/vendor/dashboard');
        $next = function ($req) {
            return new Response('OK');
        };

        $response = $middleware->handle($request, $next);

        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
    }

    // ---- Exception Handler ----

    public function test_handler_returns_json_for_unauthenticated_api_request()
    {
        $handler = $this->app->make(Handler::class);
        $request = Request::create('/api/user');
        $request->headers->set('Accept', 'application/json');

        $exception = new AuthenticationException('Unauthenticated.');

        $response = $handler->render($request, $exception);

        $this->assertEquals(401, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Unauthenticated.', $response->getContent());
    }

    public function test_handler_redirects_admin_unauthenticated_to_admin_login()
    {
        $this->registerMissingRoutes();

        $handler = $this->app->make(Handler::class);
        $request = Request::create('/admin/dashboard');

        $exception = new AuthenticationException('Unauthenticated.');

        $response = $handler->render($request, $exception);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_handler_redirects_non_admin_unauthenticated_to_log_reg()
    {
        $this->registerMissingRoutes();

        $handler = $this->app->make(Handler::class);
        $request = Request::create('/some-page');

        $exception = new AuthenticationException('Unauthenticated.');

        $response = $handler->render($request, $exception);

        $this->assertTrue($response->isRedirect());
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_handler_has_correct_dont_flash_properties()
    {
        $handler = $this->app->make(Handler::class);
        $reflection = new \ReflectionClass($handler);
        $property = $reflection->getProperty('dontFlash');
        $property->setAccessible(true);
        $dontFlash = $property->getValue($handler);

        $this->assertContains('password', $dontFlash);
        $this->assertContains('password_confirmation', $dontFlash);
    }
}
