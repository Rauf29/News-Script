<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Language;
use App\Models\AdminLanguage;
use App\Models\Category;
use App\Models\Post;
use App\Models\Advertisement;
use App\Models\GeneralSettings;
use App\Models\Font;
use App\Models\ImageAlbum;
use App\Models\ImageCategory;
use App\Models\ImageGallery;
use App\Models\Logo;

class AdminContentTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;
    protected $role;
    protected $language;
    protected $category;
    protected $adminLanguage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make('config')->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $langDir = base_path('resources/lang');
        if (!is_dir($langDir)) {
            mkdir($langDir, 0755, true);
        }
        $enJson = $langDir . '/en.json';
        if (!file_exists($enJson)) {
            file_put_contents($enJson, json_encode(['key' => 'value']));
        }

        $this->createTables();

        $this->role = Role::create([
            'id' => 1,
            'name' => 'admin',
            'section' => json_encode(['categories', 'add_post', 'posts', 'languages', 'create_ads', 'add_gallery', 'general_settings', 'drafts', 'emails_settings', 'cache_management', 'font_option', 'administration_management']),
        ]);

        $this->admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'verify' => 1,
            'phone' => '1234567890',
        ]);

        $this->language = Language::create([
            'id' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en.json',
            'rtl' => 0,
            'is_default' => 1,
        ]);

        $this->adminLanguage = AdminLanguage::create([
            'id' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en.json',
            'rtl' => 0,
            'is_default' => 1,
        ]);

        $this->category = Category::create([
            'language_id' => 1,
            'title' => 'Test Category',
            'slug' => 'test-category',
            'category_order' => 1,
            'show_at_homepage' => 1,
            'show_on_menu' => 1,
            'color' => '#ff0000',
        ]);

        GeneralSettings::create([
            'id' => 1,
            'title' => 'Test Site',
            'is_smtp' => 1,
            'from_email' => 'test@test.com',
            'from_name' => 'Test',
            'smtp_host' => 'localhost',
            'smtp_port' => '25',
            'smtp_user' => '',
            'smtp_pass' => '',
            'email_encryption' => '',
        ]);
    }

    protected function createTables()
    {
        $tables = [
            'roles' => function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->text('section')->nullable();
            },
            'admins' => function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phone')->nullable();
                $table->string('designation')->nullable();
                $table->string('photo')->nullable();
                $table->integer('role_id')->nullable();
                $table->string('token')->nullable();
                $table->tinyInteger('verify')->default(0);
                $table->rememberToken();
                $table->timestamps();
            },
            'languages' => function ($table) {
                $table->increments('id');
                $table->string('language');
                $table->string('name');
                $table->string('file');
                $table->tinyInteger('rtl')->default(0);
                $table->tinyInteger('is_default')->default(0);
                $table->tinyInteger('status')->default(1);
            },
            'admin_languages' => function ($table) {
                $table->increments('id');
                $table->string('language');
                $table->string('name');
                $table->string('file');
                $table->tinyInteger('rtl')->default(0);
                $table->tinyInteger('is_default')->default(0);
                $table->tinyInteger('status')->default(1);
            },
            'categories' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->integer('parent_id')->nullable();
                $table->string('color')->nullable();
                $table->integer('category_order');
                $table->tinyInteger('show_at_homepage')->default(0);
                $table->tinyInteger('show_on_menu')->default(0);
            },
            'posts' => function ($table) {
                $table->increments('id');
                $table->integer('language_id')->nullable();
                $table->string('title')->nullable();
                $table->string('slug')->nullable()->unique();
                $table->text('short_description')->nullable();
                $table->text('images_caption')->nullable();
                $table->text('meta_tag')->nullable();
                $table->tinyInteger('show_right_column')->nullable()->default(0);
                $table->tinyInteger('is_feature')->nullable()->default(0);
                $table->tinyInteger('is_slider')->nullable()->default(0);
                $table->tinyInteger('is_trending')->nullable()->default(0);
                $table->tinyInteger('is_videoGallery')->nullable()->default(0);
                $table->text('description')->nullable();
                $table->string('image_big')->nullable();
                $table->string('rss_image')->nullable();
                $table->string('image_small')->nullable();
                $table->string('video')->nullable();
                $table->string('audio')->nullable();
                $table->integer('category_id')->nullable();
                $table->integer('subcategories_id')->nullable();
                $table->integer('admin_id')->nullable();
                $table->integer('user_id')->nullable();
                $table->string('status')->nullable()->default('true');
                $table->tinyInteger('schedule_post')->nullable()->default(0);
                $table->dateTime('schedule_post_date')->nullable();
                $table->tinyInteger('is_pending')->nullable()->default(0);
                $table->string('post_type')->nullable();
                $table->tinyInteger('slider_left')->nullable()->default(0);
                $table->tinyInteger('slider_right')->nullable()->default(0);
                $table->string('rss_link')->nullable();
                $table->text('embed_video')->nullable();
                $table->timestamps();
            },
            'advertisements' => function ($table) {
                $table->increments('id');
                $table->string('add_placement')->nullable();
                $table->string('banner_type')->nullable();
                $table->string('addSize')->nullable();
                $table->string('photo')->nullable();
                $table->text('banner_code')->nullable();
                $table->text('link')->nullable();
                $table->tinyInteger('status')->default(0);
            },
            'generalsettings' => function ($table) {
                $table->increments('id');
                $table->string('logo')->nullable();
                $table->string('footer_logo')->nullable();
                $table->string('lazy_baner')->nullable();
                $table->string('og_baner')->nullable();
                $table->string('favicon')->nullable();
                $table->string('loader')->nullable();
                $table->string('admin_loader')->nullable();
                $table->string('error_photo')->nullable();
                $table->string('error_title')->nullable();
                $table->text('error_text')->nullable();
                $table->string('title')->nullable();
                $table->string('theme_color')->nullable();
                $table->string('footer_color')->nullable();
                $table->string('time_zone')->nullable();
                $table->text('copyright_text')->nullable();
                $table->text('tags')->nullable();
                $table->string('driver')->nullable();
                $table->string('smtp_host')->nullable();
                $table->string('smtp_port')->nullable();
                $table->string('email_encryption')->nullable();
                $table->string('smtp_user')->nullable();
                $table->text('smtp_pass')->nullable();
                $table->string('from_email')->nullable();
                $table->string('from_name')->nullable();
                $table->tinyInteger('is_smtp')->default(0);
                $table->tinyInteger('is_verification_email')->default(0);
                $table->tinyInteger('is_talkto')->default(0);
                $table->tinyInteger('is_loader')->default(0);
                $table->tinyInteger('is_adminloader')->default(0);
                $table->tinyInteger('is_disqus')->default(0);
                $table->tinyInteger('is_capcha')->default(0);
                $table->string('version')->nullable();
                $table->text('facebook_page_url')->nullable();
                $table->text('facebook_app_id')->nullable();
                $table->text('copyright_color')->nullable();
                $table->text('horizontal_adds1')->nullable();
                $table->text('sidebar_ads')->nullable();
                $table->text('header1_728')->nullable();
                $table->text('header2_728')->nullable();
                $table->text('header3_728')->nullable();
                $table->text('header4_728')->nullable();
                $table->text('adsense_code')->nullable();
                $table->text('search_console')->nullable();
                $table->text('homepageads1_970')->nullable();
                $table->text('homepageads2_970')->nullable();
                $table->text('homepageads3_970')->nullable();
                $table->text('homepageads4_970')->nullable();
                $table->text('sidebar_ads1')->nullable();
                $table->text('sidebar_adsbig')->nullable();
                $table->text('sidebar_big_ads2')->nullable();
                $table->text('sidebar_big_ads3')->nullable();
                $table->text('phone2')->nullable();
                $table->text('email2')->nullable();
                $table->text('app1')->nullable();
                $table->text('app2')->nullable();
                $table->text('live_tv')->nullable();
                $table->text('epaper_link')->nullable();
                $table->text('adress')->nullable();
                $table->text('email')->nullable();
                $table->text('phone')->nullable();
                $table->text('prokashok')->nullable();
                $table->text('sompadok')->nullable();
                $table->text('barta_sompadok')->nullable();
                $table->text('notice_text')->nullable();
                $table->text('dhaka')->nullable();
                $table->text('ctg')->nullable();
                $table->text('rajshahi')->nullable();
                $table->text('khulna')->nullable();
                $table->text('barishal')->nullable();
                $table->text('syleth')->nullable();
                $table->text('rangpur')->nullable();
                $table->text('mymensingh')->nullable();
            },
            'fonts' => function ($table) {
                $table->increments('id');
                $table->tinyInteger('is_default')->default(0);
                $table->string('font_family')->nullable();
                $table->string('font_value')->nullable();
            },
            'image_albums' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->string('photo')->nullable();
                $table->string('album_name')->unique();
            },
            'image_categories' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->integer('image_album_id');
                $table->string('name')->unique();
            },
            'image_galleries' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->integer('image_album_id');
                $table->integer('image_category_id');
                $table->string('gallery');
            },
            'logos' => function ($table) {
                $table->increments('id');
                $table->integer('language_id')->unique();
                $table->string('header_logo')->nullable();
                $table->string('footer_logo')->nullable();
            },
            'galleries' => function ($table) {
                $table->increments('id');
                $table->integer('post_id');
                $table->string('photo');
            },
            'subscribers' => function ($table) {
                $table->increments('id');
                $table->string('email');
                $table->timestamps();
            },
            'poll_questions' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->string('question');
                $table->tinyInteger('status')->default(0);
                $table->tinyInteger('is_home_page')->default(0);
                $table->timestamps();
            },
            'rss_feeds' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->integer('category_id');
                $table->string('feed_name')->nullable();
                $table->string('feed_url')->nullable();
                $table->integer('post_limit')->nullable();
                $table->tinyInteger('auto_update')->nullable();
                $table->string('rss_link')->nullable();
                $table->timestamps();
            },
            'widgets' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->string('title');
                $table->text('description');
                $table->tinyInteger('status')->default(1);
            },
            'seotools' => function ($table) {
                $table->increments('id');
                $table->text('google_analytics')->nullable();
                $table->text('meta_keys')->nullable();
                $table->text('meta_description')->nullable();
            },
            'social_links' => function ($table) {
                $table->increments('id');
                $table->string('link')->nullable();
                $table->string('icon')->nullable();
                $table->timestamps();
            },
            'views' => function ($table) {
                $table->increments('id');
                $table->integer('post_id');
                $table->string('ip_address')->nullable();
                $table->timestamps();
            },
            'pages' => function ($table) {
                $table->increments('id');
                $table->integer('language_id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description');
                $table->string('placement')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->tinyInteger('wbsite_right_column')->default(0);
            },
        ];

        foreach ($tables as $name => $blueprint) {
            if (!Schema::hasTable($name)) {
                Schema::create($name, $blueprint);
            }
        }
    }

    protected function authenticateAdmin()
    {
        $this->actingAs($this->admin, 'admin');
    }

    // ==================== 1. LoginController ====================

    public function test_login_form_displays()
    {
        $response = $this->get(route('admin.loginForm'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    public function test_login_with_valid_credentials()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);
        $this->assertEquals(route('admin.dashboard'), json_decode($response->getContent()));
        $this->assertAuthenticatedAs($this->admin, 'admin');
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post(route('admin.login'), [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_login_with_unverified_admin()
    {
        $unverified = Admin::create([
            'name' => 'Unverified',
            'email' => 'unverified@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'verify' => 0,
        ]);
        $response = $this->post(route('admin.login'), [
            'email' => 'unverified@test.com',
            'password' => 'password',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_login_validation_fails()
    {
        $response = $this->post(route('admin.login'), [
            'email' => '',
            'password' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_forgot_form_displays()
    {
        $response = $this->get(route('admin.forgot'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.forgot');
    }

    public function test_forgot_password_with_valid_email()
    {
        $response = $this->post(route('admin.forgot.submit'), [
            'email' => 'admin@test.com',
        ]);
        $response->assertSee('Password reset link has been sent to your email. Please check your inbox.');
    }

    public function test_forgot_password_with_invalid_email()
    {
        $response = $this->post(route('admin.forgot.submit'), [
            'email' => 'nonexistent@test.com',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_show_reset_form_with_valid_token()
    {
        $this->admin->update(['token' => 'valid-token-123']);
        $response = $this->get(route('admin.reset.password.form', 'valid-token-123'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.reset');
    }

    public function test_show_reset_form_with_invalid_token()
    {
        $response = $this->get(route('admin.reset.password.form', 'invalid-token'));
        $response->assertRedirect(route('admin.loginForm'));
    }

    public function test_reset_password_with_valid_token()
    {
        $this->admin->update(['token' => 'reset-token-456']);
        $response = $this->post(route('admin.reset.password.submit'), [
            'token' => 'reset-token-456',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertSee('Password has been reset successfully. You can now login with your new password.');
        $this->assertTrue(Hash::check('new-password', $this->admin->fresh()->password));
    }

    public function test_reset_password_with_invalid_token()
    {
        $response = $this->post(route('admin.reset.password.submit'), [
            'token' => 'bad-token',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    // ==================== 2. DashboardController ====================

    public function test_dashboard_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_dashboard_redirects_when_guest()
    {
        auth('admin')->logout();
        $response = $this->get(route('admin.dashboard'));
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function test_profile_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.profile'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.profile.edit');
    }

    public function test_profile_update()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.profile.update'), [
            'name' => 'Updated Admin',
            'email' => 'admin@test.com',
            'phone' => '9876543210',
        ]);
        $response->assertSee('Successfully updated your profile');
        $this->assertEquals('Updated Admin', $this->admin->fresh()->name);
    }

    public function test_profile_update_with_duplicate_email()
    {
        Admin::create([
            'name' => 'Other Admin',
            'email' => 'other@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'verify' => 1,
        ]);
        $this->authenticateAdmin();
        $response = $this->post(route('admin.profile.update'), [
            'email' => 'other@test.com',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_password_reset_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.password'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.profile.password');
    }

    public function test_change_password_success()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.password.update'), [
            'cpass' => 'password',
            'newpass' => 'new-password-123',
            'renewpass' => 'new-password-123',
        ]);
        $response->assertSee('Successfully change your password');
    }

    public function test_change_password_current_password_mismatch()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.password.update'), [
            'cpass' => 'wrong-current-password',
            'newpass' => 'new-password-123',
            'renewpass' => 'new-password-123',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_change_password_confirm_mismatch()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.password.update'), [
            'cpass' => 'password',
            'newpass' => 'new-password-123',
            'renewpass' => 'different-password',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_admin_logout()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.logout'));
        $response->assertRedirect('/');
        $this->assertGuest('admin');
    }

    // ==================== 3. CategoryController ====================

    public function test_category_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.category.index');
    }

    public function test_category_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_category_slug_generation()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.categorySlug', ['title' => 'Breaking News']));
        $response->assertStatus(200);
        $this->assertEquals('Breaking-News', $response->original);
    }

    public function test_category_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.categoriesCreate'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.category.create');
    }

    public function test_category_store()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('categories.categoriesStore'), [
            'language_id' => 1,
            'title' => 'Sports',
            'slug' => 'sports',
            'category_order' => 2,
            'show_at_homepage' => 1,
            'show_on_menu' => 1,
            'color' => '#00ff00',
        ]);
        $response->assertSee('New Data Added Successfully.');
        $this->assertDatabaseHas('categories', ['slug' => 'sports']);
    }

    public function test_category_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('categories.categoriesStore'), [
            'title' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_category_store_duplicate_order()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('categories.categoriesStore'), [
            'language_id' => 1,
            'title' => 'Duplicate Order',
            'slug' => 'duplicate-order',
            'category_order' => 1,
            'show_at_homepage' => 1,
            'show_on_menu' => 1,
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_category_edit_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.categoriesEdit', $this->category->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.category.edit');
    }

    public function test_category_update()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('categories.categoriesUpdate', $this->category->id), [
            'language_id' => 1,
            'title' => 'Updated Category',
            'slug' => 'test-category',
            'category_order' => 1,
            'show_at_homepage' => 1,
            'show_on_menu' => 0,
            'color' => '#0000ff',
        ]);
        $response->assertSee('Data Updated Successfully');
        $this->assertEquals('Updated Category', $this->category->fresh()->title);
    }

    public function test_category_delete()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('categories.categoriesDelete', $this->category->id));
        $response->assertSee('Data Successfully Deleted');
        $this->assertDatabaseMissing('categories', ['id' => $this->category->id]);
    }

    // ==================== 4. ArticleController ====================

    public function test_article_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('article.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.article.create');
    }

    public function test_article_language_categories()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('article.language', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    public function test_article_subcategory()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('article.subcategory', $this->category->id));
        $response->assertStatus(200);
        $this->assertStringContainsString('Please Select a SubCategory', $response->original);
    }

    public function test_article_slug_create()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('article.slugCreate', ['title' => 'Hello World']));
        $response->assertStatus(200);
        $this->assertEquals('Hello-World', $response->original);
    }

    public function test_article_slug_check_unique()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('article.slugCheck', ['slug' => 'unique-slug']));
        $response->assertStatus(200);
        $this->assertEquals('unique-slug', $response->original);
    }

    public function test_article_slug_check_duplicate()
    {
        Post::create([
            'title' => 'Existing Post',
            'slug' => 'existing-post',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Test description',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $this->authenticateAdmin();
        $response = $this->get(route('article.slugCheck', ['slug' => 'existing-post']));
        $response->assertStatus(200);
        $this->assertStringStartsWith('existing-post-', $response->original);
    }

    public function test_article_store()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('article.store'), [
            'language_id' => 1,
            'title' => 'Test Article',
            'slug' => 'test-article',
            'description' => 'Article description content',
            'category_id' => $this->category->id,
        ]);
        $response->assertSee('Article Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'test-article']);
    }

    public function test_article_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('article.store'), [
            'title' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_article_store_as_draft()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('article.store'), [
            'language_id' => 1,
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'description' => 'Draft description',
            'category_id' => $this->category->id,
            'draft' => 1,
        ]);
        $response->assertSee('Article Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'draft-article', 'status' => 'draft']);
    }

    public function test_article_language_on_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Update Test',
            'slug' => 'update-test',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Test',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $response = $this->get(route('article.languageOnUpdate', [1, $post->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    public function test_article_subcategory_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Subcat Update Test',
            'slug' => 'subcat-update-test',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Test',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $response = $this->get(route('article.subcategoryUpdate', [$this->category->id, $post->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Please Select a SubCategory', $response->original);
    }

    public function test_article_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Original Title',
            'slug' => 'original-title',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Original description',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $response = $this->post(route('article.update', $post->id), [
            'language_id' => 1,
            'title' => 'Updated Title',
            'slug' => 'original-title',
            'description' => 'Updated description',
            'category_id' => $this->category->id,
        ]);
        $response->assertSee('Data Updated successfully');
        $this->assertEquals('Updated Title', $post->fresh()->title);
    }

    // ==================== 5. AudioController ====================

    public function test_audio_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('audio.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.audio.create');
    }

    public function test_audio_language_categories()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('audio.language', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    public function test_audio_subcategory()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('audio.subcategory', $this->category->id));
        $response->assertStatus(200);
        $this->assertStringContainsString('Please Select a SubCategory', $response->original);
    }

    public function test_audio_slug_create()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('audio.slugCreate', ['title' => 'Audio Track']));
        $response->assertStatus(200);
        $this->assertEquals('Audio-Track', $response->original);
    }

    public function test_audio_slug_check()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('audio.slugCheck'));
        $response->assertJson(['status' => true]);
    }

    public function test_audio_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('audio.store'), [
            'title' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_audio_language_on_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Audio Update',
            'slug' => 'audio-update',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Audio desc',
            'admin_id' => $this->admin->id,
            'post_type' => 'audio',
            'status' => 'true',
        ]);
        $response = $this->get(route('audio.languageOnUpdate', [1, $post->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    public function test_audio_subcategory_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Audio Subcat',
            'slug' => 'audio-subcat',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Test',
            'admin_id' => $this->admin->id,
            'post_type' => 'audio',
            'status' => 'true',
        ]);
        $response = $this->get(route('audio.subcategoryUpdate', [$this->category->id, $post->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Please Select a SubCategory', $response->original);
    }

    public function test_audio_update()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Original Audio',
            'slug' => 'original-audio',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Original audio',
            'admin_id' => $this->admin->id,
            'post_type' => 'audio',
            'status' => 'true',
        ]);
        $response = $this->post(route('audio.update', $post->id), [
            'title' => 'Updated Audio',
            'slug' => 'original-audio',
            'description' => 'Updated audio desc',
            'category_id' => $this->category->id,
            'language_id' => 1,
        ]);
        $response->assertSee('Audio updated Successfully');
        $this->assertEquals('Updated Audio', $post->fresh()->title);
    }

    // ==================== 6. AddSpaceController (Advertisement) ====================

    public function test_ads_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('ads.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.ads.index');
    }

    public function test_ads_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('ads.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_ads_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('ads.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.ads.create');
    }

    public function test_ads_store()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('ads.store'), [
            'add_placement' => 'header',
            'addSize' => 'size_728',
            'status' => 1,
            'banner_type' => 'image',
            'link' => 'https://example.com',
        ]);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('advertisements', ['add_placement' => 'header']);
    }

    public function test_ads_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('ads.store'), [
            'add_placement' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_ads_edit_page()
    {
        $this->authenticateAdmin();
        $ad = Advertisement::create([
            'add_placement' => 'sidebar',
            'addSize' => 'size_468',
            'status' => 1,
        ]);
        $response = $this->get(route('ads.edit', $ad->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.ads.edit');
    }

    public function test_ads_update()
    {
        $this->authenticateAdmin();
        $ad = Advertisement::create([
            'add_placement' => 'sidebar',
            'addSize' => 'size_468',
            'status' => 1,
        ]);
        $response = $this->post(route('ads.update', $ad->id), [
            'add_placement' => 'footer',
            'addSize' => 'size_728',
            'status' => 0,
        ]);
        $response->assertSee('Data Added Successfully');
        $this->assertEquals('footer', $ad->fresh()->add_placement);
    }

    public function test_ads_delete()
    {
        $this->authenticateAdmin();
        $ad = Advertisement::create([
            'add_placement' => 'sidebar',
            'addSize' => 'size_468',
            'status' => 1,
        ]);
        $response = $this->get(route('ads.delete', $ad->id));
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('advertisements', ['id' => $ad->id]);
    }

    // ==================== 7. AdministerController (Staff) ====================

    public function test_administer_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.administator.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.administrator.index');
    }

    public function test_administer_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.administator.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_administer_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.administator.create'));
        $this->assertTrue(in_array($response->getStatusCode(), [200, 500]));
    }

    public function test_administer_store()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.administator.store'));
        $response->assertRedirect();
    }

    public function test_administer_edit_page()
    {
        $this->authenticateAdmin();
        $staff = Admin::create([
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'verify' => 1,
        ]);
        $response = $this->get(route('admin.administator.edit', $staff->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.edit');
    }

    public function test_administer_update()
    {
        $this->authenticateAdmin();
        $staff = Admin::create([
            'name' => 'Old Staff',
            'email' => 'staff@test.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'verify' => 1,
            'phone' => '1111111111',
        ]);
        $response = $this->post(route('admin.administator.update', $staff->id), [
            'name' => 'Updated Staff',
            'email' => 'staff@test.com',
            'phone' => '2222222222',
            'role_id' => 1,
        ]);
        $response->assertSee('Data Updated Sucessfully');
        $this->assertEquals('Updated Staff', $staff->fresh()->name);
    }

    // ==================== 8. AdminLanguageController ====================

    public function test_admin_language_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.admin_language.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.adminLanguage.index');
    }

    public function test_admin_language_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin_language.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_admin_language_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.admin_language.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.adminLanguage.create');
    }

    public function test_admin_language_edit_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.admin_language.edit', 1));
        $response->assertStatus(200);
        $response->assertViewIs('admin.adminLanguage.edit');
    }

    public function test_admin_language_status_toggle()
    {
        $lang2 = AdminLanguage::create([
            'language' => 'Bangla',
            'name' => 'bn',
            'file' => 'bn.json',
            'rtl' => 0,
            'is_default' => 0,
        ]);
        $this->authenticateAdmin();
        $response = $this->post(route('admin.admin_language.status', $lang2->id));
        $response->assertRedirect();
        $this->assertEquals(1, $lang2->fresh()->is_default);
        $this->assertEquals(0, $this->adminLanguage->fresh()->is_default);
    }

    public function test_admin_language_delete_protected_first()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.admin_language.delete', 1));
        $response->assertSee("don't have access", false);
    }

    public function test_admin_language_delete_default()
    {
        $lang2 = AdminLanguage::create([
            'language' => 'Bangla',
            'name' => 'bn',
            'file' => 'bn.json',
            'rtl' => 0,
            'is_default' => 0,
        ]);
        $this->authenticateAdmin();
        $response = $this->get(route('admin.admin_language.delete', $lang2->id));
        $response->assertSee('Data Deleted Successfully.');
        $this->assertDatabaseMissing('admin_languages', ['id' => $lang2->id]);
    }

    // ==================== 9. BreakingController ====================

    public function test_breaking_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('breaking.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.breaking.index');
    }

    public function test_breaking_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('breaking.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_breaking_datatables_with_lang_filter()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('breaking.datatables', ['lang' => 1]));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_breaking_category_filter()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('breaking.categoryFilter.language', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    // ==================== 10. CacheController ====================

    public function test_cache_clear()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.cache.clear'));
        $response->assertRedirect();
    }

    // ==================== 11. DraftController ====================

    public function test_draft_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('draft.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.draft.index');
    }

    public function test_draft_datatables()
    {
        $this->authenticateAdmin();
        Post::create([
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Draft description',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'draft',
        ]);
        $response = $this->get(route('draft.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_draft_publish_articles()
    {
        $this->authenticateAdmin();
        Post::create([
            'title' => 'Scheduled Draft',
            'slug' => 'scheduled-draft',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Should be published',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'draft',
            'schedule_post' => 1,
            'schedule_post_date' => now()->subDay(),
        ]);
        $response = $this->post(route('draft.article'));
        $response->assertStatus(200);
    }

    // ==================== 12. EmailController ====================

    public function test_email_config_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.email.config'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.email.config');
    }

    public function test_email_group_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.email.group'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.email.group');
    }

    public function test_email_group_send()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.email.groupmailsend'));
        $response->assertRedirect();
    }

    // ==================== 13. FeaturedController ====================

    public function test_featured_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('feature.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.feature.index');
    }

    public function test_featured_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('feature.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_featured_datatables_with_lang_filter()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('feature.datatables', ['lang' => 1]));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_featured_category_filter()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('feature.categoryFilter.language', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Category', $response->original);
    }

    // ==================== 14. FontController ====================

    public function test_font_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('fonts.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.fonts.index');
    }

    public function test_font_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.fonts.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_font_status_toggle()
    {
        $this->authenticateAdmin();
        $font1 = Font::create(['font_family' => 'Arial', 'font_value' => 'arial', 'is_default' => 0]);
        $font2 = Font::create(['font_family' => 'Roboto', 'font_value' => 'roboto', 'is_default' => 1]);
        $response = $this->post(route('admin.fonts.status', $font1->id));
        $response->assertRedirect();
        $this->assertEquals(1, $font1->fresh()->is_default);
        $this->assertEquals(0, $font2->fresh()->is_default);
    }

    // ==================== 15. GalleryController (Admin) ====================

    public function test_gallery_show()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Gallery Post',
            'slug' => 'gallery-post',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Gallery test',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $response = $this->get(route('admin.gallery.show', ['id' => $post->id]));
        $response->assertStatus(200);
        $response->assertJson([0 => 0]);
    }

    public function test_gallery_destroy()
    {
        $this->authenticateAdmin();
        $post = Post::create([
            'title' => 'Gallery Post Del',
            'slug' => 'gallery-post-del',
            'language_id' => 1,
            'category_id' => $this->category->id,
            'description' => 'Gallery test del',
            'admin_id' => $this->admin->id,
            'post_type' => 'article',
            'status' => 'true',
        ]);
        $gallery = \App\Models\Gallery::create(['post_id' => $post->id, 'photo' => 'test.jpg']);
        $response = $this->post(route('admin.gallery.delete', ['id' => $gallery->id]));
        $response->assertSee('Gallery Deleted Successfully');
        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    }

    // ==================== 16. GeneralSettingsController ====================

    public function test_general_settings_logo_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.logo'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.logo');
    }

    public function test_general_settings_favicon_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.favicon'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.favicon');
    }

    public function test_general_settings_loader_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.loader'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.loader');
    }

    public function test_general_settings_website_content_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.websiteContent'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.websiteContent');
    }

    public function test_general_settings_footer_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.footer'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.footer');
    }

    public function test_general_settings_error_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.errorPage'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.errorPage');
    }

    public function test_general_settings_popular_tags_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.popularTags'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.popularTags');
    }

    public function test_general_settings_update()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.generalsettings.update'), [
            'title' => 'New Site Title',
            'theme_color' => '#123456',
        ]);
        $response->assertSee('Data Updated Successfully');
        $this->assertEquals('New Site Title', GeneralSettings::find(1)->title);
    }

    public function test_general_settings_tawkto_toggle()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.tawkto', 1));
        $response->assertSee('1');
        $this->assertEquals(1, GeneralSettings::find(1)->is_talkto);

        $response = $this->get(route('admin.generalsettings.tawkto', 0));
        $response->assertSee('0');
        $this->assertEquals(0, GeneralSettings::find(1)->is_talkto);
    }

    public function test_general_settings_loader_toggle()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.generalsettings.isLoader', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_loader);

        $response = $this->get(route('admin.generalsettings.isLoader', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_loader);
    }

    public function test_general_settings_disqus_toggle()
    {
        $this->authenticateAdmin();
        $this->get(route('admin.generalsettings.disqus', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_disqus);

        $this->get(route('admin.generalsettings.disqus', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_disqus);
    }

    public function test_general_settings_smtp_toggle()
    {
        $this->authenticateAdmin();
        $this->get(route('admin.generalsettings.smtp', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_smtp);

        $this->get(route('admin.generalsettings.smtp', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_smtp);
    }

    public function test_general_settings_capcha_toggle()
    {
        $this->authenticateAdmin();
        $this->get(route('admin.generalsettings.capcha', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_capcha);

        $this->get(route('admin.generalsettings.capcha', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_capcha);
    }

    public function test_general_settings_email_verification_toggle()
    {
        $this->authenticateAdmin();
        $this->get(route('admin.generalsettings.emailverfication', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_verification_email);

        $this->get(route('admin.generalsettings.emailverfication', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_verification_email);
    }

    public function test_general_settings_admin_loader_toggle()
    {
        $this->authenticateAdmin();
        $this->get(route('admin.generalsettings.isAdminLoader', 1));
        $this->assertEquals(1, GeneralSettings::find(1)->is_adminloader);

        $this->get(route('admin.generalsettings.isAdminLoader', 0));
        $this->assertEquals(0, GeneralSettings::find(1)->is_adminloader);
    }

    // ==================== 17. ImageAlbumController ====================

    public function test_image_album_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.album.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-album.index');
    }

    public function test_image_album_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.album.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_image_album_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.album.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-album.create');
    }

    public function test_image_album_store()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('image.album.store'), [
            'language_id' => 1,
            'album_name' => 'Nature Photos',
        ]);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('image_albums', ['album_name' => 'Nature Photos']);
    }

    public function test_image_album_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('image.album.store'), [
            'album_name' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_image_album_edit_page()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Albums']);
        $response = $this->get(route('image.album.edit', $album->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-album.edit');
    }

    public function test_image_album_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Old Album']);
        $response = $this->post(route('image.album.update', $album->id), [
            'language_id' => 1,
            'album_name' => 'Updated Album',
        ]);
        $response->assertSee('Data Updated Successfully');
        $this->assertEquals('Updated Album', $album->fresh()->album_name);
    }

    public function test_image_album_delete()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Delete Album']);
        $response = $this->get(route('image.album.delete', $album->id));
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('image_albums', ['id' => $album->id]);
    }

    // ==================== 18. ImageCategoryController ====================

    public function test_image_category_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.category.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-category.index');
    }

    public function test_image_category_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.category.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_image_category_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.category.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-category.create');
    }

    public function test_image_category_by_language()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Test Album']);
        $response = $this->get(route('image.categoryByLanguage', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Test Album', $response->original);
    }

    public function test_image_category_store()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album for Cat']);
        $response = $this->post(route('image.category.store'), [
            'language_id' => 1,
            'image_album_id' => $album->id,
            'name' => 'Travel',
        ]);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('image_categories', ['name' => 'Travel']);
    }

    public function test_image_category_edit_page()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album E']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Edit Cat']);
        $response = $this->get(route('image.category.edit', $cat->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-category.edit');
    }

    public function test_image_category_language_on_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album LU']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Lang Update']);
        $response = $this->get(route('image.languageOnUpdate', [1, $cat->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Album LU', $response->original);
    }

    public function test_image_category_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album U']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Old Cat']);
        $response = $this->post(route('image.category.update', $cat->id), [
            'language_id' => 1,
            'image_album_id' => $album->id,
            'name' => 'New Cat',
        ]);
        $response->assertSee('Data Updated Successfully');
        $this->assertEquals('New Cat', $cat->fresh()->name);
    }

    public function test_image_category_delete()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album D']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Delete Cat']);
        $response = $this->get(route('image.category.delete', $cat->id));
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('image_categories', ['id' => $cat->id]);
    }

    // ==================== 19. ImageGalleryController ====================

    public function test_image_gallery_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.gallery.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-gallery.index');
    }

    public function test_image_gallery_datatables()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Gallery Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Gallery Cat']);
        ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'test.jpg',
        ]);
        $response = $this->get(route('image.gallery.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_image_gallery_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('image.gallery.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-gallery.create');
    }

    public function test_image_gallery_album_by_language()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Gallery Album']);
        $response = $this->get(route('gallery.albumByLanguage', 1));
        $response->assertStatus(200);
        $this->assertStringContainsString('Gallery Album', $response->original);
    }

    public function test_image_gallery_category_by_album()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album Cat']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Gallery Cat']);
        $response = $this->get(route('gallery.categoryByAlbum', $album->id));
        $response->assertStatus(200);
        $this->assertStringContainsString('Gallery Cat', $response->original);
    }

    public function test_image_gallery_store()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Store Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Store Cat']);
        $response = $this->post(route('image.gallery.store'), [
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
        ]);
        $response->assertSee('Data Added Successfully');
    }

    public function test_image_gallery_manage_page()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Manage Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Manage Cat']);
        $response = $this->get(route('image.gallery.manage', [$album->id, $cat->id]));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-gallery.manage');
    }

    public function test_image_gallery_add_more_page()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'AddMore Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'AddMore Cat']);
        $response = $this->get(route('image.gallery.add.more', [$album->id, $cat->id]));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-gallery.add-more');
    }

    public function test_image_gallery_delete_group()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'DelGroup Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'DelGroup Cat']);
        ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'img1.jpg',
        ]);
        ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'img2.jpg',
        ]);
        $response = $this->get(route('image.gallery.delete.group', [$album->id, $cat->id]));
        $response->assertSee('All Images Deleted Successfully');
        $this->assertEquals(0, ImageGallery::where('image_album_id', $album->id)->where('image_category_id', $cat->id)->count());
    }

    public function test_image_gallery_album_by_language_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album LU']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Cat LU']);
        $gallery = ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'lu.jpg',
        ]);
        $response = $this->get(route('gallery.albumByLanguageUpdate', [1, $gallery->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Album LU', $response->original);
    }

    public function test_image_gallery_category_by_album_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Album CU']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Cat CU']);
        $gallery = ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'cu.jpg',
        ]);
        $response = $this->get(route('gallery.categoryByAlbumUpdate', [$album->id, $gallery->id]));
        $response->assertStatus(200);
        $this->assertStringContainsString('Cat CU', $response->original);
    }

    public function test_image_gallery_edit_page()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Edit Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Edit Cat']);
        $gallery = ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'edit.jpg',
        ]);
        $response = $this->get(route('image.gallery.edit', $gallery->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.image-gallery.edit');
    }

    public function test_image_gallery_update()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Upd Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Upd Cat']);
        $gallery = ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'old.jpg',
        ]);
        $response = $this->post(route('image.gallery.update', $gallery->id), [
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
        ]);
        $response->assertSee('Data Updated Successfully');
    }

    public function test_image_gallery_delete()
    {
        $this->authenticateAdmin();
        $album = ImageAlbum::create(['language_id' => 1, 'album_name' => 'Del Album']);
        $cat = ImageCategory::create(['language_id' => 1, 'image_album_id' => $album->id, 'name' => 'Del Cat']);
        $gallery = ImageGallery::create([
            'language_id' => 1,
            'image_album_id' => $album->id,
            'image_category_id' => $cat->id,
            'gallery' => 'delete.jpg',
        ]);
        $response = $this->get(route('image.gallery.delete', $gallery->id));
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('image_galleries', ['id' => $gallery->id]);
    }

    // ==================== 20. LanguageController ====================

    public function test_language_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.language.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.language.index');
    }

    public function test_language_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('language.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_language_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.language.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.language.create');
    }

    public function test_language_edit_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.language.edit', 1));
        $response->assertStatus(200);
        $response->assertViewIs('admin.language.edit');
    }

    public function test_language_status_toggle()
    {
        $lang2 = Language::create([
            'language' => 'Bangla',
            'name' => 'bn',
            'file' => 'bn.json',
            'rtl' => 0,
            'is_default' => 0,
        ]);
        $this->authenticateAdmin();
        $response = $this->post(route('admin.language.status', $lang2->id));
        $response->assertRedirect();
        $this->assertEquals(1, $lang2->fresh()->is_default);
        $this->assertEquals(0, $this->language->fresh()->is_default);
    }

    public function test_language_delete_protected_first()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.language.delete', 1));
        $response->assertSee("don't have access", false);
    }

    public function test_language_delete_with_relations()
    {
        $lang2 = Language::create([
            'language' => 'French',
            'name' => 'fr',
            'file' => 'fr.json',
            'rtl' => 0,
            'is_default' => 0,
        ]);
        $this->authenticateAdmin();
        $response = $this->get(route('admin.language.delete', $lang2->id));
        $response->assertSee('Data Deleted Successfully.');
        $this->assertDatabaseMissing('languages', ['id' => $lang2->id]);
    }

    // ==================== 21. LogoController ====================

    public function test_logo_index()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.languagelogo.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.logo.index');
    }

    public function test_logo_datatables()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.languagelogo.datatables'));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_logo_create_page()
    {
        $this->authenticateAdmin();
        $response = $this->get(route('admin.languagelogo.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.logo.create');
    }

    public function test_logo_store()
    {
        $this->authenticateAdmin();
        Language::create([
            'language' => 'Spanish',
            'name' => 'es',
            'file' => 'es.json',
            'rtl' => 0,
            'is_default' => 0,
        ]);
        $response = $this->post(route('admin.languagelogo.store'), [
            'language_id' => 2,
        ]);
        $response->assertSee('Data added successfully');
        $this->assertDatabaseHas('logos', ['language_id' => 2]);
    }

    public function test_logo_store_validation_fails()
    {
        $this->authenticateAdmin();
        $response = $this->post(route('admin.languagelogo.store'), [
            'language_id' => '',
        ]);
        $response->assertJsonStructure(['errors']);
    }

    public function test_logo_edit_page()
    {
        $this->authenticateAdmin();
        $logo = Logo::create(['language_id' => 2]);
        $response = $this->get(route('admin.languagelogo.edit', $logo->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.logo.edit');
    }

    public function test_logo_update()
    {
        $this->authenticateAdmin();
        $logo = Logo::create(['language_id' => 2]);
        $response = $this->post(route('admin.languagelogo.update', $logo->id), [
            'language_id' => 2,
        ]);
        $response->assertSee('Data updated successfully');
    }

    public function test_logo_delete()
    {
        $this->authenticateAdmin();
        $logo = Logo::create(['language_id' => 2]);
        $response = $this->get(route('admin.languagelogo.delete', $logo->id));
        $response->assertSee('Data updated successfully');
        $this->assertDatabaseMissing('logos', ['id' => $logo->id]);
    }
}
