<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\GeneralSettings;
use App\Models\ImageAlbum;
use App\Models\Language;
use App\Models\Page;
use App\Models\PollQuestion;
use App\Models\Post;
use App\Models\Rss;
use App\Models\SocialLink;
use App\Models\View;
use App\Models\Widget;
use App\Models\WidgetSetiings;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class FrontendController extends Controller
{

    public function __construct()
    {
    }

    public function index(){
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
        $sliders         = Post::orderBy('id','desc')
                                ->where('is_slider',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('schedule_post',0)
                                ->skip(1)
								->take(6)
                                ->get();
        $sliders1         = Post::orderBy('id','desc')
                                ->where('is_slider',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('schedule_post',0)
								->take(1)
                                ->get();      

        $vide_card         = Post::orderBy('id','desc')
                                ->where('is_videoGallery',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('schedule_post',0)
								->take(10)
                                ->get();   


								
        $sliders2         = Post::orderBy('id','desc')
                                ->where('is_slider',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('schedule_post',0)
                                ->skip(8)
								->take(7)
                                ->get();                      
                                

       $slider_lefts    = Post::orderBy('created_at','desc')
                                ->where('slider_left',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->take(2)
                                ->get();

        $slider_rights_firsts   = Post::orderBy('id','desc')
                                ->where('slider_right',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->take(9)
                                ->get();

        $slider_rights_seconds   = Post::orderBy('id','desc')
                                ->where('slider_right',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->skip(2)
                                ->take(1)
                                ->get();
     $slider_rights_seconds1   = Post::orderBy('id','desc')
                                ->where('slider_right',1)
                                ->where('status','true')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->skip(2)
                                ->take(10)
                                ->get();						

        $home_page_posts = Category::orderBy('category_order','asc')
                                ->where('show_at_homepage',1)
                                ->where('parent_id','=',null)
                                ->where('language_id','=',$default_language->id)
                                ->get();

        $is_recents      = Post::orderBy('id','desc')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
								->skip(5)
                                ->take(20)
                                ->get();
								
        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(5)
                                ->get();
								
	    $is_trendings1    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();

					$sportscat=DB::table('categories')->where('parent_id',null)->skip(8)->first();
					$sportscatpostbig=DB::table('posts')->where('category_id',$sportscat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(3)->get();
					$sportscatpostsmall=DB::table('posts')->where('category_id',$sportscat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(3)->get();
					$secondcat1=DB::table('categories')->where('parent_id',null)->skip(1)->first();
					$secondcatpostbig1=DB::table('posts')->where('category_id',$secondcat1->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$secondcatpostsmall1=DB::table('posts')->where('category_id',$secondcat1->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(4)->get();
					$fifthcat=DB::table('categories')->where('parent_id',null)->skip(4)->first();
					$fifthcatpostbig=DB::table('posts')->where('category_id',$fifthcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$fifthcatpostsmall=DB::table('posts')->where('category_id',$fifthcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(6)->get();
        			$mediacat=DB::table('categories')->where('parent_id',null)->skip(9)->first();
					$mediacatpostbig=DB::table('posts')->where('category_id',$mediacat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(2)->get();
					$mediacatpostsmall=DB::table('posts')->where('category_id',$mediacat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(3)->get();
		
					$thirdcat=DB::table('categories')->where('parent_id',null)->skip(2)->first();
					$thirdcatpostbig=DB::table('posts')->where('category_id',$thirdcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$thirdcatpostsmall=DB::table('posts')->where('category_id',$thirdcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(8)->get();	
					$fourthcat=DB::table('categories')->where('parent_id',null)->skip(3)->first();
					$fourthcatpostbig=DB::table('posts')->where('category_id',$fourthcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$fourthcatpostsmall=DB::table('posts')->where('category_id',$fourthcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(2)->get();
		            $fourthcatpostsmall2=DB::table('posts')->where('category_id',$fourthcat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(3)->limit(4)->get();
					$campuscat=DB::table('categories')->where('parent_id',null)->skip(6)->first();
					$campuscatpostbig=DB::table('posts')->where('category_id',$campuscat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$campuscatpostsmall=DB::table('posts')->where('category_id',$campuscat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(2)->get();
					$secondcampuscatpostsmall=DB::table('posts')->where('category_id',$campuscat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(2)->limit(2)->get();
							$binodoncat=DB::table('categories')->where('parent_id',null)->skip(7)->first();
					$binodoncatpostbig=DB::table('posts')->where('category_id',$binodoncat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->limit(1)->get();
					$binodoncatpostsmall=DB::table('posts')->where('category_id',$binodoncat->id ?? 'Not Found')->where('is_trending',1)->orderBy('id','DESC')->skip(1)->limit(10)->get();
		
		
		
		$is_breaking = '';
        foreach ( $is_trendings as $is_trending) {
            $is_breaking .= '<span>&#9758;</span> '.$is_trending->title;
        }

       $more_news  = Post::orderBy('id','desc')
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('language_id','=',$default_language->id)
                            ->latest()
                            ->take(5)
                            ->get();

       $is_features = Post::orderBy('id','desc')
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('is_feature',1)
                            ->where('language_id','=',$default_language->id)
                            ->latest()
                            ->take(1)
                            ->get();
							
		 $is_features1 = Post::orderBy('id','desc')
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('is_feature',1)
                            ->where('language_id','=',$default_language->id)
                            ->latest()
							->skip(1)
                            ->take(4)
                            ->get();	

							

        $video_large    = Post::where('post_type','=','video')
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('is_videoGallery',1)
                            ->where('language_id','=',$default_language->id)
                            ->latest()
                            ->take(1)
                            ->first();

       $video_smalls    = Post::where('post_type','=','video')
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('is_videoGallery',1)
                            ->where('language_id','=',$default_language->id)
                            ->latest()
                            ->take(6)
                            ->get();

        $sponsor_banners   = Advertisement::inRandomOrder()
                            ->where('add_placement','sponsor')
                            ->where('addSize','size_468')
                            ->where('status',1)
                            ->take(2)
                            ->get();

       $polls   = PollQuestion::orderBy('id','desc')
                                ->where('status','1')
                                ->where('language_id','=',$default_language->id)
                                ->get();
        $ws      = WidgetSetiings::find(1);
        $widgets = Widget::where('status',1)
                          ->where('language_id','=',$default_language->id)
                          ->orderBy('id','desc')
                          ->get();
        $image_albums1 = ImageAlbum::orderBy('id','desc')->where('language_id','=',$default_language->id)->take(1)->get();
        $image_albums = ImageAlbum::orderBy('id','desc')->where('language_id','=',$default_language->id)->get();

        $gs = GeneralSettings::find(1);
        return view('frontend.index',compact('sliders','binodoncat','binodoncatpostbig','binodoncatpostsmall','campuscat','campuscatpostbig','campuscatpostsmall','secondcampuscatpostsmall','fourthcat','fourthcatpostbig','fourthcatpostsmall','fourthcatpostsmall2','thirdcat','thirdcatpostbig','thirdcatpostsmall','mediacat','mediacatpostbig','mediacatpostsmall','fifthcatpostsmall','fifthcatpostbig','fifthcat','secondcat1','secondcatpostbig1','secondcatpostsmall1','sportscat','sportscatpostbig','sportscatpostsmall','is_trendings1','vide_card','is_features1','slider_rights_seconds1','image_albums1','sliders2','sliders1','slider_lefts','slider_rights_firsts','slider_rights_seconds','home_page_posts','is_features','is_recents','is_trendings','is_breaking','more_news','video_large','video_smalls','polls','ws','image_albums','sponsor_banners','widgets'));
    }

    public function loadMore(Request $request){
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
       $last_news = $request->last_news;
       $datas = Post::where('id','<',$last_news)
                            ->where('is_pending',0)
                            ->where('status','true')
                            ->where('schedule_post',0)
                            ->where('language_id','=',$default_language->id)
                            ->latest('id')
                            ->take(2)
                            ->get();

        $ajaxData['id'] = '';
        $ajaxData['output'] = '';

        foreach($datas as $data){

            if ($data->image_big){
                $img = '<img src="'.asset('assets/images/post/'.$data->image_big).'" alt="">';
            }
            else  {
                $img = '<img src="'.$data->rss_image.'" alt="">';
            }
            $str = strlen($data->title)>30 ? mb_substr($data->title,0,30,'utf-8').'...' : $data->title;
            $content = strlen(convertUtf8(strip_tags($data->description))) > 200 ? convertUtf8(substr(strip_tags($data->description), 0, 200)) . '...' : convertUtf8(strip_tags($data->description));
            $url = route('frontend.postBySubcategory.details',[$data->category->slug,$data->slug]);
            $date = route('frontend.postByDate').'?date='.$data->created_at->format('Y-m-d');

            $ajaxData['id'] = $data->id;
            $ajaxData['output'] .= '<div class="single-news land-scap-medium">
                            <div class="img">
                                <div class="tag" style="background:'.$data->category->color.'">
                                    '.$data->category->title.'
                                </div>'.$img.'
                            </div>
                            <div class="content">
                                <a href="'.$url.'">
                                    <h4 class="title">'.$str.'</h4>
                                     <p class="text">'.$content.'</p>
                                </a>
                                <ul class="post-meta">
                                    <li>
                                        <a href="'.$date.'">'.$data->createdAt().'</a>
                                    </li>
                                    <li>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="#">
                                            '.$data->admin->name.'
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>';
        }
        return $ajaxData;
    }

    public function category($slug){
	if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
	   $is_recents      = Post::orderBy('id','desc')
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
								->skip(5)
                                ->take(20)
                                ->get();
								
        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $data = Category::where('slug',$slug)->first();
        if($data){
            $posts = $data->posts()
                      ->where('schedule_post','=',0)
                      ->where('is_pending',0)
                      ->where('status','true')
                      ->orderBy('id','desc')
                      ->paginate(9);
			
			$posts1 = $data->posts()
                      ->where('schedule_post','=',0)
                      ->where('is_pending',0)
                      ->where('status','true')
                      ->orderBy('id','desc')
                      ->take(1)
                      ->get();

			$posts2 = $data->posts()
                      ->where('schedule_post','=',0)
                      ->where('is_pending',0)
                      ->where('status','true')
                      ->orderBy('id','desc')
					  ->skip(1)
                      ->take(4)
                      ->get();					  
            
			$posts = $data->posts()
                      ->where('schedule_post','=',0)
                      ->where('is_pending',0)
                      ->where('status','true')
                      ->orderBy('id','desc')
					  ->skip(5)
                      ->paginate(5);



					  
            return view('frontend.category',compact('data','posts2','posts1','posts','is_recents','is_trendings'));
        }
        return view('errors.404');
    }

    public function details(Request $request,$category,$slug){
		        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
        if(Category::where('slug',$slug)->exists()){
            if(session()->has('language')){
                $default_language = Language::find(session()->get('language'));
            }else{

                $default_language = Language::where('is_default',1)->first();
            }

        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
           $data['parent'] = Category::where('slug',$category)->first();

           if(isset(Category::where('slug',$slug)->first()->title)){
                $data['subcategory'] = Category::where('slug',$slug)->first()->title;
           }else{
                return view('errors.404');
           }

           $cat_id = Category::where('slug',$slug)->first();
		   


        $data['datas'] = Category::find($cat_id->id)
                         ->subcategoryPosts()
                         ->where('is_pending',0)
                         ->where('status','true')
                         ->where('schedule_post',0)
                         ->where('language_id','=',$default_language->id)
                         ->paginate(9);	
			
            return view('frontend.postBySubcategory',$data,compact ('is_trendings'));
        }





        if(Post::where('slug',$slug)->where('is_pending',0)->where('status','true')->exists()){
            $data = Post::where('slug',$slug)->where('is_pending',0)->where('status','true')->first();
                    $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
			$ws = WidgetSetiings::find(1);
            if($data){
                $ip_address = $request->ip();
                $is_view = View::where('post_id',$data->id)->where('ip_address',$ip_address)->first();
                if(empty($is_view)){
                    $view = new View();
                    $view->post_id = $data->id;
                    $view->ip_address = $ip_address;
                    $view->save();
                }
                if($data->post_type == 'Trivia Quiz'){
                    return view('frontend.quiz',compact('data','ws'));
                }elseif($data->post_type == 'Sorted List'){
                    return view('frontend.sort',compact('data','ws'));
                }elseif($data->post_type == 'Personality Quiz'){
                    return view('frontend.personality',compact('data','is_trendings','ws'));
                }
                return view('frontend.details',compact('data','is_trendings','ws'));
            }else{
                return redirect()->back();
            }
        }else{
            return view('errors.404');
        }

    }
	
	
	
	    public function print(Request $request,$category,$slug){
        if(Category::where('slug',$slug)->exists()){
            if(session()->has('language')){
                $default_language = Language::find(session()->get('language'));
            }else{

                $default_language = Language::where('is_default',1)->first();
            }

           $data['parent'] = Category::where('slug',$category)->first();

           if(isset(Category::where('slug',$slug)->first()->title)){
                $data['subcategory'] = Category::where('slug',$slug)->first()->title;
           }else{
                return view('errors.404');
           }

           $cat_id = Category::where('slug',$slug)->first();
		   
        $data['datas'] = Category::find($cat_id->id)
                         ->subcategoryPosts()
                         ->where('is_pending',0)
                         ->where('status','true')
                         ->where('schedule_post',0)
                         ->where('language_id','=',$default_language->id)
                         ->get();
            return view('frontend.print',$data);
        }

        if(Post::where('slug',$slug)->where('is_pending',0)->where('status','true')->exists()){
            $data = Post::where('slug',$slug)->where('is_pending',0)->where('status','true')->first();
            $ws = WidgetSetiings::find(1);
            if($data){
                $ip_address = $request->ip();
                $is_view = View::where('post_id',$data->id)->where('ip_address',$ip_address)->first();
                if(empty($is_view)){
                    $view = new View();
                    $view->post_id = $data->id;
                    $view->ip_address = $ip_address;
                    $view->save();
                }
                if($data->post_type == 'Trivia Quiz'){
                    return view('frontend.quiz',compact('data','ws'));
                }elseif($data->post_type == 'Sorted List'){
                    return view('frontend.sort',compact('data','ws'));
                }elseif($data->post_type == 'Personality Quiz'){
                    return view('frontend.personality',compact('data','ws'));
                }
                return view('frontend.print',compact('data','ws'));
            }else{
                return redirect()->back();
            }
        }else{
            return view('errors.404');
        }

    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    public function searchByTag($s){
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
		        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
								
        $datas  = Post::where('tags','LIKE','%'.$s.'%')->where('is_pending',0)
                        ->where('status','true')
                        ->where('schedule_post',0)
                        ->where('language_id','=',$default_language->id)
                        ->get();
        $tag    = $s;
        return view('frontend.postByTag',compact('datas','tag','is_trendings'));
    }

    public function postByDate(Request $request){
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
        if($request->date){
            $date = $request->date;
            $dateSearch = Carbon::parse($date)->toDateString();
        }
        $datas = Post::whereDate('created_at','=',$dateSearch)
                        ->where('is_pending',0)
                        ->where('status','true')
                        ->where('schedule_post',0)
                        ->where('language_id','=',$default_language->id)
                        ->paginate(10);
        return view('frontend.postByDate',compact('datas','date'));
    }

    public function postBySubcategory($category,$subcategory){
		
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
       $data['parent'] = Category::where('slug',$category)->first();

       if(isset(Category::where('slug',$subcategory)->first()->title)){
            $data['subcategory'] = Category::where('slug',$subcategory)->first()->title;
       }else{
            return view('errors.404');
       }

       $cat_id = Category::where('slug',$subcategory)->first();
       $data['datas'] = Category::find($cat_id->id)
                        ->subcategoryPosts()
                        ->where('status','true')
                        ->where('schedule_post',0)
                        ->where('language_id','=',$default_language->id)
                        ->get();
        return view('frontend.postBySubcategory',$data);
    }

    public function allPoll(){
        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
        $data['polls']   = PollQuestion::orderBy('id','desc')
                                ->where('language_id','=',$default_language->id)
                                ->get();


        return view('frontend.all_poll',$data);
    }



    public function reporter(Request $request){
		        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
				        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $searchTerm = $request->search;
        $data['results'] = Post::where('title','LIKE','%'.$searchTerm.'%')->where('is_pending',0)->where('schedule_post',0)->where('status','true')->paginate(10);
        $data['searchKey'] = $searchTerm;
		
        return view('frontend.reporter',$data,compact('is_trendings'));
    }





    public function photo(Request $request){
		        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
				        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $searchTerm = $request->search;
        $data['results'] = Post::where('title','LIKE','%'.$searchTerm.'%')->where('is_pending',0)->where('schedule_post',0)->where('status','true')->paginate(10);
        $data['searchKey'] = $searchTerm;
		
        return view('frontend.photo',$data,compact('is_trendings'));
    }





    public function video(Request $request){
		        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
				        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $searchTerm = $request->search;
        $data['results'] = Post::where('title','LIKE','%'.$searchTerm.'%')->where('is_pending',0)->where('schedule_post',0)->where('status','true')->paginate(10);
        $data['searchKey'] = $searchTerm;
		
        return view('frontend.video',$data,compact('is_trendings'));
    }











    public function newsSearch(Request $request){
		        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
		
				        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $searchTerm = $request->search;
        $data['results'] = Post::where('title','LIKE','%'.$searchTerm.'%')->where('is_pending',0)->where('schedule_post',0)->where('status','true')->paginate(10);
        $data['searchKey'] = $searchTerm;

        if($request->ajax()){
            return view('frontend.partials.search_results',$data);
        }

        return view('frontend.full_text_search',$data,compact('is_trendings'));
    }

    public function page($slug){
				        if(session()->has('language')){
            $default_language = Language::find(session()->get('language'));
        }else{

            $default_language = Language::where('is_default',1)->first();
        }
						        $is_trendings    = Post::where('is_trending',1)
                                ->where('is_pending',0)
                                ->where('schedule_post',0)
                                ->where('language_id','=',$default_language->id)
                                ->where('status','true')
                                ->orderBy('id','desc')
								->take(20)
                                ->get();
        $data['page'] = Page::where('slug',$slug)->first();
        if($data['page'] && $data['page']->status==1){
            $data['ws']      = WidgetSetiings::find(1);
            return view('frontend.page',$data,compact('is_trendings'));
        }else{
            return redirect()->route('frontend.index');
        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    public function language($id){
        Session::put('language', $id);
        return redirect()->route('frontend.index');
    }

    public function authorProfile($admin){
        $admin = Admin::where('name',$admin)->first();
        if(!$admin) return view('errors.404');
        $data['admin'] = $admin;
        $data['posts'] = $admin->posts()->latest()->paginate(8);
        $data['all_posts'] = $admin->posts;
        return view('frontend.author',$data);
    }

    public function follower(){
        return view('frontend.follower');
    }

    // Refresh Capcha Code
    public function refresh_code (){
        $this->code_image();
        return "done";
    }

    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

    function finalize(){
        $actual_path = str_replace('project','',base_path());

        $dir = $actual_path.'install';
        if(is_dir($dir)){
            $this->deleteDir($dir);
        }
        return redirect('/');
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function clickCount($id){
        $data = Advertisement::findOrFail($id);
        $data->increment('click_count');
        $data->update();
    }

    public function cronJobUpdate(){
        $nowDate = Carbon::now();

        $feeds = Rss::orderBy('id','desc')->get();

        foreach($feeds as $key=>$lastRecord){
            if($nowDate>$lastRecord->created_at){

                $feed = \Feeds::make($lastRecord->feed_url);

                $items = $feed->get_items(); //grab all items inside the rss
                $i =0;
                foreach($items as $item):

                    if($i==$lastRecord->post_limit){
                        break;
                    }

                    $title =  $item->get_title();
                    if($title){
                        $titleCheck = Post::where('title',$title)->get();
                        $totaltitle =  count($titleCheck);
                        if($totaltitle == 0){
                            $post = new Post();
                            $post->language_id  = $lastRecord->language_id;
                            $post->title        = $title;
                            $post->slug         = slug_create($title);
                            $post->post_type    = 'rss';
                            $post->is_feature   = 0;
                            $post->is_slider    = 0;
                            $post->slider_left  = 0;
                            $post->slider_right = 0;
                            $post->is_trending  = 0;
                            $post->description  = $item->get_description();

                            if(isset($item->feed->data["child"][""]["rss"][0]["child"][""]["channel"][0]["child"][""]["item"][$i]["child"][""]["image"][0]["data"])){
                                $post->rss_image = $item->feed->data["child"][""]["rss"][0]["child"][""]["channel"][0]["child"][""]["item"][$i]["child"][""]["image"][0]["data"];
                            }else{
                                if ($enclosure = $item->get_enclosure(0)) {
                                    $type = $enclosure->get_real_type();
                                    // Is it a Image?
                                    if (stristr($type, 'image/')) {
                                        if (empty($enclosure)) {
                                            $post->rss_image = '';
                                        }

                                    $post->rss_image = $enclosure->get_link();
                                    }
                                }
                            }

                            $post->category_id        = $lastRecord->category_id;
                            $post->schedule_post      = 0;
                            $post->schedule_post_date = NULL;
                            $post->is_pending         = 0;
                            $post->admin_id           = 1;
                            $post->status             = true;
                            $post->is_draft           = 0;
                            $post->rss_link           = $item->get_permalink();
                            $post->save();
                        }

                    }
                        $i++;
                endforeach;
            }

        }
        // return redirect()->route('frontend.index');
    }

}
