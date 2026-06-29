<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_albums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->string('photo')->nullable();
            $table->string('album_name')->unique();
        });

        Schema::create('image_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('image_album_id');
            $table->string('name')->unique();
        });

        Schema::create('image_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('image_album_id');
            $table->unsignedBigInteger('image_category_id');
            $table->string('gallery');
        });

        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id')->unique();
            $table->string('header_logo')->nullable();
            $table->string('footer_logo')->nullable();
        });

        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('add_placement')->nullable();
            $table->string('banner_type')->nullable();
            $table->string('addSize')->nullable();
            $table->string('photo')->nullable();
            $table->text('banner_code')->nullable();
            $table->text('link')->nullable();
            $table->tinyInteger('status')->default(0);
        });

        Schema::create('admin_languages', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->string('name');
            $table->string('file');
            $table->tinyInteger('rtl')->default(0);
            $table->tinyInteger('is_default')->default(0);
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('follower_id');
        });

        Schema::create('social_providers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('provider_id');
            $table->string('provider');
            $table->timestamps();
        });

        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('email_type')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
        Schema::dropIfExists('social_providers');
        Schema::dropIfExists('follows');
        Schema::dropIfExists('admin_languages');
        Schema::dropIfExists('advertisements');
        Schema::dropIfExists('logos');
        Schema::dropIfExists('image_galleries');
        Schema::dropIfExists('image_categories');
        Schema::dropIfExists('image_albums');
    }
};
