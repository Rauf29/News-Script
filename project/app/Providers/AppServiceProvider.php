<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GeneralSettings;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App;
use App\Models\Font;
use App\Models\Language;
use App\Models\SocialLink;
use App\Models\View;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer(['*'],function($view){

            if (Session::has('language'))
            {
                if (\Request::is('admin/*')) {
                    $data = DB::table('admin_languages')->where('is_default','=',1)->first();
                    if ($data) {
                        App::setlocale($data->name);
                    }
                }else {
                    $data = DB::table('languages')->find(Session::get('language'));
                    if ($data) {
                        App::setlocale($data->name);
                    }
                }
            }

            else{

                if (\Request::is('admin/*')) {
                    $a_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
                    if ($a_lang) {
                        App::setlocale($a_lang->name);
                    }

                }else {
                    $language = DB::table('languages')->where('is_default','=',1)->first();
                    if ($language) {
                        App::setlocale($language->name);
                    }
                }
            }


            $gs = GeneralSettings::find(1);
            $seo = DB::table('seotools')->first();
            if(session()->has('language')){
                $default_language = Language::find(session()->get('language'));
            }else{

                $default_language = Language::where('is_default',1)->first();
            }

            if ($default_language) {
                $categories = Category::orderBy('category_order','asc')
                                            ->where('language_id','=',$default_language->id)
                                            ->where('parent_id','=',null)
                                            ->where('show_on_menu','=',1)
                                            ->get();

                $is_trendings = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
                                ->take(20)
                                ->get();
            } else {
                $categories = collect();
                $is_trendings = collect();
            }

            $social_links = SocialLink::orderBy('id','desc')->get();
            $languages    = Language::orderBy('id','desc')->get();

            $top_views    = DB::table('views')
                                        ->select(DB::raw('count(*) as top_viwes, post_id'))
                                        ->groupBy('post_id')
                                        ->orderBy('top_viwes','desc')
                                        ->take(6)
                                        ->get();

            $default_font = Font::where('is_default',1)->first();
            $tags = $gs ? explode(',',$gs->tags) : [];
            $view->with('gs',$gs);
            $view->with('seo',$seo);
            $view->with('categories',$categories);
            $view->with('social_links',$social_links);
            $view->with('top_views',$top_views);
            $view->with('tags',$tags);
            $view->with('default_language',$default_language);
            $view->with('default_font',$default_font);
            $view->with('languages',$languages);
            $view->with('is_trendings',$is_trendings);
        });


    }
}
