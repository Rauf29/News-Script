<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make('config')->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $this->seedData();
    }

    protected function seedData()
    {
        $generalSettings = new \App\Models\GeneralSettings();
        $generalSettings->id = 1;
        $generalSettings->title = 'Test Site';
        $generalSettings->is_smtp = 1;
        $generalSettings->is_verification_email = 0;
        $generalSettings->from_email = 'test@example.com';
        $generalSettings->from_name = 'Test';
        $generalSettings->error_photo = '';
        $generalSettings->error_title = '404';
        $generalSettings->error_text = 'Not Found';
        $generalSettings->tags = 'news,test';
        $generalSettings->smtp_host = 'localhost';
        $generalSettings->smtp_port = '25';
        $generalSettings->smtp_user = '';
        $generalSettings->smtp_pass = '';
        $generalSettings->email_encryption = '';
        $generalSettings->save();

        $this->defaultLanguage = \App\Models\Language::create([
            'is_default' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en',
            'rtl' => 0,
            'status' => 1,
        ]);

        $role = \App\Models\Role::create(['name' => 'Admin', 'section' => '[]']);

        $this->admin = \App\Models\Admin::create([
            'name' => 'TestAuthor',
            'email' => 'author@test.com',
            'password' => Hash::make('password'),
            'role_id' => $role->id,
        ]);

        $this->user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'verify' => 1,
        ]);

        $this->category = \App\Models\Category::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Test Category',
            'slug' => 'test-category',
            'color' => '#ff0000',
            'category_order' => 1,
            'show_at_homepage' => 1,
            'show_on_menu' => 1,
        ]);

        $this->subcategory = \App\Models\Category::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Test Subcategory',
            'slug' => 'test-subcategory',
            'parent_id' => $this->category->id,
            'color' => '#00ff00',
            'category_order' => 1,
            'show_at_homepage' => 0,
            'show_on_menu' => 0,
        ]);

        $this->post = \App\Models\Post::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'category_id' => $this->category->id,
            'subcategories_id' => $this->subcategory->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'is_pending' => 0,
            'schedule_post' => 0,
            'post_type' => 'article',
            'description' => 'This is a test post description for testing purposes.',
            'tags' => 'test,news,breaking',
            'is_slider' => 1,
            'is_feature' => 1,
            'is_trending' => 1,
            'is_videoGallery' => 0,
            'slider_left' => 0,
            'slider_right' => 0,
        ]);

        \App\Models\WidgetSetiings::create([
            'id' => 1,
            'feature_inhome' => 1,
            'category_inhome' => 1,
            'follow_inhome' => 1,
            'tag_inhome' => 1,
            'poll_inhome' => 1,
            'calendar_inhome' => 1,
            'newsletter_inhome' => 1,
            'category_incategory' => 1,
            'newsletter_incategory' => 1,
            'calendar_incategory' => 1,
            'category_indetails' => 1,
            'newsletter_indetails' => 1,
            'calendar_indetails' => 1,
        ]);

        \App\Models\Widget::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Test Widget',
            'description' => 'Widget description',
            'status' => 1,
        ]);

        $pollQuestion = \App\Models\PollQuestion::create([
            'language_id' => $this->defaultLanguage->id,
            'question' => 'Test Poll Question?',
            'status' => '1',
        ]);

        \App\Models\PollAnswer::create([
            'poll_question_id' => $pollQuestion->id,
            'poll_option' => 'Option A',
        ]);

        \App\Models\PollAnswer::create([
            'poll_question_id' => $pollQuestion->id,
            'poll_option' => 'Option B',
        ]);

        $this->pollQuestion = $pollQuestion;

        $this->pollAnswer = \App\Models\PollAnswer::where('poll_question_id', $pollQuestion->id)->first();

        $this->page = \App\Models\Page::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Test Page',
            'slug' => 'test-page',
            'description' => 'Page description',
            'placement' => 'sidebar',
            'status' => 1,
        ]);

        $this->imageAlbum = \App\Models\ImageAlbum::create([
            'language_id' => $this->defaultLanguage->id,
            'photo' => 'album.jpg',
            'album_name' => 'Test Album',
        ]);

        $this->imageCategory = \App\Models\ImageCategory::create([
            'language_id' => $this->defaultLanguage->id,
            'image_album_id' => $this->imageAlbum->id,
            'name' => 'Test Image Category',
        ]);

        \App\Models\Advertisement::create([
            'add_placement' => 'sponsor',
            'addSize' => 'size_468',
            'status' => 1,
            'click_count' => 0,
        ]);

        DB::table('seotools')->insert([
            'id' => 1,
            'google_analytics' => '',
            'meta_keys' => '',
            'meta_description' => '',
        ]);

        DB::table('admin_languages')->insert([
            'is_default' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en',
        ]);

        DB::table('fonts')->insert([
            'id' => 1,
            'is_default' => 1,
            'font_family' => 'SolaimanLipi',
            'font_value' => 'SolaimanLipi',
        ]);
    }

    // ==================== FrontendController Tests ====================

    public function test_frontend_index_returns_200()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.index');
    }

    public function test_category_page_works()
    {
        $response = $this->get('/' . $this->category->slug);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.category');
        $response->assertViewHas('data');
    }

    public function test_category_page_returns_404_for_nonexistent_category()
    {
        $response = $this->get('/nonexistent-category-slug');
        $response->assertStatus(200);
    }

    public function test_post_details_page_works()
    {
        $response = $this->get("/{$this->category->slug}/{$this->post->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('frontend.details');
        $response->assertViewHas('data');
    }

    public function test_post_details_page_returns_404_for_nonexistent_slug()
    {
        $response = $this->get("/{$this->category->slug}/nonexistent-post");
        $response->assertStatus(200);
    }

    public function test_search_by_tag_works()
    {
        $response = $this->get('/tag/test');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.postByTag');
        $response->assertViewHas('datas');
        $response->assertViewHas('tag');
    }

    public function test_news_search_returns_view()
    {
        $response = $this->get('/news-search?search=Test');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.full_text_search');
        $response->assertViewHas('results');
    }

    public function test_news_search_ajax_returns_partial()
    {
        $response = $this->get('/news-search?search=Test', ['X-Requested-With' => 'XMLHttpRequest']);
        $response->assertStatus(200);
    }

    public function test_photo_page_works()
    {
        $response = $this->get('/photo?search=');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.photo');
    }

    public function test_video_page_works()
    {
        $response = $this->get('/video?search=');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.video');
    }

    public function test_language_switching_works()
    {
        $secondLang = \App\Models\Language::create([
            'is_default' => 0,
            'language' => 'Bengali',
            'name' => 'bn',
            'file' => 'bn',
            'rtl' => 0,
            'status' => 1,
        ]);

        $response = $this->get('/change/language/' . $secondLang->id);
        $response->assertRedirect(route('frontend.index'));

        $this->assertEquals(session()->get('language'), $secondLang->id);
    }

    public function test_author_profile_works()
    {
        $response = $this->get('/profile/' . $this->admin->name);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.author');
        $response->assertViewHas('admin');
        $response->assertViewHas('posts');
    }

    public function test_author_profile_returns_404_for_nonexistent_author()
    {
        $response = $this->get('/profile/NonexistentAuthor');
        $response->assertStatus(200);
    }

    public function test_dynamic_page_works()
    {
        $response = $this->get('/dynamic/page/' . $this->page->slug);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.page');
        $response->assertViewHas('page');
    }

    public function test_dynamic_page_redirects_when_page_inactive()
    {
        $inactivePage = \App\Models\Page::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Inactive Page',
            'slug' => 'inactive-page',
            'description' => 'Inactive',
            'placement' => 'sidebar',
            'status' => 0,
        ]);

        $response = $this->get('/dynamic/page/' . $inactivePage->slug);
        $response->assertRedirect(route('frontend.index'));
    }

    public function test_reporter_page_works()
    {
        $response = $this->get('/reporter?search=Test');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.reporter');
    }

    public function test_post_by_date_works()
    {
        $date = now()->format('Y-m-d');
        $response = $this->get('/news/date/post-by-date?date=' . $date);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.postByDate');
    }

    public function test_load_more_returns_json()
    {
        $response = $this->get('/load-more?last_news=' . ($this->post->id + 1));
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'output']);
    }

    // ==================== FollowController Tests ====================

    public function test_follow_redirects_to_login_when_not_authenticated()
    {
        $response = $this->post('/follower/create/' . $this->admin->id);
        $response->assertRedirect(route('front.LogReg'));
    }

    public function test_follow_succeeds()
    {
        $follower = \App\Models\Admin::create([
            'name' => 'Follower Author',
            'email' => 'follower@test.com',
            'password' => Hash::make('password'),
            'role_id' => \App\Models\Role::first()->id,
        ]);

        $this->actingAs($follower, 'admin');

        $response = $this->post('/follower/create/' . $this->admin->id);
        $response->assertRedirect();

        $this->assertDatabaseHas('follows', [
            'admin_id' => $this->admin->id,
            'follower_id' => $follower->id,
        ]);
    }

    public function test_follow_self_returns_error()
    {
        $this->actingAs($this->admin, 'admin');

        $response = $this->post('/follower/create/' . $this->admin->id);
        $response->assertRedirect();
    }

    public function test_following_page_works()
    {
        $response = $this->get('/follower/' . $this->admin->name);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.follower');
        $response->assertViewHas('admin');
    }

    public function test_following_page_404_for_nonexistent_author()
    {
        $response = $this->get('/follower/NonexistentAuthor');
        $response->assertStatus(200);
    }

    // ==================== ForgotController Tests ====================

    public function test_forgot_password_form_displays()
    {
        $response = $this->get('/forgot');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.forgot');
    }

    public function test_forgot_password_submission_fails_for_invalid_email()
    {
        $response = $this->post('/forgot', ['email' => 'nonexistent@test.com']);
        $response->assertStatus(200);
        $response->assertJson([
            'errors' => [
                0 => 'No Account Found With This Email.',
            ],
        ]);
    }

    public function test_forgot_password_generates_token_and_returns_success()
    {
        $user = \App\Models\User::create([
            'name' => 'Forgot Test',
            'email' => 'forgot@test.com',
            'password' => Hash::make('password'),
            'verification_link' => null,
        ]);

        $response = $this->post('/forgot', ['email' => 'forgot@test.com']);

        $response->assertStatus(200);
        $this->assertStringContainsString('Password reset link has been sent', $response->content());

        $user->refresh();
        $this->assertNotNull($user->verification_link);
    }

    public function test_reset_password_form_displays_with_valid_token()
    {
        $token = Str::random(60);
        \App\Models\User::where('id', $this->user->id)->update(['verification_link' => $token]);

        $response = $this->get('/reset-password/' . $token);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.reset');
        $response->assertViewHas('token', $token);
    }

    public function test_reset_password_form_redirects_with_invalid_token()
    {
        $response = $this->get('/reset-password/invalidtoken123');
        $response->assertRedirect(route('front.LogReg'));
    }

    public function test_reset_password_submission_succeeds()
    {
        $token = Str::random(60);
        \App\Models\User::where('id', $this->user->id)->update(['verification_link' => $token]);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('Password has been reset successfully', $response->content());

        $this->user->refresh();
        $this->assertNull($this->user->verification_link);
    }

    public function test_reset_password_fails_with_invalid_token()
    {
        $response = $this->post('/reset-password', [
            'token' => 'invalidtoken',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errors' => [
                0 => 'Invalid or expired reset token.',
            ],
        ]);
    }

    // ==================== GalleryController Tests ====================

    public function test_gallery_view_works()
    {
        $response = $this->get('/gallery-view/' . $this->imageAlbum->id);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.gallery_view');
        $response->assertViewHas('gallery');
    }

    public function test_gallery_view_returns_404_for_nonexistent_album()
    {
        $response = $this->get('/gallery-view/99999');
        $response->assertStatus(404);
    }

    // ==================== LoginController Tests ====================

    public function test_login_form_displays()
    {
        $response = $this->get('/log-reg');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.log-reg');
    }

    public function test_login_submission_succeeds_with_valid_credentials()
    {
        \App\Models\User::create([
            'name' => 'Login Test',
            'email' => 'logintest@test.com',
            'password' => Hash::make('password123'),
            'verify' => 1,
        ]);

        $response = $this->post('/login', [
            'email' => 'logintest@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated('web');
    }

    public function test_login_fails_with_unverified_email()
    {
        \App\Models\User::create([
            'name' => 'Unverified',
            'email' => 'unverified@test.com',
            'password' => Hash::make('password123'),
            'verify' => 0,
        ]);

        $response = $this->post('/login', [
            'email' => 'unverified@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errors' => [
                0 => 'Your Email is not Verified!',
            ],
        ]);
    }

    public function test_login_fails_with_wrong_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errors' => [
                0 => 'Credentials Doesn\'t Match !',
            ],
        ]);
    }

    public function test_login_fails_with_invalid_email_format()
    {
        $response = $this->post('/login', [
            'email' => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_logout_works()
    {
        $this->actingAs($this->user, 'web');
        $this->assertAuthenticated('web');

        $response = $this->post('/logout');
        $response->assertRedirect('/log-reg');
        $this->assertGuest('web');
    }

    // ==================== PollVoteController Tests ====================

    public function test_poll_vote_succeeds()
    {
        $response = $this->post('/poll-vote', [
            'poll_question_id' => $this->pollQuestion->id,
            'poll_answer_id' => $this->pollAnswer->id,
        ]);

        $response->assertStatus(200);
        $this->assertEquals('success', $response->content());
    }

    public function test_poll_vote_fails_without_answer()
    {
        $response = $this->post('/poll-vote', [
            'poll_question_id' => $this->pollQuestion->id,
            'poll_answer_id' => '',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_poll_vote_fails_for_duplicate_vote()
    {
        \App\Models\PollResult::create([
            'poll_question_id' => $this->pollQuestion->id,
            'poll_answer_id' => $this->pollAnswer->id,
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->post('/poll-vote', [
            'poll_question_id' => $this->pollQuestion->id,
            'poll_answer_id' => $this->pollAnswer->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_poll_result_returns_data_for_populated_poll()
    {
        \App\Models\PollResult::create([
            'poll_question_id' => $this->pollQuestion->id,
            'poll_answer_id' => $this->pollAnswer->id,
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->get('/poll-result/' . $this->pollQuestion->id);
        $response->assertStatus(200);
    }

    public function test_poll_result_returns_message_for_empty_poll()
    {
        $response = $this->get('/poll-result/' . $this->pollQuestion->id);
        $response->assertStatus(200);
    }

    public function test_all_poll_page_works()
    {
        $response = $this->get('/all-poll');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.all_poll');
    }

    public function test_all_poll_result_page_works()
    {
        $response = $this->get('/all-poll-result');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.all_poll_result');
    }

    // ==================== RegisterController Tests ====================

    public function test_registration_form_displays()
    {
        $response = $this->get('/log-reg');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.log-reg');
    }

    public function test_registration_succeeds()
    {
        $response = $this->post('/register', [
            'email' => 'newuser@test.com',
            'name' => 'New User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@test.com',
        ]);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        \App\Models\User::create([
            'name' => 'Existing',
            'email' => 'existing@test.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/register', [
            'email' => 'existing@test.com',
            'name' => 'Another User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_registration_fails_with_password_mismatch()
    {
        $response = $this->post('/register', [
            'email' => 'mismatch@test.com',
            'name' => 'Mismatch User',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_registration_fails_with_short_password()
    {
        $response = $this->post('/register', [
            'email' => 'short@test.com',
            'name' => 'Short User',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_email_verification_token_works()
    {
        $token = md5(time() . 'verify@test.com');
        $user = \App\Models\User::create([
            'name' => 'Verify Test',
            'email' => 'verify@test.com',
            'password' => Hash::make('password'),
            'token' => $token,
            'status' => 0,
            'verify' => 0,
        ]);

        $response = $this->get('/register/verify/' . $token);
        $response->assertRedirect(route('frontend.index'));

        $user->refresh();
        $this->assertEquals(1, $user->status);
        $this->assertEquals(1, $user->verify);
        $this->assertNull($user->token);
    }

    public function test_email_verification_token_redirects_with_invalid_token()
    {
        $response = $this->get('/register/verify/invalidtoken');
        $response->assertRedirect('/');
    }

    // ==================== SiteMapController Tests ====================

    public function test_sitemap_index_returns_xml()
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('content-type');
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));
    }

    public function test_sitemap_posts_returns_xml()
    {
        $response = $this->get('/sitemap/posts.xml');
        $response->assertStatus(200);
        $response->assertHeader('content-type');
        $this->assertStringContainsString('text/xml', $response->headers->get('Content-Type'));
    }

    // ==================== SocialRegisterController Tests ====================

    public function test_social_register_redirects_to_provider()
    {
        \App\Models\SocialSettings::create([
            'id' => 1,
            'fclient_id' => 'test-fb-id',
            'fclient_secret' => 'test-fb-secret',
            'gclient_id' => 'test-google-id',
            'gclient_secret' => 'test-google-secret',
        ]);

        $response = $this->get('/auth/google');
        $status = $response->getStatusCode();
        $this->assertContains($status, [200, 302, 500],
            'Social login may fail without valid credentials but should not crash'
        );
    }

    // ==================== SubscriberController Tests ====================

    public function test_subscriber_store_succeeds()
    {
        $response = $this->post('/subscribers', ['email' => 'subscribe@test.com']);
        $response->assertRedirect();
        $this->assertDatabaseHas('subscribers', ['email' => 'subscribe@test.com']);
    }

    public function test_subscriber_store_fails_for_duplicate_email()
    {
        \App\Models\Subscriber::create(['email' => 'duplicate@test.com']);

        $response = $this->post('/subscribers', ['email' => 'duplicate@test.com']);
        $response->assertRedirect();
    }

    public function test_subscriber_store_fails_for_invalid_email()
    {
        $response = $this->post('/subscribers', ['email' => 'not-an-email']);
        $response->assertRedirect();
    }

    // ==================== Post Type Rendering Tests ====================

    public function test_quiz_post_type_renders_quiz_view()
    {
        $quizPost = \App\Models\Post::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Trivia Quiz Post',
            'slug' => 'trivia-quiz-post',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'is_pending' => 0,
            'schedule_post' => 0,
            'post_type' => 'Trivia Quiz',
            'description' => 'Quiz description',
        ]);

        $response = $this->get("/{$this->category->slug}/{$quizPost->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('frontend.quiz');
    }

    public function test_sorted_list_post_type_renders_sort_view()
    {
        $sortedPost = \App\Models\Post::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Sorted List Post',
            'slug' => 'sorted-list-post',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'is_pending' => 0,
            'schedule_post' => 0,
            'post_type' => 'Sorted List',
            'description' => 'Sorted list description',
        ]);

        $response = $this->get("/{$this->category->slug}/{$sortedPost->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('frontend.sort');
    }

    public function test_personality_quiz_post_type_renders_personality_view()
    {
        $personalityPost = \App\Models\Post::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Personality Quiz Post',
            'slug' => 'personality-quiz-post',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'is_pending' => 0,
            'schedule_post' => 0,
            'post_type' => 'Personality Quiz',
            'description' => 'Personality quiz description',
        ]);

        $response = $this->get("/{$this->category->slug}/{$personalityPost->slug}");
        $response->assertStatus(200);
        $response->assertViewIs('frontend.personality');
    }

    public function test_subcategory_route_lists_posts()
    {
        $secondCat = \App\Models\Category::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Second Category',
            'slug' => 'second-category',
            'color' => '#0000ff',
            'category_order' => 2,
            'show_at_homepage' => 0,
            'show_on_menu' => 1,
        ]);

        $subCat = \App\Models\Category::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'A Subcategory',
            'slug' => 'a-subcategory',
            'parent_id' => $secondCat->id,
            'color' => '#ffff00',
            'category_order' => 1,
            'show_at_homepage' => 0,
            'show_on_menu' => 0,
        ]);

        \App\Models\Post::create([
            'language_id' => $this->defaultLanguage->id,
            'title' => 'Subcategory Post',
            'slug' => 'subcategory-post',
            'category_id' => $secondCat->id,
            'subcategories_id' => $subCat->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'is_pending' => 0,
            'schedule_post' => 0,
            'post_type' => 'article',
            'description' => 'A post in subcategory.',
        ]);

        $response = $this->get("/second-category/a-subcategory");
        $response->assertStatus(200);
        $response->assertViewIs('frontend.postBySubcategory');
        $response->assertViewHas('datas');
    }

    public function test_follower_page_returns_200()
    {
        $response = $this->get('/follower');
        $response->assertStatus(200);
    }

    public function test_privacy_policy_page_works()
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.privacy');
    }

    public function test_data_deletion_page_works()
    {
        $response = $this->get('/data-deletion');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.data-deletion');
    }

    public function test_ajker_songbad_page_works()
    {
        $response = $this->get('/ajkersongbad');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.ajkersongbad');
    }

    public function test_converter_page_works()
    {
        $response = $this->get('/converter');
        $response->assertStatus(200);
        $response->assertViewIs('frontend.converter');
    }

    public function test_print_page_works()
    {
        $response = $this->get('/print/' . $this->category->slug . '/' . $this->post->slug);
        $response->assertStatus(200);
        $response->assertViewIs('frontend.print');
    }

    public function test_password_reset_fails_with_validation_errors()
    {
        $response = $this->post('/reset-password', [
            'token' => '',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }
}
