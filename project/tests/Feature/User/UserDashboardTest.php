<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Language;
use App\Models\Gallery;
use App\Models\GeneralSettings;
use App\Models\Seo;
use App\Models\SocialSettings;
use App\Models\WidgetSetiings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $language;
    protected $category;
    protected $subcategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->make('config')->set('app.url', 'http://localhost');
        $this->app['url']->forceRootUrl('http://localhost');

        DB::table('admin_languages')->insert([
            'is_default' => 1,
            'language' => 'English',
            'name' => 'en',
            'file' => 'en',
        ]);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
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

        $this->actingAs($this->user);
    }

    public function test_guest_cannot_access_user_routes()
    {
        auth()->logout();
        $response = $this->get(route('user.dashboard'));
        $response->assertRedirect(route('front.LogReg'));
    }

    // ==================== ArticleController ====================

    public function test_article_create_view()
    {
        $response = $this->get(route('user.article.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.article.create');
    }

    public function test_article_language_categories()
    {
        $response = $this->get(route('user.article.language', $this->language->id));
        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    public function test_article_subcategory()
    {
        $response = $this->get(route('user.article.subcategory', $this->category->id));
        $response->assertStatus(200);
        $response->assertSee('Test SubCategory');
    }

    public function test_article_slug_create()
    {
        $response = $this->get(route('user.article.slugCreate') . '?title=Breaking News');
        $response->assertStatus(200);
        $this->assertEquals('Breaking-News', $response->getContent());
    }

    public function test_article_slug_check_unique()
    {
        $response = $this->get(route('user.article.slugCheck') . '?slug=new-article');
        $response->assertStatus(200);
        $this->assertEquals('new-article', $response->getContent());
    }

    public function test_article_slug_check_duplicate()
    {
        Post::create([
            'language_id' => $this->language->id,
            'title' => 'Existing',
            'slug' => 'existing-article',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.article.slugCheck') . '?slug=existing-article');
        $response->assertStatus(200);
        $this->assertNotEquals('existing-article', $response->getContent());
    }

    public function test_article_store()
    {
        $response = $this->post(route('user.article.store'), [
            'language_id' => $this->language->id,
            'title' => 'Test Article',
            'slug' => 'test-article',
            'description' => 'Article description',
            'category_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Article Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'test-article', 'user_id' => $this->user->id, 'is_pending' => 1]);
    }

    public function test_article_store_validation_fails()
    {
        $response = $this->post(route('user.article.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_article_update()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Old Article',
            'slug' => 'old-article',
            'description' => 'Old description',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('user.article.update', $post->id), [
            'language_id' => $this->language->id,
            'title' => 'Updated Article',
            'slug' => 'updated-article',
            'description' => 'Updated description',
            'category_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Updated successfully');
        $this->assertDatabaseHas('posts', ['title' => 'Updated Article']);
    }

    // ==================== AudioController ====================

    public function test_audio_create_view()
    {
        $response = $this->get(route('user.audio.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.audio.create');
    }

    public function test_audio_language_categories()
    {
        $response = $this->get(route('user.audio.language', $this->language->id));
        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    public function test_audio_subcategory()
    {
        $response = $this->get(route('user.audio.subcategory', $this->category->id));
        $response->assertStatus(200);
        $response->assertSee('Test SubCategory');
    }

    public function test_audio_slug_create()
    {
        $response = $this->get(route('user.audio.slugCreate') . '?title=Audio Clip');
        $response->assertStatus(200);
        $this->assertEquals('Audio-Clip', $response->getContent());
    }

    public function test_audio_slug_check()
    {
        $response = $this->get(route('user.audio.slugCheck'));
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
    }

    public function test_audio_store()
    {
        $audio = UploadedFile::fake()->create('audio.mp3', 100);

        $response = $this->post(route('user.audio.store'), [
            'language_id' => $this->language->id,
            'title' => 'Test Audio',
            'slug' => 'test-audio',
            'description' => 'Audio description',
            'category_id' => $this->category->id,
            'audio' => $audio,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Audio Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'test-audio', 'post_type' => 'audio']);
    }

    public function test_audio_store_validation_fails()
    {
        $response = $this->post(route('user.audio.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_audio_update()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Old Audio',
            'slug' => 'old-audio',
            'description' => 'Old desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'audio',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('user.audio.update', $post->id), [
            'title' => 'Updated Audio',
            'slug' => 'updated-audio',
            'description' => 'Updated desc',
            'category_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
        $response->assertSee('Audio updated Successfully');
        $this->assertDatabaseHas('posts', ['title' => 'Updated Audio']);
    }

    // ==================== CacheController ====================

    public function test_cache_clear()
    {
        $response = $this->get(route('user.cache.clear'));
        $response->assertStatus(302);
    }

    // ==================== DashboardController ====================

    public function test_dashboard_index()
    {
        $response = $this->get(route('user.dashboard'));
        $response->assertStatus(200);
        $response->assertViewIs('user.dashboard');
    }

    public function test_dashboard_profile()
    {
        $response = $this->get(route('user.profile'));
        $response->assertStatus(200);
        $response->assertViewIs('user.profile.edit');
    }

    public function test_dashboard_profile_update()
    {
        $response = $this->post(route('user.profile.update'), [
            'name' => 'Updated User',
            'email' => 'user@test.com',
            'phone' => '9999999999',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Successfully updated your profile');
        $this->assertDatabaseHas('users', ['name' => 'Updated User']);
    }

    public function test_dashboard_profile_update_validation_fails()
    {
        $response = $this->post(route('user.profile.update'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_dashboard_password_page()
    {
        $response = $this->get(route('user.password'));
        $response->assertStatus(200);
        $response->assertViewIs('user.profile.password');
    }

    public function test_dashboard_password_change()
    {
        $response = $this->post(route('user.password.update'), [
            'cpass' => 'password',
            'newpass' => 'new-password-123',
            'renewpass' => 'new-password-123',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Successfully change your passwprd');
    }

    public function test_dashboard_password_change_wrong_current()
    {
        $response = $this->post(route('user.password.update'), [
            'cpass' => 'wrong-password',
            'newpass' => 'new-password-123',
            'renewpass' => 'new-password-123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    public function test_dashboard_password_change_mismatch()
    {
        $response = $this->post(route('user.password.update'), [
            'cpass' => 'password',
            'newpass' => 'new-password-123',
            'renewpass' => 'different-password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['errors']);
    }

    // ==================== DraftController ====================

    public function test_draft_index()
    {
        $response = $this->get(route('user.draft.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.draft.index');
    }

    // ==================== GalleryController ====================

    public function test_gallery_show()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Gallery Post',
            'slug' => 'gallery-post',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.gallery.show', ['id' => $post->id]));
        $response->assertStatus(200);
        $response->assertJson([0 => 0]);
    }

    public function test_gallery_store()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Gallery Store Post',
            'slug' => 'gallery-store-post',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $file = UploadedFile::fake()->create('photo.jpg', 50);

        $response = $this->post(route('user.gallery.store'), [
            'post_id' => $post->id,
            'gallery' => [$file],
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('galleries', ['post_id' => $post->id]);
    }

    public function test_gallery_destroy()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Gallery Del Post',
            'slug' => 'gallery-del-post',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $gallery = Gallery::create(['post_id' => $post->id, 'photo' => 'test.jpg']);

        $response = $this->get(route('user.gallery.delete', ['id' => $gallery->id]));
        $response->assertStatus(200);
        $response->assertSee('Gallery Deleted Successfully');
        $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    }

    // ==================== PostController (User) ====================

    public function test_user_post_index()
    {
        $response = $this->get(route('user.post.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.post.index');
    }

    public function test_user_post_edit_article()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit Post',
            'slug' => 'user-edit-post',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'article',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.article.edit');
    }

    public function test_user_post_edit_video()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit Video',
            'slug' => 'user-edit-video',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'video',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.video.edit');
    }

    public function test_user_post_edit_sorted_list()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit Sorted',
            'slug' => 'user-edit-sorted',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Sorted List',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.shortlist.edit');
    }

    public function test_user_post_edit_trivia_quiz()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit Trivia',
            'slug' => 'user-edit-trivia',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Trivia Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.quiz.edit');
    }

    public function test_user_post_edit_personality_quiz()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit PQuiz',
            'slug' => 'user-edit-pquiz',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.pquiz.edit');
    }

    public function test_user_post_edit_audio()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'User Edit Audio',
            'slug' => 'user-edit-audio',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'audio',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->get(route('user.post.edit', $post->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.audio.edit');
    }

    // ==================== User PQuizController ====================

    public function test_user_pquiz_create()
    {
        $response = $this->get(route('user.pquiz.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.pquiz.create');
    }

    public function test_user_pquiz_store()
    {
        $response = $this->post(route('user.pquiz.store'), [
            'language_id' => $this->language->id,
            'title' => 'User Personality Quiz',
            'slug' => 'user-personality-quiz',
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
        $this->assertDatabaseHas('posts', ['slug' => 'user-personality-quiz', 'user_id' => $this->user->id]);
    }

    public function test_user_pquiz_remove_question()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'UPQ Quiz',
            'slug' => 'upq-quiz',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $questionId = \DB::table('personality_questions')->insertGetId([
            'post_id' => $post->id,
            'question_title' => 'Remove Q?',
        ]);

        $response = $this->get(route('user.pquiz.removepquestion', $questionId));
        $response->assertStatus(200);
        $response->assertSee('Question Deleted Successfully');
    }

    public function test_user_pquiz_remove_result()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'UPQ Result',
            'slug' => 'upq-result',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $result = \App\Models\PersonalityResult::create([
            'post_id' => $post->id,
            'result_title' => 'Remove Result',
        ]);

        $response = $this->get(route('user.pquiz.removeresult', $result->id));
        $response->assertStatus(200);
        $response->assertSee('Result Deleted Successfully');
    }

    public function test_user_pquiz_remove_answer()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'UPQ Answer',
            'slug' => 'upq-answer',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Personality Quiz',
            'is_pending' => 1,
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

        $response = $this->get(route('user.pquiz.removeanswer', $answer->id));
        $response->assertStatus(200);
        $response->assertSee('Answer Deleted Successfully');
    }

    // ==================== User ScheduleController ====================

    public function test_user_schedule_index()
    {
        $response = $this->get(route('user.schedule.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.schedule.index');
    }

    // ==================== User ShortListController ====================

    public function test_user_shortlist_create()
    {
        $response = $this->get(route('user.shortlist.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.shortlist.create');
    }

    public function test_user_shortlist_store()
    {
        $response = $this->post(route('user.shortlist.store'), [
            'language_id' => $this->language->id,
            'title' => 'User Sorted List',
            'slug' => 'user-sorted-list',
            'description' => 'List description',
            'category_id' => $this->category->id,
            'item_title' => ['Item 1', 'Item 2'],
            'item_description' => ['Desc 1', 'Desc 2'],
        ]);

        $response->assertStatus(200);
        $response->assertSee('Data Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'user-sorted-list']);
    }

    public function test_user_shortlist_store_validation_fails()
    {
        $response = $this->post(route('user.shortlist.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    // ==================== User TQuizController ====================

    public function test_user_tquiz_create()
    {
        $response = $this->get(route('user.tquiz.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.quiz.create');
    }

    public function test_user_tquiz_store()
    {
        $response = $this->post(route('user.tquiz.store'), [
            'language_id' => $this->language->id,
            'title' => 'User Trivia Quiz',
            'slug' => 'user-trivia-quiz',
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
        $this->assertDatabaseHas('posts', ['slug' => 'user-trivia-quiz']);
    }

    public function test_user_tquiz_remove_question()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'UTQ',
            'slug' => 'utq',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Trivia Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $questionId = \DB::table('trivia_questions')->insertGetId([
            'post_id' => $post->id,
            'question_title' => 'Remove?',
        ]);

        $response = $this->get(route('user.tquiz.removequestion', $questionId));
        $response->assertStatus(200);
        $response->assertSee('Question Deleted Successfully');
    }

    public function test_user_tquiz_remove_result()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'UTQ Result',
            'slug' => 'utq-result',
            'description' => 'Desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'Trivia Quiz',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $result = \App\Models\TriviaResult::create([
            'post_id' => $post->id,
            'result_title' => 'Remove R',
            'min' => 0,
            'max' => 1,
        ]);

        $response = $this->get(route('user.tquiz.removeresult', $result->id));
        $response->assertStatus(200);
        $response->assertSee('Result Deleted Successfully');
    }

    // ==================== User VideoController ====================

    public function test_user_video_create()
    {
        $response = $this->get(route('user.video.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.video.create');
    }

    public function test_user_video_language_categories()
    {
        $response = $this->get(route('user.video.language', $this->language->id));
        $response->assertStatus(200);
        $response->assertSee('Test Category');
    }

    public function test_user_video_subcategory()
    {
        $response = $this->get(route('user.video.subcategory', $this->category->id));
        $response->assertStatus(200);
        $response->assertSee('Test SubCategory');
    }

    public function test_user_video_slug_create()
    {
        $response = $this->get(route('user.video.slugCreate') . '?title=My Video');
        $response->assertStatus(200);
        $this->assertEquals('My-Video', $response->getContent());
    }

    public function test_user_video_slug_check()
    {
        $response = $this->get(route('user.video.slugCheck') . '?slug=my-video');
        $response->assertStatus(200);
        $this->assertEquals('my-video', $response->getContent());
    }

    public function test_user_video_store()
    {
        $response = $this->post(route('user.video.store'), [
            'language_id' => $this->language->id,
            'title' => 'User Video',
            'slug' => 'user-video',
            'description' => 'Video description',
            'category_id' => $this->category->id,
            'embed_video' => 'https://www.youtube.com/embed/test',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Video Added Successfully');
        $this->assertDatabaseHas('posts', ['slug' => 'user-video', 'post_type' => 'video', 'user_id' => $this->user->id]);
    }

    public function test_user_video_store_validation_fails()
    {
        $response = $this->post(route('user.video.store'), []);
        $response->assertJsonStructure(['errors']);
    }

    public function test_user_video_update()
    {
        $post = Post::create([
            'language_id' => $this->language->id,
            'title' => 'Old User Video',
            'slug' => 'old-user-video',
            'description' => 'Old desc',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'status' => 'true',
            'post_type' => 'video',
            'is_pending' => 1,
            'schedule_post' => 0,
        ]);

        $response = $this->post(route('user.video.update', $post->id), [
            'title' => 'Updated User Video',
            'slug' => 'updated-user-video',
            'description' => 'Updated desc',
            'category_id' => $this->category->id,
            'embed_video' => 'https://www.youtube.com/embed/updated',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Video Updated Successfully');
        $this->assertDatabaseHas('posts', ['title' => 'Updated User Video']);
    }
}
