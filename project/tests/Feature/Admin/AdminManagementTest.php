<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Language;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\PollQuestion;
use App\Models\PollAnswer;
use App\Models\Widget;
use App\Models\WidgetSetiings;
use App\Models\SocialLink;
use App\Models\SocialSettings;
use App\Models\Seo;
use App\Models\Rss;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\GeneralSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $role;
    protected $language;
    protected $category;
    protected $subcategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make('config')->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        $this->role = Role::create(['name' => 'admin', 'section' => json_encode([
            'menu_builder', 'categories', 'add_post', 'posts', 'schedule_post', 'drafts',
            'rss_feeds', 'languages', 'polls', 'widgets', 'create_ads', 'add_gallery',
            'general_settings', 'seo_tools', 'social_settings', 'pages', 'emails_settings',
            'newsLetter', 'role_management', 'user_management', 'administration_management',
            'site_map', 'font_option', 'cache_management',
        ])]);

        $this->admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role_id' => $this->role->id,
            'phone' => '1234567890',
        ]);

        $this->language = Language::create([
            'is_default' => 1,
            'language' => 'English',
            'name' => 'english',
            'file' => 'en',
            'rtl' => 0,
            'status' => 1,
        ]);

        $this->category = Category::create([
            'language_id' => $this->language->id,
            'title' => 'Test Category',
            'slug' => 'test-category',
            'parent_id' => null,
            'category_order' => 0,
            'show_on_menu' => 1,
        ]);

        $this->subcategory = Category::create([
            'language_id' => $this->language->id,
            'title' => 'Test SubCategory',
            'slug' => 'test-subcategory',
            'parent_id' => $this->category->id,
            'category_order' => 0,
            'show_on_menu' => 1,
        ]);

        GeneralSettings::create(['id' => 1, 'title' => 'Test Site', 'time_zone' => 'Asia/Dhaka']);
        Seo::create(['id' => 1]);
        SocialSettings::create(['id' => 1]);
        WidgetSetiings::create(['id' => 1]);

        DB::table('admin_languages')->insert([
            'is_default' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en',
        ]);

        $this->actingAs($this->admin, 'admin');
    }

    public function test_guest_cannot_access_admin_routes()
    {
        auth('admin')->logout();
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.loginForm'));
    }

    // ==================== MenuBuilderController ====================

    public function test_menu_builder_index()
    {
        $response = $this->get(route('admin.menu.builder'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.menu-builder.index');
    }

    public function test_menu_builder_store_ordering()
    {
        $cat1 = Category::create([
            'language_id' => $this->language->id,
            'title' => 'Cat 1',
            'slug' => 'cat-1',
            'parent_id' => null,
            'category_order' => 0,
        ]);
        $cat2 = Category::create([
            'language_id' => $this->language->id,
            'title' => 'Cat 2',
            'slug' => 'cat-2',
            'parent_id' => null,
            'category_order' => 0,
        ]);

        $response = $this->post(route('admin.menu.builder.store'), [
            'category_id_array' => [$cat2->id, $cat1->id],
        ]);

        $response->assertStatus(200);
        $this->assertEquals(0, Category::find($cat2->id)->category_order);
        $this->assertEquals(1, Category::find($cat1->id)->category_order);
    }

    public function test_menu_builder_store_invalid_data()
    {
        $response = $this->post(route('admin.menu.builder.store'), [
            'category_id_array' => 'not-an-array',
        ]);
        $response->assertJson(['error' => 'Invalid category data']);
    }

    // ==================== PageController ====================

    public function test_page_index()
    {
        $response = $this->get(route('admin.page.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.page.index');
    }

    public function test_page_create()
    {
        $response = $this->get(route('admin.page.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.page.create');
    }

    public function test_page_store()
    {
        $response = $this->post(route('admin.page.store'), [
            'language_id' => $this->language->id,
            'title' => 'Test Page',
            'slug' => 'test-page',
            'description' => 'Test page description',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('pages', ['slug' => 'test-page']);
    }

    public function test_page_store_validation_fails()
    {
        $response = $this->post(route('admin.page.store'), []);
        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_page_edit()
    {
        $page = Page::create([
            'language_id' => $this->language->id,
            'title' => 'Edit Page',
            'slug' => 'edit-page',
            'description' => 'Edit description',
        ]);

        $response = $this->get(route('admin.page.edit', $page->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.page.edit');
    }

    public function test_page_update()
    {
        $page = Page::create([
            'language_id' => $this->language->id,
            'title' => 'Old Title',
            'slug' => 'old-slug',
            'description' => 'Old description',
        ]);

        $response = $this->post(route('admin.page.update', $page->id), [
            'language_id' => $this->language->id,
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('pages', ['title' => 'Updated Title']);
    }

    public function test_page_delete()
    {
        $page = Page::create([
            'language_id' => $this->language->id,
            'title' => 'Delete Page',
            'slug' => 'delete-page',
            'description' => 'Delete description',
        ]);

        $response = $this->get(route('admin.page.delete', $page->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_page_slug_create()
    {
        $response = $this->get(route('admin.page.slugCreate') . '?title=Hello World');
        $response->assertStatus(200);
        $this->assertEquals('Hello-World', $response->getContent());
    }

    // ==================== PendingController ====================

    public function test_pending_index()
    {
        $response = $this->get(route('pending.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pending.index');
    }

    public function test_pending_category_filter()
    {
        $response = $this->get(route('pending.categoryFilter.language', $this->language->id));
        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    // ==================== PollController ====================

    public function test_poll_index()
    {
        $response = $this->get(route('addPolls.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.polls.index');
    }

    public function test_poll_create()
    {
        $response = $this->get(route('addPolls.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.polls.create');
    }

    public function test_poll_store()
    {
        $response = $this->post(route('addPolls.store'), [
            'language_id' => $this->language->id,
            'question' => 'Test Poll Question?',
            'status' => 1,
            'poll_option' => ['Option A', 'Option B', 'Option C'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('poll_questions', ['question' => 'Test Poll Question?']);
        $this->assertDatabaseHas('poll_answers', ['poll_option' => 'Option A']);
        $this->assertDatabaseHas('poll_answers', ['poll_option' => 'Option B']);
    }

    public function test_poll_store_validation_fails()
    {
        $response = $this->post(route('addPolls.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_poll_edit()
    {
        $poll = PollQuestion::create([
            'language_id' => $this->language->id,
            'question' => 'Edit Poll?',
            'status' => 1,
        ]);

        $response = $this->get(route('addPolls.edit', $poll->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.polls.edit');
    }

    public function test_poll_update()
    {
        $poll = PollQuestion::create([
            'language_id' => $this->language->id,
            'question' => 'Old Question?',
            'status' => 1,
        ]);
        PollAnswer::create(['poll_question_id' => $poll->id, 'poll_option' => 'Old Option']);

        $response = $this->post(route('addPolls.update', $poll->id), [
            'language_id' => $this->language->id,
            'question' => 'Updated Question?',
            'status' => 1,
            'poll_option' => ['New Option A', 'New Option B'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('poll_questions', ['question' => 'Updated Question?']);
        $this->assertDatabaseMissing('poll_answers', ['poll_option' => 'Old Option']);
    }

    public function test_poll_view()
    {
        $poll = PollQuestion::create([
            'language_id' => $this->language->id,
            'question' => 'View Poll?',
            'status' => 1,
        ]);

        $response = $this->get(route('pollOption.pollview', $poll->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.polls.view');
    }

    public function test_poll_show_on_homepage()
    {
        PollQuestion::create([
            'language_id' => $this->language->id,
            'question' => 'Active Poll?',
            'status' => 1,
            'end_date' => now()->addDays(1),
        ]);

        $response = $this->post(route('addPolls.showOnHomePage'));
        $response->assertStatus(302);
    }

    public function test_poll_delete()
    {
        $poll = PollQuestion::create([
            'language_id' => $this->language->id,
            'question' => 'Delete Poll?',
            'status' => 1,
        ]);
        PollAnswer::create(['poll_question_id' => $poll->id, 'poll_option' => 'Del Option']);

        $response = $this->get(route('addPolls.delete', $poll->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('poll_questions', ['id' => $poll->id]);
    }

    // ==================== PostController ====================

    public function test_post_index()
    {
        $response = $this->get(route('post.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.post.index');
    }

    public function test_post_edit()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Edit Post',
            'slug' => 'edit-post',
            'description' => 'Post description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('post.edit', $post->id));
        $response->assertStatus(200);
    }

    public function test_post_slider_change()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Slider Post',
            'slug' => 'slider-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_slider' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.sliderChange', $post->id));
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_slider);
    }

    public function test_post_trending_change()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Trending Post',
            'slug' => 'trending-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_trending' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.trendingChange', $post->id));
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_trending);
    }

    public function test_post_feature_change()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Feature Post',
            'slug' => 'feature-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_feature' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.feature', $post->id));
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_feature);
    }

    public function test_post_pending_change()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Pending Post',
            'slug' => 'pending-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.pendingChange', $post->id));
        $response->assertStatus(302);
        $this->assertEquals(0, $post->fresh()->is_pending);
    }

    public function test_post_sliderright_change()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Slider Right Post',
            'slug' => 'slider-right-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'slider_right' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.sliderright', $post->id));
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->slider_right);
    }

    public function test_post_bulk_slider()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Bulk Slider',
            'slug' => 'bulk-slider',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_slider' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.add.sliderBulk'), ['ids' => (string) $post->id]);
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_slider);
    }

    public function test_post_bulk_breaking()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Bulk Breaking',
            'slug' => 'bulk-breaking',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_trending' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.add.breakingBulk'), ['ids' => (string) $post->id]);
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_trending);
    }

    public function test_post_bulk_feature()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Bulk Feature',
            'slug' => 'bulk-feature',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_feature' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.add.feature'), ['ids' => (string) $post->id]);
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->is_feature);
    }

    public function test_post_bulk_right()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Bulk Right',
            'slug' => 'bulk-right',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'slider_right' => 0,
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.add.rightBulk'), ['ids' => (string) $post->id]);
        $response->assertStatus(302);
        $this->assertEquals(1, $post->fresh()->slider_right);
    }

    public function test_post_delete()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Delete Post',
            'slug' => 'delete-post',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('post.delete', $post->id));
        $response->assertStatus(200);
        $response->assertSee('Data Successfully Deleted');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_post_bulk_delete()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Bulk Delete',
            'slug' => 'bulk-delete',
            'description' => 'Description',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('post.bulkdelete'), ['ids' => (string) $post->id]);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_post_category_filter()
    {
        $response = $this->get(route('categoryFilter.language', $this->language->id));
        $response->assertStatus(200);
    }

    // ==================== PQuizController ====================

    public function test_pquiz_create()
    {
        $response = $this->get(route('pquiz.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.pquiz.create');
    }

    public function test_pquiz_store()
    {
        $response = $this->post(route('pquiz.store'), [
            'language_id' => $this->language->id,
            'title' => 'Personality Quiz',
            'slug' => 'personality-quiz',
            'description' => 'Quiz description',
            'category_id' => $this->category->id,
            'question_title' => ['1' => 'Question 1?'],
            'question_description' => ['1' => 'Q1 desc'],
            'result_title' => ['Result A'],
            'result_description' => ['Result A desc'],
            'answer_title' => [
                '2' => ['Yes', 'No'],
            ],
            'answer_option' => [
                '2' => ['result_1', 'result_1'],
            ],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'personality-quiz']);
    }

    public function test_pquiz_store_validation_fails()
    {
        $response = $this->post(route('pquiz.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_pquiz_remove_question()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'PQ Quiz',
            'slug' => 'pq-quiz',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $questionId = \DB::table('personality_questions')->insertGetId([
            'post_id' => $post->id,
            'question_title' => 'Remove Q?',
        ]);

        $response = $this->get(route('pquiz.removepquestion', $questionId));
        $response->assertStatus(200);
        $response->assertSee('Question Deleted Successfully');
        $this->assertDatabaseMissing('personality_questions', ['id' => $questionId]);
    }

    public function test_pquiz_remove_result()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'PQ Quiz Result',
            'slug' => 'pq-quiz-result',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $result = \App\Models\PersonalityResult::create([
            'post_id' => $post->id,
            'result_title' => 'Remove Result',
        ]);

        $response = $this->get(route('pquiz.removeresult', $result->id));
        $response->assertStatus(200);
        $response->assertSee('Result Deleted Successfully');
    }

    public function test_pquiz_remove_answer()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'PQ Answer',
            'slug' => 'pq-answer',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $questionId = \DB::table('personality_questions')->insertGetId([
            'post_id' => $post->id,
            'question_title' => 'Q?',
        ]);

        $answer = \App\Models\PersonalityAnswer::create([
            'personality_question_id' => $questionId,
            'answer_title' => 'Ans',
            'answer_option' => 'result_1',
        ]);

        $response = $this->get(route('pquiz.removeanswer', $answer->id));
        $response->assertStatus(200);
        $response->assertSee('Answer Deleted Successfully');
    }

    // ==================== QuisController (Trivia Quiz create view) ====================

    public function test_quis_create()
    {
        $response = $this->get(route('tquiz.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.quiz.create');
    }

    // ==================== RoleController ====================

    public function test_role_index()
    {
        $response = $this->get(route('admin.role.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.role.index');
    }

    public function test_role_create()
    {
        $response = $this->get(route('admin.role.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.role.create');
    }

    public function test_role_store()
    {
        $response = $this->post(route('admin.role.store'), [
            'name' => 'Editor',
            'section' => ['posts', 'pages'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('roles', ['name' => 'Editor']);
    }

    public function test_role_store_validation_fails()
    {
        $response = $this->post(route('admin.role.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_role_edit()
    {
        $role = Role::create(['name' => 'Editor', 'section' => json_encode(['posts'])]);

        $response = $this->get(route('admin.role.edit', $role->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.role.edit');
    }

    public function test_role_update()
    {
        $role = Role::create(['name' => 'Editor', 'section' => json_encode(['posts'])]);

        $response = $this->post(route('admin.role.update', $role->id), [
            'name' => 'Senior Editor',
            'section' => ['posts', 'pages', 'polls'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('roles', ['name' => 'Senior Editor']);
    }

    public function test_role_delete()
    {
        $role = Role::create(['name' => 'Temp Role', 'section' => json_encode(['posts'])]);

        $response = $this->get(route('admin.role.delete', $role->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_role_delete_with_users_fails()
    {
        $role = Role::create(['name' => 'Protected', 'section' => json_encode(['posts'])]);
        Admin::create([
            'name' => 'Assigned Admin',
            'email' => 'assigned@test.com',
            'password' => Hash::make('password'),
            'role_id' => $role->id,
            'phone' => '999',
        ]);

        $response = $this->get(route('admin.role.delete', $role->id));
        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    // ==================== RssFeedsController ====================

    public function test_rss_index()
    {
        $response = $this->get(route('rss.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rss.index');
    }

    public function test_rss_create()
    {
        $response = $this->get(route('rss.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rss.create');
    }

    public function test_rss_store()
    {
        $response = $this->post(route('rss.store'), [
            'language_id' => $this->language->id,
            'category_id' => $this->category->id,
            'feed_name' => 'Test Feed',
            'feed_url' => 'https://example.com/rss',
            'post_limit' => 5,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('rss_feeds', ['feed_name' => 'Test Feed']);
    }

    public function test_rss_store_validation_fails()
    {
        $response = $this->post(route('rss.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_rss_edit()
    {
        $rss = Rss::create([
            'language_id' => $this->language->id,
            'category_id' => $this->category->id,
            'feed_name' => 'Edit Feed',
            'feed_url' => 'https://example.com/rss',
            'post_limit' => 5,
        ]);

        $response = $this->get(route('rss.edit', $rss->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.rss.edit');
    }

    public function test_rss_update()
    {
        $rss = Rss::create([
            'language_id' => $this->language->id,
            'category_id' => $this->category->id,
            'feed_name' => 'Old Feed',
            'feed_url' => 'https://example.com/old',
            'post_limit' => 5,
        ]);

        $response = $this->post(route('rss.update', $rss->id), [
            'feed_name' => 'Updated Feed',
            'feed_url' => 'https://example.com/new',
            'post_limit' => 10,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('rss_feeds', ['feed_name' => 'Updated Feed']);
    }

    public function test_rss_delete()
    {
        $rss = Rss::create([
            'language_id' => $this->language->id,
            'category_id' => $this->category->id,
            'feed_name' => 'Delete Feed',
            'feed_url' => 'https://example.com/rss',
            'post_limit' => 5,
        ]);

        $response = $this->get(route('rss.delete', $rss->id));
        $response->assertStatus(200);
        $response->assertSee('Data deleted Successfully');
        $this->assertDatabaseMissing('rss_feeds', ['id' => $rss->id]);
    }

    // ==================== ScheduleController ====================

    public function test_schedule_index()
    {
        $response = $this->get(route('schedule.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.schedule.index');
    }

    public function test_schedule_post_approve()
    {
        Post::create([
            'language_id' => $this->language->id,
            'title' => 'Scheduled Post',
            'slug' => 'scheduled-post',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 0,
            'schedule_post' => 1,
            'schedule_post_date' => now()->subDay(),
        ]);

        $response = $this->post(route('schedule.postApprove'));
        $response->assertStatus(302);
    }

    // ==================== SeoController ====================

    public function test_seo_google_analytics()
    {
        $response = $this->get(route('seo.google.analytics'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.seo.googleAnalytics');
    }

    public function test_seo_meta_keywords()
    {
        $response = $this->get(route('seo.meta.keywords'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.seo.metaKeywords');
    }

    public function test_seo_update()
    {
        $response = $this->post(route('seo.update'), [
            'google_analytics' => 'UA-12345',
            'meta_keys' => 'news, test, blog',
            'meta_description' => 'Test site description',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('seotools', ['google_analytics' => 'UA-12345']);
    }

    // ==================== ShortListController ====================

    public function test_shortlist_create()
    {
        $response = $this->get(route('shortlist.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.shortlist.create');
    }

    public function test_shortlist_store()
    {
        $photo1 = UploadedFile::fake()->image('photo1.jpg');
        $photo2 = UploadedFile::fake()->image('photo2.jpg');

        $response = $this->post(route('shortlist.store'), [
            'language_id' => $this->language->id,
            'title' => 'Sorted List',
            'slug' => 'sorted-list',
            'description' => 'List description',
            'category_id' => $this->category->id,
            'item_title' => ['Item 1', 'Item 2'],
            'item_description' => ['Desc 1', 'Desc 2'],
            'item_photo' => [$photo1, $photo2],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'sorted-list']);
    }

    public function test_shortlist_store_validation_fails()
    {
        $response = $this->post(route('shortlist.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    // ==================== SiteMapController ====================

    public function test_sitemap_all()
    {
        $response = $this->get(route('admin.sitemap.all'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.generalsettings.sitemap');
    }

    public function test_sitemap_index()
    {
        $response = $this->get(route('sitemap.index'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
    }

    public function test_sitemap_posts()
    {
        $response = $this->get(route('sitemap.posts'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
    }

    public function test_sitemap_categories()
    {
        $response = $this->get(route('sitemap.categories'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
    }

    public function test_sitemap_subcategories()
    {
        $response = $this->get(route('sitemap.subcategories'));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
    }

    // ==================== SliderController ====================

    public function test_slider_index()
    {
        $response = $this->get(route('slider.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.slider.index');
    }

    public function test_slider_category_filter()
    {
        $response = $this->get(route('slider.categoryFilter.language', $this->language->id));
        $response->assertStatus(200);
    }

    // ==================== SocialLinkController ====================

    public function test_social_link_index()
    {
        $response = $this->get(route('social.link.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.sociallink.index');
    }

    public function test_social_link_create()
    {
        $response = $this->get(route('social.link.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.sociallink.create');
    }

    public function test_social_link_store()
    {
        $response = $this->post(route('social.link.store'), [
            'name' => 'Facebook',
            'link' => 'https://facebook.com',
            'icon' => 'fab fa-facebook',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('social_links', ['name' => 'Facebook']);
    }

    public function test_social_link_edit()
    {
        $link = SocialLink::create(['name' => 'Twitter', 'link' => 'https://twitter.com', 'icon' => 'fab fa-twitter']);

        $response = $this->get(route('social.link.edit', $link->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.sociallink.edit');
    }

    public function test_social_link_update()
    {
        $link = SocialLink::create(['name' => 'Twitter', 'link' => 'https://twitter.com', 'icon' => 'fab fa-twitter']);

        $response = $this->post(route('social.link.update', $link->id), [
            'name' => 'X (Twitter)',
            'link' => 'https://x.com',
            'icon' => 'fab fa-x',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('social_links', ['name' => 'X (Twitter)']);
    }

    public function test_social_link_delete()
    {
        $link = SocialLink::create(['name' => 'Delete', 'link' => 'https://example.com', 'icon' => 'fas fa-link']);

        $response = $this->get(route('social.link.delete', $link->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('social_links', ['id' => $link->id]);
    }

    // ==================== SocialSettingsController ====================

    public function test_social_settings_google()
    {
        $response = $this->get(route('social.settings.google'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.socialsettings.google');
    }

    public function test_social_settings_facebook()
    {
        $response = $this->get(route('social.settings.facebook'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.socialsettings.facebook');
    }

    public function test_social_settings_update()
    {
        $response = $this->post(route('social.settings.update'), [
            'fclient_id' => 'fb-id-123',
            'fclient_secret' => 'fb-secret',
            'fredirect' => 'https://example.com/fb/callback',
            'gclient_id' => 'google-id',
            'gclient_secret' => 'google-secret',
            'gredirect' => 'https://example.com/google/callback',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('socialsettings', ['fclient_id' => 'fb-id-123']);
    }

    // ==================== StaffController ====================

    public function test_staff_index()
    {
        $response = $this->get(route('admin.staff.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.index');
    }

    public function test_staff_create()
    {
        $response = $this->get(route('admin.staff.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.create');
    }

    public function test_staff_store()
    {
        $response = $this->post(route('admin.staff.store'), [
            'name' => 'Staff User',
            'email' => 'staff@test.com',
            'phone' => '1234567890',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('users', ['email' => 'staff@test.com']);
    }

    public function test_staff_store_validation_fails()
    {
        $response = $this->post(route('admin.staff.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_staff_edit()
    {
        $staff = User::create([
            'name' => 'Edit Staff',
            'email' => 'editstaff@test.com',
            'phone' => '111',
            'password' => Hash::make('password'),
        ]);

        $response = $this->get(route('admin.staff.edit', $staff->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.staff.edit');
    }

    public function test_staff_update()
    {
        $staff = User::create([
            'name' => 'Old Staff',
            'email' => 'oldstaff@test.com',
            'phone' => '111',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('admin.staff.update', $staff->id), [
            'name' => 'Updated Staff',
            'email' => 'oldstaff@test.com',
            'phone' => '999',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Sucessfully');
        $this->assertDatabaseHas('users', ['name' => 'Updated Staff']);
    }

    public function test_staff_delete()
    {
        $staff = User::create([
            'name' => 'Delete Staff',
            'email' => 'deletestaff@test.com',
            'phone' => '111',
            'password' => Hash::make('password'),
        ]);

        $response = $this->get(route('admin.staff.delete', $staff->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('users', ['id' => $staff->id]);
    }

    // ==================== SubCategoryController ====================

    public function test_subcategory_index()
    {
        $response = $this->get(route('subcategories.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.subcategory.index');
    }

    public function test_subcategory_create()
    {
        $response = $this->get(route('subcategories.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.subcategory.create');
    }

    public function test_subcategory_store()
    {
        $response = $this->post(route('subcategories.store'), [
            'language_id' => $this->language->id,
            'title' => 'New SubCategory',
            'parent_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('categories', ['title' => 'New SubCategory', 'parent_id' => $this->category->id]);
    }

    public function test_subcategory_store_validation_fails()
    {
        $response = $this->post(route('subcategories.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_subcategory_edit()
    {
        $response = $this->get(route('subcategories.edit', $this->subcategory->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.subcategory.edit');
    }

    public function test_subcategory_update()
    {
        $response = $this->post(route('subcategories.update', $this->subcategory->id), [
            'language_id' => $this->language->id,
            'title' => 'Updated SubCategory',
            'slug' => 'updated-subcategory',
            'parent_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('categories', ['title' => 'Updated SubCategory']);
    }

    public function test_subcategory_delete()
    {
        $response = $this->get(route('subcategories.delete', $this->subcategory->id));
        $response->assertStatus(200);
        $response->assertSee('Data Successfully Deleted');
        $this->assertDatabaseMissing('categories', ['id' => $this->subcategory->id]);
    }

    // ==================== SubscriberController ====================

    public function test_subscriber_index()
    {
        $response = $this->get(route('admin.subscriber.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriber.index');
    }

    public function test_subscriber_download()
    {
        Subscriber::create(['email' => 'sub@test.com']);

        $response = $this->get(route('admin.subscriber.download'));
        $response->assertStatus(200);
    }

    public function test_subscriber_email_page()
    {
        $response = $this->get(route('admin.subscriber.email'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.subscriber.email.index');
    }

    // ==================== TQuizController ====================

    public function test_tquiz_store()
    {
        $response = $this->post(route('tquiz.store'), [
            'language_id' => $this->language->id,
            'title' => 'Trivia Quiz',
            'slug' => 'trivia-quiz',
            'description' => 'Trivia description',
            'category_id' => $this->category->id,
            'question_title' => ['1' => 'What is 2+2?'],
            'question_description' => ['1' => 'Simple math'],
            'result_title' => ['Excellent!'],
            'result_description' => ['You did great'],
            'min' => ['0'],
            'max' => ['1'],
            'answer_title' => [
                '2' => ['3', '4', '5'],
            ],
            'correct_answer' => [
                '2' => '2',
            ],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'trivia-quiz']);
    }

    public function test_tquiz_store_validation_fails()
    {
        $response = $this->post(route('tquiz.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_tquiz_remove_question()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'TQuiz',
            'slug' => 'tquiz-remove',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'Trivia Quiz',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $questionId = \DB::table('trivia_questions')->insertGetId([
            'post_id' => $post->id,
            'question_title' => 'Remove TQ?',
        ]);

        $response = $this->get(route('tquiz.removequestion', $questionId));
        $response->assertStatus(200);
        $response->assertSee('Question Deleted Successfully');
    }

    public function test_tquiz_remove_result()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'TQuiz Result',
            'slug' => 'tquiz-result-rem',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'Trivia Quiz',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $result = \App\Models\TriviaResult::create([
            'post_id' => $post->id,
            'result_title' => 'Remove TResult',
            'min' => 0,
            'max' => 1,
        ]);

        $response = $this->get(route('tquiz.removeresult', $result->id));
        $response->assertStatus(200);
        $response->assertSee('Result Deleted Successfully');
    }

    // ==================== VideoController ====================

    public function test_video_create()
    {
        $response = $this->get(route('video.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.video.create');
    }

    public function test_video_language_categories()
    {
        $response = $this->get(route('video.language', $this->language->id));
        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    public function test_video_subcategory()
    {
        $response = $this->get(route('video.subcategory', $this->category->id));
        $response->assertStatus(200);
        $response->assertSee('Test SubCategory');
    }

    public function test_video_slug_create()
    {
        $response = $this->get(route('video.slugCreate') . '?title=Video Title');
        $response->assertStatus(200);
        $this->assertEquals('Video-Title', $response->getContent());
    }

    public function test_video_slug_check()
    {
        $response = $this->get(route('video.slugCheck') . '?slug=unique-slug');
        $response->assertStatus(200);
        $this->assertEquals('unique-slug', $response->getContent());
    }

    public function test_video_store()
    {
        $response = $this->post(route('video.store'), [
            'language_id' => $this->language->id,
            'title' => 'Test Video',
            'slug' => 'test-video',
            'description' => 'Video description',
            'category_id' => $this->category->id,
            'embed_video' => 'https://www.youtube.com/embed/test',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Video Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'test-video', 'post_type' => 'video']);
    }

    public function test_video_store_validation_fails()
    {
        $response = $this->post(route('video.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_video_update()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Old Video',
            'slug' => 'old-video',
            'description' => 'Old desc',
            'category_id' => $this->category->id,
            'admin_id' => $this->admin->id,
            'status' => 'true',
            'post_type' => 'video',
            'is_pending' => 0,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('video.update', $post->id), [
            'title' => 'Updated Video',
            'slug' => 'updated-video',
            'description' => 'Updated desc',
            'category_id' => $this->category->id,
            'embed_video' => 'https://www.youtube.com/embed/updated',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Video Updated Successfully');
        $this->assertDatabaseHas('posts', ['title' => 'Updated Video']);
    }

    // ==================== WidgetController ====================

    public function test_widget_index()
    {
        $response = $this->get(route('widget.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.widget.index');
    }

    public function test_widget_create()
    {
        $response = $this->get(route('widget.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.widget.create');
    }

    public function test_widget_store()
    {
        $response = $this->post(route('widget.store'), [
            'language_id' => $this->language->id,
            'title' => 'Test Widget',
            'description' => 'Widget description',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('widgets', ['title' => 'Test Widget']);
    }

    public function test_widget_store_validation_fails()
    {
        $response = $this->post(route('widget.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_widget_edit()
    {
        $widget = Widget::create([
            'language_id' => $this->language->id,
            'title' => 'Edit Widget',
            'description' => 'Edit description',
        ]);

        $response = $this->get(route('widget.edit', $widget->id));
        $response->assertStatus(200);
        $response->assertViewIs('admin.widget.edit');
    }

    public function test_widget_update()
    {
        $widget = Widget::create([
            'language_id' => $this->language->id,
            'title' => 'Old Widget',
            'description' => 'Old description',
        ]);

        $response = $this->post(route('widget.update', $widget->id), [
            'language_id' => $this->language->id,
            'title' => 'Updated Widget',
            'description' => 'Updated description',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertDatabaseHas('widgets', ['title' => 'Updated Widget']);
    }

    public function test_widget_delete()
    {
        $widget = Widget::create([
            'language_id' => $this->language->id,
            'title' => 'Delete Widget',
            'description' => 'Delete description',
        ]);

        $response = $this->get(route('widget.delete', $widget->id));
        $response->assertStatus(200);
        $response->assertSee('Data Deleted Successfully');
        $this->assertDatabaseMissing('widgets', ['id' => $widget->id]);
    }

    public function test_widget_settings_page()
    {
        $response = $this->get(route('widget.settings'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.widget.widgetsettings');
    }

    public function test_widget_settings_update()
    {
        $response = $this->post(route('widget.settings.update'), [
            'feature_inhome' => 'on',
            'category_inhome' => 'on',
            'follow_inhome' => 'on',
            'tag_inhome' => 'on',
            'poll_inhome' => 'on',
            'calendar_inhome' => 'on',
            'newsletter_inhome' => 'on',
            'category_incategory' => 'on',
            'newsletter_incategory' => 'on',
            'calendar_incategory' => 'on',
            'category_indetails' => 'on',
            'newsletter_indetails' => 'on',
            'calendar_indetails' => 'on',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated Successfully');
        $this->assertEquals(1, WidgetSetiings::first()->feature_inhome);
    }
}
