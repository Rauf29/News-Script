<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generalsettings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('loader')->nullable();
            $table->string('admin_loader')->nullable();
            $table->string('title')->nullable();
            $table->string('time_zone')->nullable();
            $table->text('copyright_text')->nullable();
            $table->text('tags')->nullable();
            $table->string('error_photo')->nullable();
            $table->string('error_title')->nullable();
            $table->text('error_text')->nullable();
            $table->string('driver')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('email_encryption')->nullable();
            $table->string('smtp_user')->nullable();
            $table->string('smtp_pass')->nullable();
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->tinyInteger('is_smtp')->default(0);
            $table->tinyInteger('is_verification_email')->default(0);
            $table->string('version')->nullable();
            $table->string('facebook_page_url')->nullable();
            $table->text('adress')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });

        Schema::create('seotools', function (Blueprint $table) {
            $table->id();
            $table->text('google_analytics')->nullable();
            $table->text('meta_keys')->nullable();
            $table->text('meta_description')->nullable();
        });

        Schema::create('socialsettings', function (Blueprint $table) {
            $table->id();
            $table->string('fclient_id')->nullable();
            $table->string('fclient_secret')->nullable();
            $table->string('fredirect')->nullable();
            $table->string('gclient_id')->nullable();
            $table->string('gclient_secret')->nullable();
            $table->string('gredirect')->nullable();
        });

        Schema::create('widget_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('feature_inhome')->default(0);
            $table->tinyInteger('category_inhome')->default(0);
            $table->tinyInteger('follow_inhome')->default(0);
            $table->tinyInteger('tag_inhome')->default(0);
            $table->tinyInteger('poll_inhome')->default(0);
            $table->tinyInteger('calendar_inhome')->default(0);
            $table->tinyInteger('newsletter_inhome')->default(0);
            $table->tinyInteger('category_incategory')->default(0);
            $table->tinyInteger('newsletter_incategory')->default(0);
            $table->tinyInteger('calendar_incategory')->default(0);
            $table->tinyInteger('category_indetails')->default(0);
            $table->tinyInteger('newsletter_indetails')->default(0);
            $table->tinyInteger('calendar_indetails')->default(0);
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('section')->nullable();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('password');
            $table->string('token')->nullable();
            $table->tinyInteger('verify')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_default')->default(0);
            $table->string('language');
            $table->string('name');
            $table->string('file');
            $table->tinyInteger('rtl')->default(0);
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->string('slug');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('color')->nullable();
            $table->integer('category_order')->default(0);
            $table->tinyInteger('show_at_homepage')->default(1);
            $table->tinyInteger('show_on_menu')->default(1);
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('placement')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('wbsite_right_column')->default(0);
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();
            $table->text('images_caption')->nullable();
            $table->text('meta_tag')->nullable();
            $table->tinyInteger('show_right_column')->default(0);
            $table->tinyInteger('is_feature')->default(0);
            $table->tinyInteger('is_slider')->default(0);
            $table->tinyInteger('is_trending')->default(0);
            $table->tinyInteger('is_videoGallery')->default(0);
            $table->text('description')->nullable();
            $table->string('image_big')->nullable();
            $table->text('rss_image')->nullable();
            $table->string('image_small')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategories_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status')->default('true');
            $table->tinyInteger('schedule_post')->default(0);
            $table->timestamp('schedule_post_date')->nullable();
            $table->tinyInteger('is_pending')->default(0);
            $table->string('post_type')->default('article');
            $table->tinyInteger('slider_left')->default(0);
            $table->tinyInteger('slider_right')->default(0);
            $table->text('rss_link')->nullable();
            $table->text('embed_video')->nullable();
            $table->timestamps();
        });

        Schema::create('poll_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->text('question');
            $table->tinyInteger('status')->default(1);
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('poll_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_question_id');
            $table->string('poll_option');
        });

        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->string('title');
            $table->text('description');
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('icon');
        });

        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('category_id');
            $table->string('feed_name');
            $table->text('feed_url');
            $table->integer('post_limit');
            $table->tinyInteger('auto_update')->default(0);
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
        });

        Schema::create('personality_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('question_title');
            $table->string('question_photo')->nullable();
            $table->text('question_description')->nullable();
            $table->timestamps();
        });

        Schema::create('personality_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personality_question_id');
            $table->string('answer_title');
            $table->string('answer_photo')->nullable();
            $table->string('answer_option');
        });

        Schema::create('personality_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('result_title');
            $table->string('result_photo')->nullable();
            $table->text('result_description')->nullable();
            $table->timestamps();
        });

        Schema::create('trivia_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('question_title');
            $table->string('question_photo')->nullable();
            $table->text('question_description')->nullable();
            $table->timestamps();
        });

        Schema::create('trivia_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trivia_question_id');
            $table->string('answer_title');
            $table->string('answer_photo')->nullable();
            $table->tinyInteger('correct_answer')->default(0);
        });

        Schema::create('trivia_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('result_title');
            $table->string('result_photo')->nullable();
            $table->text('result_description')->nullable();
            $table->integer('min')->default(0);
            $table->integer('max')->default(0);
            $table->timestamps();
        });

        Schema::create('short_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('item_title');
            $table->string('item_photo')->nullable();
            $table->text('item_description')->nullable();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('photo');
        });

        Schema::create('poll_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_question_id');
            $table->unsignedBigInteger('poll_answer_id');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->string('photo')->nullable();
            $table->string('zip')->nullable();
            $table->text('residency')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('verification_link')->nullable();
            $table->string('affilate_code')->nullable();
            $table->tinyInteger('is_provider')->default(0);
            $table->tinyInteger('twofa')->default(0);
            $table->tinyInteger('go')->default(0);
            $table->text('details')->nullable();
            $table->tinyInteger('verified')->default(0);
            $table->string('email_verified', 10)->default('No');
        });

        Schema::create('fonts', function (Blueprint $table) {
            $table->id();
            $table->string('font_family');
            $table->string('font_value');
            $table->tinyInteger('is_default')->default(0);
            $table->timestamps();
        });

        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('views');
        Schema::dropIfExists('poll_results');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('short_lists');
        Schema::dropIfExists('trivia_results');
        Schema::dropIfExists('trivia_answers');
        Schema::dropIfExists('trivia_questions');
        Schema::dropIfExists('personality_results');
        Schema::dropIfExists('personality_answers');
        Schema::dropIfExists('personality_questions');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('rss_feeds');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('widgets');
        Schema::dropIfExists('poll_answers');
        Schema::dropIfExists('poll_questions');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('widget_settings');
        Schema::dropIfExists('socialsettings');
        Schema::dropIfExists('seotools');
        Schema::dropIfExists('generalsettings');
    }
};
