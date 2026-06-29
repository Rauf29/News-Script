<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Admin;
use App\Models\AdminLanguage;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\EmailTemplate;
use App\Models\Follow;
use App\Models\Font;
use App\Models\Gallery;
use App\Models\GeneralSettings;
use App\Models\ImageAlbum;
use App\Models\ImageCategory;
use App\Models\ImageGallery;
use App\Models\Language;
use App\Models\Logo;
use App\Models\Page;
use App\Models\PersonalityAnswer;
use App\Models\PersonalityQuestion;
use App\Models\PersonalityResult;
use App\Models\PollAnswer;
use App\Models\PollQuestion;
use App\Models\PollResult;
use App\Models\Post;
use App\Models\Role;
use App\Models\Rss;
use App\Models\Seo;
use App\Models\ShortList;
use App\Models\SocialLink;
use App\Models\SocialProvider;
use App\Models\SocialSettings;
use App\Models\Subscriber;
use App\Models\TriviaAnswer;
use App\Models\TriviaQuestion;
use App\Models\TriviaResult;
use App\Models\User;
use App\Models\View;
use App\Models\Widget;
use App\Models\WidgetSetiings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \Mockery::close();
    }

    public function test_category_model(): void
    {
        $model = new Category();

        $this->assertEquals(['language_id','title','slug','parent_id','color','category_order','show_at_homepage','show_on_menu'], $model->getFillable());
        $this->assertEquals('categories', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(HasMany::class, $model->child());
        $this->assertInstanceOf(HasMany::class, $model->posts());
        $this->assertInstanceOf(HasMany::class, $model->subcategoryPosts());
        $this->assertInstanceOf(HasMany::class, $model->rss());

        $casts = $model->getCasts();
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);

        $this->assertEquals([], $model->getDates());
    }

    public function test_post_model(): void
    {
        $model = new Post();

        $this->assertEquals([
            'language_id', 'title', 'slug', 'short_description', 'images_caption',
            'meta_tag', 'show_right_column', 'is_feature', 'is_slider', 'is_trending',
            'is_videoGallery', 'description', 'image_big', 'rss_image', 'image_small',
            'video', 'audio', 'category_id', 'subcategories_id', 'admin_id', 'user_id',
            'status', 'schedule_post', 'schedule_post_date', 'is_pending', 'post_type',
            'slider_left', 'slider_right', 'rss_link', 'embed_video'
        ], $model->getFillable());
        $this->assertEquals('posts', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->category());
        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(BelongsTo::class, $model->admin());
        $this->assertInstanceOf(BelongsTo::class, $model->user());
        $this->assertInstanceOf(HasMany::class, $model->galleries());
        $this->assertInstanceOf(HasMany::class, $model->views());
        $this->assertInstanceOf(HasMany::class, $model->tquizs());
        $this->assertInstanceOf(HasMany::class, $model->tresults());
        $this->assertInstanceOf(HasMany::class, $model->pquizs());
        $this->assertInstanceOf(HasMany::class, $model->presults());
        $this->assertInstanceOf(HasMany::class, $model->sorts());

        $casts = $model->getCasts();
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);

        $this->assertEquals(['created_at', 'updated_at'], $model->getDates());

        $post = new Post();
        $post->setAttribute('created_at', Carbon::parse('2024-06-15 10:30:00'));
        $this->assertEquals('Jun 15, 2024', $post->createdAt());
    }

    public function test_user_model(): void
    {
        $model = new User();

        $this->assertEquals([
            'name', 'username', 'photo', 'zip', 'residency', 'city', 'address',
            'designation', 'phone', 'fax', 'email', 'password', 'verification_link',
            'affilate_code', 'is_provider', 'twofa', 'go', 'details',
            'token', 'status', 'verify',
        ], $model->getFillable());
        $this->assertEquals('users', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(HasMany::class, $model->posts());

        $casts = $model->getCasts();
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);
    }

    public function test_admin_model(): void
    {
        $model = new Admin();

        $this->assertEquals([
            'name', 'email', 'password','phone','designation','photo','role_id','token','verify'
        ], $model->getFillable());
        $this->assertEquals('admins', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(HasMany::class, $model->posts());
        $this->assertInstanceOf(BelongsTo::class, $model->role());
        $this->assertInstanceOf(HasMany::class, $model->socialProviders());
        $this->assertInstanceOf(HasMany::class, $model->followers());

        $casts = $model->getCasts();
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);

        $adminSuper = new Admin();
        $adminSuper->id = 1;
        $this->assertTrue($adminSuper->IsSuper());

        $adminNotSuper = new Admin();
        $adminNotSuper->id = 2;
        $this->assertFalse($adminNotSuper->IsSuper());

        $this->assertTrue(method_exists($model, 'sectionCheck'));
        $this->assertTrue(method_exists($model, 'filterByLanguage'));
        $this->assertTrue(method_exists($model, 'filterByCategory'));
    }

    public function test_general_settings_model(): void
    {
        $model = new GeneralSettings();

        $this->assertEquals([
            'logo', 'footer_logo', 'lazy_baner', 'og_baner', 'favicon', 'loader',
            'live_tv', 'epaper_link', 'admin_loader', 'title', 'theme_color', 'footer_color',
            'sidebar_big_ads2', 'sidebar_big_ads3',
            'phone2', 'email2', 'app1', 'app2',
            'time_zone', 'copyright_text', 'sidebar_ads',
            'header1_728', 'header2_728', 'header3_728', 'header4_728',
            'adsense_code', 'search_console',
            'homepageads1_970', 'homepageads2_970', 'homepageads3_970', 'homepageads4_970',
            'sidebar_ads1', 'sidebar_adsbig',
            'dhaka', 'ctg', 'rajshahi', 'khulna', 'barishal', 'syleth', 'rangpur', 'mymensingh',
            'adress', 'email', 'phone',
            'prokashok', 'sompadok', 'barta_sompadok', 'notice_text',
            'facebook_page_url', 'facebook_app_id',
            'copyright_color', 'tags', 'error_photo', 'error_title', 'horizontal_adds1',
            'error_text', 'driver', 'smtp_host', 'smtp_port', 'email_encryption',
            'smtp_user', 'smtp_pass', 'from_email', 'from_name', 'is_smtp',
            'is_verification_email', 'version'
        ], $model->getFillable());
        $this->assertEquals('generalsettings', $model->getTable());
        $this->assertFalse($model->timestamps);

        $casts = $model->getCasts();
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);

        $this->assertEquals([], $model->getDates());
    }

    public function test_language_model(): void
    {
        $model = new Language();

        $this->assertEquals(['is_default','language','file','name','rtl','status'], $model->getFillable());
        $this->assertEquals('languages', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(HasMany::class, $model->categories());
        $this->assertInstanceOf(HasMany::class, $model->posts());
        $this->assertInstanceOf(HasMany::class, $model->polls());
        $this->assertInstanceOf(HasMany::class, $model->albums());
        $this->assertInstanceOf(HasMany::class, $model->galleries());
        $this->assertInstanceOf(HasMany::class, $model->pages());
        $this->assertInstanceOf(HasMany::class, $model->rss());
        $this->assertInstanceOf(HasMany::class, $model->widgets());
        $this->assertInstanceOf(HasMany::class, $model->logos());
    }

    public function test_page_model(): void
    {
        $model = new Page();

        $this->assertEquals(['language_id','title','slug','description','placement','status','wbsite_right_column'], $model->getFillable());
        $this->assertEquals('pages', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
    }

    public function test_advertisement_model(): void
    {
        $model = new Advertisement();

        $this->assertEquals(['add_placement','banner_type','addSize','photo','banner_code','link','status'], $model->getFillable());
        $this->assertEquals('advertisements', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_gallery_model(): void
    {
        $model = new Gallery();

        $this->assertEquals(['post_id','photo'], $model->getFillable());
        $this->assertEquals('galleries', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->post());
    }

    public function test_subscriber_model(): void
    {
        $model = new Subscriber();

        $this->assertEquals(['email'], $model->getFillable());
        $this->assertEquals('subscribers', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_poll_question_model(): void
    {
        $model = new PollQuestion();

        $this->assertEquals(['language_id','question','status','end_date'], $model->getFillable());
        $this->assertEquals('poll_questions', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(HasMany::class, $model->child());
        $this->assertInstanceOf(HasMany::class, $model->results());
    }

    public function test_poll_answer_model(): void
    {
        $model = new PollAnswer();

        $this->assertEquals(['poll_question_id','poll_option'], $model->getFillable());
        $this->assertEquals('poll_answers', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
        $this->assertInstanceOf(HasMany::class, $model->results());
    }

    public function test_poll_result_model(): void
    {
        $model = new PollResult();

        $this->assertEquals(['poll_question_id','poll_answer_id','ip_address'], $model->getFillable());
        $this->assertEquals('poll_results', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->answer());
        $this->assertInstanceOf(BelongsTo::class, $model->question());
    }

    public function test_role_model(): void
    {
        $model = new Role();

        $this->assertEquals(['name','section'], $model->getFillable());
        $this->assertEquals('roles', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(HasMany::class, $model->users());
    }

    public function test_follow_model(): void
    {
        $model = new Follow();

        $this->assertEquals(['admin_id','follower_id'], $model->getFillable());
        $this->assertEquals('follows', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_font_model(): void
    {
        $model = new Font();

        $this->assertEquals(['is_default','font_family','font_value'], $model->getFillable());
        $this->assertEquals('fonts', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_image_album_model(): void
    {
        $model = new ImageAlbum();

        $this->assertEquals(['language_id','photo','album_name'], $model->getFillable());
        $this->assertEquals('image_albums', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(HasMany::class, $model->categories());
        $this->assertInstanceOf(HasMany::class, $model->galleries());
    }

    public function test_image_category_model(): void
    {
        $model = new ImageCategory();

        $this->assertEquals(['language_id','image_album_id','name'], $model->getFillable());
        $this->assertEquals('image_categories', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(BelongsTo::class, $model->album());
        $this->assertInstanceOf(HasMany::class, $model->galleries());
    }

    public function test_image_gallery_model(): void
    {
        $model = new ImageGallery();

        $this->assertEquals(['language_id','image_album_id','image_category_id','gallery'], $model->getFillable());
        $this->assertEquals('image_galleries', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(BelongsTo::class, $model->album());
        $this->assertInstanceOf(BelongsTo::class, $model->category());
    }

    public function test_logo_model(): void
    {
        $model = new Logo();

        $this->assertEquals(['language_id', 'header_logo', 'footer_logo'], $model->getFillable());
        $this->assertEquals('logos', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
    }

    public function test_personality_answer_model(): void
    {
        $model = new PersonalityAnswer();

        $this->assertEquals(['personality_question_id','answer_title','answer_photo','answer_option'], $model->getFillable());
        $this->assertEquals('personality_answers', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
    }

    public function test_personality_question_model(): void
    {
        $model = new PersonalityQuestion();

        $this->assertEquals(['post_id','question_title','personality_result_id','question_photo','question_description'], $model->getFillable());
        $this->assertEquals('personality_questions', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
        $this->assertInstanceOf(HasMany::class, $model->answers());
    }

    public function test_personality_result_model(): void
    {
        $model = new PersonalityResult();

        $this->assertEquals(['post_id','result_title','result_photo','result_description'], $model->getFillable());
        $this->assertEquals('personality_results', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
    }

    public function test_rss_model(): void
    {
        $model = new Rss();

        $this->assertEquals(['language_id','feed_name','feed_url','post_limit','category_id','auto_update'], $model->getFillable());
        $this->assertEquals('rss_feeds', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
        $this->assertInstanceOf(BelongsTo::class, $model->category());
    }

    public function test_seo_model(): void
    {
        $model = new Seo();

        $this->assertEquals(['google_analytics','meta_keys','meta_description'], $model->getFillable());
        $this->assertEquals('seotools', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_short_list_model(): void
    {
        $model = new ShortList();

        $this->assertEquals(['post_id','item_title','item_photo','item_description'], $model->getFillable());
        $this->assertEquals('short_lists', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
    }

    public function test_social_link_model(): void
    {
        $model = new SocialLink();

        $this->assertEquals(['name','link','icon'], $model->getFillable());
        $this->assertEquals('social_links', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_social_provider_model(): void
    {
        $model = new SocialProvider();

        $this->assertEquals(['admin_id','provider_id','provider'], $model->getFillable());
        $this->assertEquals('social_providers', $model->getTable());
        $this->assertTrue($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->admin());
    }

    public function test_social_settings_model(): void
    {
        $model = new SocialSettings();

        $this->assertEquals(['fclient_id','fclient_secret','fredirect','gclient_id','gclient_secret','gredirect'], $model->getFillable());
        $this->assertEquals('socialsettings', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_trivia_answer_model(): void
    {
        $model = new TriviaAnswer();

        $this->assertEquals(['trivia_question_id','answer_title','correct_answer','answer_photo'], $model->getFillable());
        $this->assertEquals('trivia_answers', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
    }

    public function test_trivia_question_model(): void
    {
        $model = new TriviaQuestion();

        $this->assertEquals(['post_id','question_title','question_photo','question_description'], $model->getFillable());
        $this->assertEquals('trivia_questions', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
        $this->assertInstanceOf(HasMany::class, $model->answers());
    }

    public function test_trivia_result_model(): void
    {
        $model = new TriviaResult();

        $this->assertEquals(['post_id','result_title','result_photo','result_description','min','max'], $model->getFillable());
        $this->assertEquals('trivia_results', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->parent());
    }

    public function test_view_model(): void
    {
        $model = new View();

        $this->assertEquals(['post_id','ip_address'], $model->getFillable());
        $this->assertEquals('views', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->post());
    }

    public function test_widget_model(): void
    {
        $model = new Widget();

        $this->assertEquals(['language_id','title','description','status'], $model->getFillable());
        $this->assertEquals('widgets', $model->getTable());
        $this->assertFalse($model->timestamps);

        $this->assertInstanceOf(BelongsTo::class, $model->language());
    }

    public function test_widget_settings_model(): void
    {
        $model = new WidgetSetiings();

        $this->assertEquals([
            'feature_inhome','category_inhome','follow_inhome','tag_inhome','poll_inhome',
            'calendar_inhome','newsletter_inhome',
            'category_incategory','newsletter_incategory','calendar_incategory',
            'category_indetails','newsletter_indetails','calendar_indetails'
        ], $model->getFillable());
        $this->assertEquals('widget_settings', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_admin_language_model(): void
    {
        $model = new AdminLanguage();

        $this->assertEquals(['is_default','language','file','name','rtl','status'], $model->getFillable());
        $this->assertEquals('admin_languages', $model->getTable());
        $this->assertFalse($model->timestamps);
    }

    public function test_email_template_model(): void
    {
        $model = new EmailTemplate();

        $this->assertEquals([], $model->getFillable());
        $this->assertEquals('email_templates', $model->getTable());
        $this->assertTrue($model->timestamps);

        $casts = $model->getCasts();
        $this->assertArrayHasKey('id', $casts);
        $this->assertEquals('int', $casts['id']);

        $this->assertEquals(['created_at', 'updated_at'], $model->getDates());
    }
}
