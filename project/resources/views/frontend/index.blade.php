@extends('layouts.front')
@section('contents')
@section('meta')
<meta name="Description" content="{!! $seo->meta_description !!}">
<meta name="Keywords" content="{!! $seo->meta_keys !!}">
<meta property="og:title" content="{{ $gs->title }}" />
<meta property="og:description" content="{!! $seo->meta_description !!}" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection

               <section id="top-lead-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-9">
                <section id="leadSection">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="lead_heaight mb-3">
                                        <div class="common-border-box">
                                            <div class="lead-news topfirst-leadnews" id="lead-news">
                                                      
													  
													  @foreach ($sliders1 as $slider1)
													  <div class="flex-content position-relative" id="flex-left-image">
                                                    <div class="d-flex mobile_clmn">
                                                        <div class="flex-shrink-0">

                                                            <div class="img-content position-relative text-center">
                                                                <span class="imgWrep">
                                                                    <img width="500" height="280" src="{{asset('assets/images/post/'.$slider1->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" fetchpriority="high" srcset="{{asset('assets/images/post/'.$slider1->image_big)}} 500w, {{asset('assets/images/post/'.$slider1->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h4 class="title">
                                                               {{strlen($slider1->title)>100 ? mb_substr($slider1->title,0,100,"utf-8") : $slider1->title}}                                                           </h4>
                                                            <div class="summery">
                                                                {{strlen($slider1->short_description)>100 ? mb_substr($slider1->short_description,0,100,"utf-8") : $slider1->short_description}} পাশাপাশি ফুটতে থাকে পটকা। শব্দে&hellip;                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$slider1->category->slug,$slider1->slug])}}">
                                                    </a>
                                                </div>
												
												@endforeach
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="common-border-box mt-3 mb-3">
                                        <div class="row sub-news">
                                         
										 @foreach ($sliders as $slider)
										 <div class="col-6 col-lg-4">
                                                <div class="common-card-content position-relative ">
                                                    <div class="image-lead position-relative text-center">
                                                        <span class="imgWrep">
                                                            <img width="500" height="280" src="{{asset('assets/images/post/'.$slider->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$slider->image_big)}} 500w, {{asset('assets/images/post/'.$slider->image_big)}} 300w, {{asset('assets/images/post/'.$slider->image_big)}} 768w, {{asset('assets/images/post/'.$slider->image_big)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                        </span>
                                                        <a class="link" href="{{ route('frontend.postBySubcategory.details',[$slider->category->slug,$slider->slug])}}"></a>
                                                    </div>
                                                    <div class="news-content-box">

                                                        <div class="position-relative">
                                                            <h5 class="title">
                                                                {{strlen($slider->title)>40 ? mb_substr($slider->title,0,40,"utf-8") : $slider->title}}                                                            </h5>
                                                            <a class="link" href="{{ route('frontend.postBySubcategory.details',[$slider->category->slug,$slider->slug])}}"></a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                          @endforeach
										  
										  
										  
										  
										  
                                                                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4">
                            <div class="common-border-box">
                                <div class="selected-news">
                                                                        


  @foreach ($sliders2 as $slider2)  
                                    <div class="sub-news">
                                        <div class="flex-content position-relative" id="flex-left-image">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$slider2->category->slug,$slider2->slug])}}">
                                                        <div class="img-content position-relative text-center">
                                                            <span class="imgWrep">
                                                                <img width="500" height="280" src="{{asset('assets/images/post/'.$slider2->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$slider2->image_big)}} 500w, {{asset('assets/images/post/'.$slider2->image_big)}} 300w, {{asset('assets/images/post/'.$slider2->image_big)}} 768w, {{asset('assets/images/post/'.$slider2->image_big)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                            </span>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$slider2->category->slug,$slider2->slug])}}">
                                                        <h4 class="title">{{strlen($slider2->title)>100 ? mb_substr($slider2->title,0,100,"utf-8") : $slider2->title}}</h4>
                                                    </a>

                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
@endforeach
                                    
									
									
									
									
									
									
									
									
									
                                    
                                
                                </div>
                            </div>
                        </div>
                </section>
            </div>

            <div class="col-12 col-md-3">
                                                    <div style="width: 100%; max-width: 100%; min-height: 100px; border: 0px; padding: 0; overflow: hidden; background-color: transparent; text-align: center !important;">
                                        {!! $gs->sidebar_ads1 !!}
									   </div>
                                      <div class="common-border-box">
                    <div class="tab_block_stories">
                        <div class="tab_bar_block_stories">
                            <ul>
                                <li class="active" data-id="video">
                                    <img style="width:20px; margin-right: 5px" src="{{asset('assets/frontend/assets/images/video-stories.png')}}">
                                    <a _href="https://news.banglawebs.com/news01/archives/videogallery">
                                        ভিডিও স্টোরি
                                    </a>
                                </li>

                                <li data-id="photo">
                                    <img style="width:20px; margin-right: 5px" src="{{asset('assets/frontend/assets/images/photo-stories.png')}}">
                                    <a _href="https://news.banglawebs.com/news01/archives/photogallery">
                                        ফটো স্টোরি
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab_block_view_stories">
                            <div data="video-view">
                                <div class="flexslider m-0 border-0" id="videostories">
                                    
                                <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 1000%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
                                     
									  @foreach ($vide_card as $video_card)
									 <li style="width: 220px; margin-right: 7px; float: left; display: block;">
                                            <a href="{{route('frontend.postBySubcategory.details',[$video_card->category->slug,$video_card->slug])}}">
                                                <div class="vidstocovr" style="background:url({{asset('assets/images/post/'.$video_card->image_big)}});background-size: cover;background-position: center;height:415px">

                                                    <img src="{{asset('assets/frontend/assets/images/play-button-80X80.png')}}" class="play-icon" draggable="false">
                                                </div>
                                                <div class="album_name">{{strlen($video_card->title)>60 ? mb_substr($video_card->title,0,60,"utf-8") : $video_card->title}}</div>
                                            </a>
                                        </li>
                                              	@endforeach                                
																			  
																			  
																			  
                                                                            </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1"></a></li><li class="flex-nav-next"><a class="flex-next" href="#"></a></li></ul></div>
                            </div>

                            <div data="photo-view" style="display: none;">
                                <div class="flexslider m-0 border-0" id="photoStories">
                                    
                                <div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 600%; transition-duration: 0s;">
                            
							@foreach ($sliders as $slider)  
							<li style="width: 0px; margin-right: 7px; float: left; display: block;">
                                            <div class="webstories">
                                                <a href="{{ route('frontend.postBySubcategory.details',[$slider->category->slug,$slider->slug])}}" class="font-light">
                                                    <div class="vidstocovr" style="background:url({{asset('assets/images/post/'.$slider->image_big)}});background-size: cover;background-position: center;height:415px">

                                                        <img src="{{asset('assets/frontend/assets/images/photo-story.png')}}" class="photo-icon" draggable="false">
                                                    </div>
                                                </a>
                                                <div class="album_name">
                                                    <a href="{{ route('frontend.postBySubcategory.details',[$slider->category->slug,$slider->slug])}}" class="font-light">
                                                       {{strlen($slider->title)>100 ? mb_substr($slider->title,0,100,"utf-8") : $slider->title}}                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                          @endforeach                                      
																				
																				
                                        
                                    </ul></div><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1"></a></li><li class="flex-nav-next"><a class="flex-next" href="#"></a></li></ul></div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .tab_bar_block_stories ul {
                            display: table;
                            margin: 0;
                            padding: 0;
                            width: 100%;
                            margin-bottom: 10px;
                        }

                        .tab_bar_block_stories li {
                            display: table-cell;
                            width: 50%;
                            position: relative;
                            padding-bottom: 5px;
                            border-bottom: 2px solid #ebebeb;
                            bottom: -2px;
                            cursor: pointer;
                        }

                        .tab_bar_block_stories li a {
                            font-size: 17px;
                            font-weight: bold;
                        }

                        .tab_bar_block_stories li.active {
                            border-bottom: 3px solid #c3282d;
                        }

                        .tab_bar_block_stories svg {
                            width: 22px;
                            height: auto;
                            margin-right: 5px;
                        }
                    </style>
                </div>
                            </div>
        </div>

    </div>
</section>


<section class="bg-white mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="common-border-box h-100">

                    <section id="video-gallery">

                        <div class=" d-flex justify-content-between pb-2">
                            <div class="title">
                                <img style="width:20px; margin-right: 18px;margin-top: -5px;"
                                    src="{{asset('assets/frontend/assets/images/video-stories.png')}}">
                                <a href="{{ URL::to('/video') }}">ভিডিও </a>
                            </div>
                            <div class="more">
                                <a href="{{ URL::to('/video') }}">সব ভিডিও
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="flexslider" id="videoFlex">
                            <ul class="slides">

                            
							
														@foreach ($video_smalls as $video_small)	
							<li class="video mb-3 position-relative">
                                    <a href="{{ route('frontend.postBySubcategory.details',[$video_small->id,$video_small->slug])}}">
                                        <div class="text-center vid-single position-relative">
                                            <img width="500" height="280" src="https://img.youtube.com/vi/{{ $video_small->embed_video ??'' }}/mqdefault.jpg" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="https://img.youtube.com/vi/{{ $video_small->embed_video ??'' }}/mqdefault.jpg 500w, https://img.youtube.com/vi/{{ $video_small->embed_video ??'' }}/mqdefault.jpg 300w, https://img.youtube.com/vi/{{ $video_small->embed_video ??'' }}/mqdefault.jpg 686w" sizes="(max-width: 500px) 100vw, 500px" />                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                        <h5 class="font-20 heading-h2 pt-2 pb-2 text-black">
                                            {{strlen($video_small->title)>60 ? mb_substr($video_small->title,0,60,"utf-8") : $video_small->title}}                                        </h5>
                                    </a>
                                    <div class="time">
                                        <i class="far fa-clock me-1"></i>
                                       প্রকাশের তারিখঃ {{$video_small->createdAt()}} ইং                                   </div>
                                </li>
									@endforeach
								
								
								
								
                                
                            </ul>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-4 mb-3">
                <style>
                    #static_opinion .menu-link {
                        font-weight: bold;
                        font-size: 18px;
                        margin-bottom: 10px;
                    }

                    #static_opinion .flex-content {
                        background: #fff9e1;
                        border-bottom: 3px solid #d60000;
                        border-radius: 5px 5px;
                        padding: 15px;
                        margin-bottom: 15px;
                    }

                    #static_opinion .flex-content .img-content {
                        height: 80px;
                        width: 80px;
                        border-radius: 50%;
                        border: 2px solid #fe0002;
                        text-align: center;
                        position: relative;
                        overflow: hidden;
                    }

                    #static_opinion .flex-content .img-content img {
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        top: 0;
                        left: 0;
                        object-fit: cover;
                    }

                    #static_opinion .rpt {
                        display: block;
                        font-weight: bold;
                        margin: 3px 0;
                    }

                    #static_opinion .rpt_dg {
                        display: block;
                        color: #797979;
                        font-size: 14px;
                        line-height: 19px;
                    }

                    #static_opinion h4.title {
                        font-size: 18px;
                        margin: 10px 0 20px 0;
                    }

                    #static_opinion .summery {
                        text-align: justify;
                        -webkit-line-clamp: 3;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        font-weight: normal;
                    }

                    #static_opinion a:hover .summery {
                        color: #000
                    }

                    #static_opinion {
                        margin-bottom: 0px;
                    }

                    #static_opinion .flex-control-nav {
                        text-align: center;
                        display: block;
                    }

                    #static_opinion .flex-content:hover h4.title {
                        color: #1a73e8 !important;
                    }
                </style>
                <div class="common-border-box h-100">
                    <section class="flexslider" id="static_opinion">
                        <div class="menu-link">
                            <a href="{{ route('frontend.category',$sportscat->slug ?? 'Not Found')}}">
                                                                                                <span>{{ $sportscat->title ?? 'Not Found'}}</span>
                            </a>
                        </div>
                        <ul class="slides">
                            <li>

                                <div class="news-separator-virticle-border"></div>

                               
							   
							   @foreach ($sportscatpostbig as $row)
							   <div class="flex-content">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-1 text-center" style="max-width: 140px">
                                            <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                <div class="img-content position-relative text-center mx-auto"><span
                                                        class="_imgWrep">
                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                <h4 class="title">{{strlen($row->title)>100 ? mb_substr($row->title,0,100,"utf-8") : $row->title}}</h4>
                                            </a>
                                            <div class="summery">
                                                {{strlen($row->short_description)>120 ? mb_substr($row->short_description,0,120,"utf-8") : $row->short_description}}&hellip;                                            </div>
                                        </div>
                                    </div>

                                </div>
                                   @endforeach                              
																
																
																
																
                                
                            </li>
                            <li>

                                <div class="news-separator-virticle-border"></div>

                                                
												
							   @foreach ($sportscatpostsmall as $row)
							   <div class="flex-content">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-1 text-center" style="max-width: 140px">
                                            <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                <div class="img-content position-relative text-center mx-auto"><span
                                                        class="_imgWrep">
                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="flex-grow-1">
                                            <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                <h4 class="title">{{strlen($row->title)>100 ? mb_substr($row->title,0,100,"utf-8") : $row->title}}</h4>
                                            </a>
                                            <div class="summery">
                                                {{strlen($row->short_description)>120 ? mb_substr($row->short_description,0,120,"utf-8") : $row->short_description}}&hellip;                                            </div>
                                        </div>
                                    </div>

                                </div>
                                   @endforeach 
                                



                                
                            </li>
                        </ul>

                    </section>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="opinion-css">
                    <style type="text/css">
                        :root {
                            --pollOptionRadioBg: #ccc;
                            --pollOptionRadioBgActive: #e3e4e8;
                            --pollOptionRadioBorder: #c7cad1;
                            --pollOptionRadioBorderActive: #c7cad1;
                        }

                        #home-online-poll .menu-link {
                            font-weight: bold;
                            font-size: 18px;
                            margin-left: 10px;
                            border-bottom: 2px solid #b32819;
                            padding-bottom: 10px;
                        }

                        #home-online-poll .menu-link a {
                            font-size: 20px;
                        }

                        .menu-link .home_menu_icon img {
                            width: 30px;
                        }

                        #home-online-poll .slides,
                        #home-online-poll .slides li {
                            width: calc(100% - 5px) !important;
                        }

                        #home-online-poll .slides>li {
                            border: 1px solid #e2e2e2;
                            border-radius: 5px;
                            padding: 15px;
                            margin: 5px;
                        }

                        #home-online-poll img.img-fluid {
                            border-radius: 5px;
                        }

                        .cat_summary_block {
                            position: relative;
                            line-height: 40px;
                        }

                        .poll_item_block {
                            display: flex;
                            width: 100%;
                            background-color: #fff
                        }

                        .poll_block {}

                        .poll_block h4 {
                            font-size: 16px;
                            line-height: 20px
                        }

                        .poll_block>p {
                            margin: 5px 0 15px 0;
                            font-size: 14px
                        }

                        .polling_submit_block {
                            display: block;
                            text-align: left;
                            padding: 0px 7px 10px 7px;
                            line-height: 28px;
                            _border: 1px solid #e2e2e2;
                            _border-top: 0px;
                            _height: 250px;
                            /*315px;*/
                        }

                        .polling_submit_block>p {
                            font-size: 15px;
                            line-height: 22px;
                            font-weight: bold;
                        }

                        .polling_submit_block .options_block {
                            display: block;
                            text-align: left
                        }

                        .polling_submit_block .options_block ul {
                            list-style: none;
                            padding: 0
                        }

                        .polling_submit_block .options_block ul li {
                            display: flex;
                            position: relative;
                            height: 22px;
                            line-height: 22px;
                            margin-bottom: 10px;
                        }

                        .polling_submit_block .options_block ul li>div {
                            align-self: center;
                        }

                        .polling_submit_block .options_block ul li>div.iconz,
                        .polling_submit_block .options_block ul li>div.input_block {
                            margin-right: 10px;
                            color: #ccc
                        }

                        .polling_submit_block .options_block ul li>div.input_block input[type=radio] {
                            position: relative;
                            top: 2px;
                            background: var(--pollOptionRadioBg);
                            border: 1px solid var(--pollOptionRadioBorder);
                            width: 1.3em;
                            height: 1.3em;
                        }

                        .polling_submit_block .options_block ul li>div.input_block input[type=radio]:active {
                            background: var(--pollOptionRadioBgActive);
                            border-color: var(--pollOptionRadioBorderActive);
                        }

                        .polling_submit_block .options_block ul li>div.title_block {
                            position: relative;
                            width: 100%;
                            height: 100%;
                            padding: 3px 12px;
                            font-size: 13px;
                            background-color: #fff;
                            border: 1px solid #000;
                            border-radius: 5px;
                            overflow: hidden;
                        }

                        .polling_submit_block .options_block ul li>div span.title {
                            display: inline-block;
                            position: absolute;
                            height: 100%;
                            left: 15px;
                            top: 0;
                            z-index: 2
                        }

                        .polling_submit_block .options_block ul li>div span.progress {
                            display: inline-block;
                            position: absolute;
                            height: 100%;
                            left: 0;
                            top: 0;
                            background-color: skyblue;
                            border-radius: 0px;
                            transition: all 0.4s;
                        }

                        .polling_submit_block .options_block ul li>div.votes {
                            position: absolute;
                            font-size: 13px;
                            right: 10px;
                            z-index: 1
                        }

                        .polling_submit_block .submit_btn {
                            _display: inline-block;
                            padding: 5px 15px;
                            background-color: #2c4b9c;
                            color: #fff;
                            font-size: 14px;
                            line-height: 22px;
                            border-radius: 5px;
                            text-align: center;
                            cursor: pointer;
                        }

                        .cat_summary_block .more_btn {
                            position: absolute;
                            right: 15px;
                            bottom: -5px;
                            font-size: 16px;
                            font-weight: bold;
                        }

                        .cat_summary_block .more_btn>a:hover {
                            color: #006699;
                        }

                        #st-1 .st-btn[data-network='facebook'] {
                            display: inline-block !important;
                        }

                        #st-3 .st-btn[data-network='facebook'] {
                            display: inline-block !important;
                        }

                        .st-total {
                            display: none !important;
                        }

                        .count {
                            background: #2c4b9c;
                            color: #fff;
                            padding: 5px 10px;
                            font-size: 14px;
                            border-radius: 5px;
                        }

                        .polling_submit_block p {
                            font-size: 18px;
                            line-height: 24px;
                            font-weight: bold;
                            margin-top: 10px;
                        }



                        #pollflex.flexslider {
                            margin: 0 !important;
                        }

                        #pollflex .flex-direction-nav a {
                            background: #6666ff;
                            border-radius: 500%;
                            font-size: 0px;
                            width: 35px;
                            height: 35px;
                        }

                        #pollflex .flex-direction-nav a:before {
                            font-family: 'FontAwesome';
                            font-size: 50px;
                            display: inline-block;
                            content: '\f060';
                            color: rgba(255, 255, 255, 0.9);
                            font-size: 24px;
                            padding: 5px;
                        }

                        #pollflex .flex-direction-nav a.flex-next:before {
                            content: '\f061';
                            font-size: 24px;

                            padding: 5px;
                        }

                        #pollflex .poll_block:hover p {
                            color: #000 !important;
                        }

                        .polling_submit_block .sharethis-inline-share-buttons .st-btn {
                            display: inline-block;
                            border-radius: 50% !important;
                            height: 40px !important;
                            width: 40px !important;
                            text-align: center !important;
                            padding: 2px !important;
                        }

                        .polling_submit_block #st-1 .st-btn>img {
                            width: 30px !important;
                            height: 27px !important;
                            top: 4px !important;
                        }

                        #home-online-poll .st-last {
                            display: none !important;
                        }

                        #download-poll ._slides {
                            list-style: none;
                            padding: 10px;
                        }

                        #download-poll .poll_time {
                            margin-bottom: 10px;
                        }

                        .poll-sahare .st-btn[data-network='copy'] {
                            display: none !important;
                        }

                        .poll-coppy .copy-link {
                            background: #14682b !important;
                            color: #fff !important;
                            border-radius: 50% !important;
                            padding: 7px 10px !important;
                        }

                        .poll_block {
                            position: relative;
                        }

                        .success {
                            position: absolute;
                            display: none;
                            bottom: 50px;
                            text-align: center;
                            justify-content: center;
                            width: 100%;
                            z-index: 100000;
                        }

                        .success>span {
                            background-color: #000000aa;
                            font-size: 13px;
                            padding: 0 15px;
                            height: 30px;
                            top: 30px;
                            align-items: center;
                            border-radius: 25px;
                            display: flex;
                            align-items: center;
                            color: #fff;
                            font-family: sans-serif;
                        }
                    </style>
                </div>

                <section id="home-online-poll" class="common-border-box h-100">
                    <div class="menu-link my-2">
                        <a href="">বিজ্ঞাপন</a>

                    </div>


{!!$gs->sidebar_adsbig!!}


                                 </section>


            </div>
            <div class="col-md-4 mb-3">

                <div class="tab_block_one common-border-box h-100">
    <div class="tab_bar_block_new">
        <ul class="list-inline mb-3">
            <li class="active" tabIndex="latest_list_block1">সর্বশেষ</li>
            <li tabIndex="popular_list_block1">জনপ্রিয়</li>
        </ul>
    </div>

    <div class="list_display_block1 box_shadow" id="latest_list_block1">
        <div id="latestview1">
         
		 
		 
		 @foreach($is_trendings1 as $is_trending)	
		 <div class="sub2-lead-content">
                <div class="d-flex">
                    <div class="flex-fill">
                        <h4 class="title">
                            <i class="fa-solid fa-angle-right"></i>
                           {{strlen($is_trending->title)>100 ? mb_substr($is_trending->title,0,100,"utf-8") : $is_trending->title}}                       </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="news_sl"> {{ $loop->iteration }}</span>
                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$is_trending->category->slug,$is_trending->slug])}}"></a>
            </div>
            <div class="news-separator-horizontal-border"></div>
			
			@endforeach
			
			
                       
					   
                    </div>
        <div style="text-align:right">
            <a class="allNews" href="">সর্বশেষ সব খবর</a>
        </div>
    </div>

    <div class="list_display_block1" id="popular_list_block1">
        <div id="mostview1">
		
		@foreach ($is_recents as $is_recent)
		
                        <div class="sub2-lead-content">
                <div class="d-flex">
                    <div class="flex-fill">
                        <h4 class="title">
                            <i class="fa-solid fa-angle-right"></i>
                           {{strlen($is_recent->title)>60 ? mb_substr($is_recent->title,0,60,"utf-8") : $is_recent->title}}                       </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="news_sl">{{ $loop->iteration }}</span>
                <a class="link" href="{{route('frontend.postBySubcategory.details',[$is_recent->category->slug,$is_recent->slug])}}"></a>
            </div>
            <div class="news-separator-horizontal-border"></div>
			  @endforeach
			
			
			
                        
            
        </div>

        <div style="text-align:right">
            <a class="allNews" href="">জনপ্রিয় সব খবর</a>
        </div>
    </div>
</div>
            </div>
            <style>
                #latestview1 .sub2-lead-content:last-child,
                #mostview1 .sub2-lead-content:last-child {
                    margin-bottom: 15px
                }

                .list_display_block1 h4.title {
                    line-height: 25px;
                    margin-bottom: 0px;
                    margin-right: _50px;
                    padding-left: 2px;
                }
            </style>

        </div>
    </div>
    <!-- ADS -->
</section>
<section class="bg-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <style>
                                    .vidicon_right_lead {
                                        style="height: 30px !important;width: auto !important;"
                                    }
                                </style>

                                <div class="home-category-content" id="bodymenu-nolead">
                                    <div class="bodymenu-link">

                                        <a href="{{ route('frontend.category',$secondcat1->slug ?? 'Not Found')}}">
                                                                                                                                    <span>{{ $secondcat1->title ?? 'Not Found'}}</span>
                                        </a>
                                        <a href="{{ route('frontend.category',$secondcat1->slug ?? 'Not Found')}}" class="float-end">
                                            <div><i class="fas fa-arrow-right"></i></div>
                                        </a>
                                    </div>
                                    <div class="row">

                                        
										
										@foreach ($secondcatpostsmall1 as $row)
										<div class="col-12 col-md-3 mb-3">
                                           
										   <div class="d ">
                                                <div
                                                    class="common-card-content position-relative common-border-box p-0">
                                                    <div class="image-lead position-relative text-center">
                                                        <span class="imgWrep">
                                                            <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                        </span>
                                                    </div>
                                                    <div class="selected-news-height p-2   p-2">
                                                        <div class="menu-link ">

                                                            <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"><span>বাছাইকৃত</span></a>

                                                        </div>
                                                        <h5 class="title">
                                                            {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}                                                        </h5>
                                                        <div class="summery d-block">
                                                            {{strlen($row->short_description)>60 ? mb_substr($row->short_description,0,60,"utf-8") : $row->short_description}}&hellip;                                                        </div>
                                                    </div>
                                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                </div>
                                            </div>
                                        </div>
										 @endforeach 
										
										
                                                                              
                                        
                                    </div>

                                </div>


                                <div class="news-separator-horizontal-border"></div>

                                <!-- ADS -->
                            </div>
                        </div>
                    </div>
                </div>
<!--Ads-->

                
                <!--Ads-->
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="home-category-content" id="bodymenuOnelead_cardNews">
                                    <div class="bodymenu-link">
                                        <a href="{{ route('frontend.category',$fifthcat->slug ?? 'Not Found')}}">
                                                                                                                                    <span>{{ $fifthcat->title ?? 'Not Found'}}</span>
                                        </a>
                                        <a href="{{ route('frontend.category',$fifthcat->slug ?? 'Not Found')}}"
                                            class="float-end">
                                            <div><i class="fas fa-arrow-right"></i></div>
                                        </a>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 news-separator-vertical-border position-relative"
                                            id="lead-lews">
                                                       @foreach ($fifthcatpostbig as $row)                                  
                                            <div style="_background: #f0f0f0; height: 100%">
                                                <div class="common-card-content position-relative ">
                                                    <div class="image-lead position-relative text-center">
                                                        <span class="imgWrep">
                                                            <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                        </span>
                                                        <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                        </a>
                                                    </div>

                                                    <div class="news-content-box">
                                                        <!-- news headline -->
                                                        <div class="position-relative">
                                                            <h5 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}ব</h5>
                                                            <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                        </div>
														 
														
														
														
														
                                                        <!-- news headline -->

                                                        <!-- summery -->
                                                        <div class="summery">
                                                           {{strlen($row->short_description)>200 ? mb_substr($row->short_description,0,200,"utf-8") : $row->short_description}}&hellip;                                                        </div>
                                                        <!-- summery -->

                                                    </div>
													@endforeach
                                                </div>
                                            </div>

                                            
                                        </div>
                                        <div class="col-md-8">

                                            <div class="row sub-news">

                                                          
														  @foreach ($fifthcatpostsmall as $row)
                                                <div class="col-lg-4 ">
                                                    <div class="common-card-content position-relative ">
                                                        <div class="image-lead position-relative text-center">
                                                            <span class="imgWrep">
                                                                <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w, https://news.banglawebs.com/news01/wp-content/uploads/2024/12/pororassto-gfghfv-768x432.webp 768w, {{asset('assets/images/post/'.$row->image_big)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                            </span>
                                                            <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                        </div>
                                                        <div class="news-content-box">
                                                            <!-- news headline -->
                                                            <div class="position-relative">
                                                                <h5 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
 @endforeach
                                                
                                              
                                                
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="news-separator-horizontal-border"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ADS -->
                        </div>
                    </div>
                </div>
                <!--Ads-->
                    <div style="min-width: 320px; min-height: 50px; border: 0px; padding: 0; overflow: hidden; background-color: transparent; text-align: center !important;">
{!!$gs->horizontal_adds1!!}           </div>
                        <!--Ads-->
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <section class="home-category-content" id="bodymenuTwolead">
                                    <div class="bodymenu-link">
                                        <a href="{{ route('frontend.category',$mediacat->slug ?? 'Not Found')}}">
                                                                                                                                    <span>{{ $mediacat->title ?? 'Not Found'}}</span>
                                        </a>
                                        <a href="{{ route('frontend.category',$mediacat->slug ?? 'Not Found')}}"
                                            class="float-end">
                                            <div><i class="fas fa-arrow-right"></i></div>
                                        </a>

                                    </div>
                                    <div class="">
                                        <div class="row">
                                            <div class="col-lg-8 news-separator-vertical-border" id="lead-news">

                                                            
													@foreach ($mediacatpostbig as $row)		
                                                <div class="flex-content position-relative" id="flex-left-image">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                <div class="img-content position-relative text-center">
                                                                    <span class="imgWrep">
                                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                <h4 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h4>
                                                            </a>
                                                            <div class="summery">
                                                                {{strlen($row->short_description)>200 ? mb_substr($row->short_description,0,200,"utf-8") : $row->short_description}}&hellip;                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
 @endforeach 
                                                
                                                

                                                
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="sub-news">
                                                        

@foreach ($mediacatpostsmall as $row)
														
                                                    <div class="flex-content position-relative" id="flex-right-image">
                                                        <h4 class="title">
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}                                                            </a>
                                                        </h4>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">

                                                                <!-- summery -->
                                                                <div class="summery d-block">
                                                                   {{strlen($row->short_description)>100 ? mb_substr($row->short_description,0,100,"utf-8") : $row->short_description}}&hellip;
                                                                </div>
                                                                <!-- summery -->

                                                            </div>
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                <div class="flex-shrink-0">
                                                                    <div
                                                                        class="img-content position-relative text-center">
                                                                        <span class="imgWrep">
                                                                            <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" />                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                        </div>

                                                    </div>

                                                     @endforeach 
                                                   
												   

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="news-separator-horizontal-border"></div>
                            </div>
                            <!-- ADS -->
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-12 col-md-3">
                <div class="text-center mt-3">
                                    </div>

                <div class="text-center mt-3">
                                    </div>

                <div class="text-center mt-3">
                                        <div id="sfp_page_plugin_widget-2" class="single-widgets widget_sfp_page_plugin_widget"><div><h2 class="widgettitle">আমাদের ফেইসবুক পেইজ</h2></div>
<div class="sfp-container">
	<div class="fb-page"
		data-href="https://www.facebook.com/{{ $gs->facebook_page_url }}/"
		data-width="280"
		data-height="800"
		data-hide-cover="false"
		data-show-facepile="true"
		data-small-header="false"
		data-tabs="timeline">
	</div>
</div>


<div class="text-center mt-3">
                                        <div id="sfp_page_plugin_widget-2" class="single-widgets widget_sfp_page_plugin_widget"><div><h2 class="widgettitle">আমাদের জাতীয় সঙ্গীত</h2></div><div id="fb-root"></div>
</div>
						<audio controls="" style="width:100%">
				 <source src="{{asset('assets/frontend/bd_national_anthem.mp3')}}" type="audio/mp3">
				</audio>         
		 {!!$gs->sidebar_big_ads3!!}


<!-- Page Plugin Code END --></div> 





                                   </div>
								   

            </div>
			
        </div>

        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="home-category-content" id="bodymenuCardNews">
                                    <div class="bodymenu-link">
                                       
                                        <a href="{{ route('frontend.category',$thirdcat->slug ?? 'Not Found')}}">
                                                                                                                                    <span>{{ $thirdcat->title ?? 'Not Found'}}</span>
                                        </a>
                                        <a href="{{ route('frontend.category',$thirdcat->slug ?? 'Not Found')}}"
                                            class="float-end">
                                            <div><i class="fas fa-arrow-right"></i></div>
                                        </a>

                                    </div>
                                    <div class="row">



                                            @foreach ($thirdcatpostsmall as $row)                                    
                                        <div class="col-lg-3 ">
                                            <div class="common-card-content position-relative ">
                                                <div class="image-lead position-relative text-center">
                                                    <span class="imgWrep">
                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                    </span>
                                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                    </a>
                                                </div>

                                                <div class="news-content-box">
                                                    <div class="position-relative">
                                                        <h5 class="title">
                                                            {{strlen($row->title)>80 ? mb_substr($row->title,0,80,"utf-8") : $row->title}}                                                       </h5>
                                                        <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
  @endforeach 
                                        
                                        

                                        
                                    </div>
                                </div>
                                <div class="news-separator-horizontal-border"></div>
                                <!-- ADS -->
                            </div>
                    <div class="col-12 col-md-3">

                <div class="text-center mt-3">
                                        <div id="media_image-2" class="single-widgets widget_media_image"><div><h2 class="widgettitle">ই &#8211; পেপার</h2></div>
										
										<a href="{{ $gs->epaper_link }}"><img width="700" height="1050" src="{{asset('assets/images/logo/'.$gs->lazy_baner)}}" class="image wp-image-79  attachment-full size-full" alt="" style="max-width: 100%; height: auto;" title="ই - পেপার" decoding="async" srcset="{{asset('assets/images/logo/'.$gs->lazy_baner)}} 700w, {{asset('assets/images/logo/'.$gs->lazy_baner)}} 200w,  683w" sizes="(max-width: 700px) 100vw, 700px" /></div>  </a>                                   </div>
                                   </div>
								   





            </div>
			
			
			
			
			
        </div>
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                        			       
                                <div class="home-category-content" id="bodymenu_leadRightimg">
                                    <div class="bodymenu-link">

                                        <a href="{{ route('frontend.category',$fourthcat->slug ?? 'Not Found')}}">
                                                                                                                                    <span>{{ $fourthcat->title ?? 'Not Found'}}</span>
                                        </a>
                                        <a href="{{ route('frontend.category',$fourthcat->slug ?? 'Not Found')}}"
                                            class="float-end">
                                            <div><i class="fas fa-arrow-right"></i></div>
                                        </a>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 news-separator-vertical-border position-relative lead-lews"
                                            id="lead-lews">

                                                                                        
                                            <div class="flex-content position-relative mb-3">

@foreach ($fourthcatpostbig as $row)
                                                <div class="d-flex mobile_clmn">
                                                    <div class="flex-grow-1">
                                                        <h4 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h4>
                                                        <!-- summery -->
                                                        <div class="summery d-block">{{strlen($row->short_description)>100 ? mb_substr($row->short_description,0,100,"utf-8") : $row->short_description}}&hellip;                                                        </div>
                                                        <!-- summery -->
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="img-content position-relative text-center">
                                                            <div class="longimg">
                                                                <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                            </div>
@endforeach
                                            


                                        </div>
                                        <div class="col-md-6">

                                            <div class="row sub-news">

                                                    @foreach ($fourthcatpostsmall as $row)                                            
                                                <div class="col-lg-6 ">
                                                    <div class="common-card-content position-relative ">
                                                        <div class="image-lead position-relative text-center">
                                                            <span class="imgWrep">
                                                                <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w, {{asset('assets/images/post/'.$row->image_big)}} 768w, {{asset('assets/images/post/'.$row->image_big)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                            </span>
                                                            <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                        </div>
                                                        <div class="news-content-box">
                                                            <!-- news headline -->
                                                            <div class="position-relative">
                                                                <h5 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                            </div>
                                                            <!-- news headline -->
                                                        </div>
                                                    </div>
                                                </div>
 @endforeach
                                                
                                                

                                                
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="news-separator-horizontal-border"></div>
                                        </div>
                                    </div>
                                    <div class="row subMore-news">



                                          @foreach ($fourthcatpostsmall2 as $row)                                      
                                        <div class="col-lg-3 ">
                                            <div class="common-card-content position-relative ">
                                                <div class="image-lead position-relative text-center">
                                                    <span class="imgWrep">
                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" />                                                    </span>
                                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                    </a>
                                                </div>
                                                <div class="news-content-box">
                                                    <!-- news headline -->
                                                    <div class="position-relative">
                                                        <h5 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                        <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                    </div>
                                                    <!-- news headline -->
                                                </div>
                                            </div>
                                        </div>
 @endforeach
                                        










                                        
                                    </div>
                                </div>
                                <div class="news-separator-horizontal-border"></div>
                            </div>
                            <!-- ADS -->
                        </div>
                    </div>
                </div>
                <!--Ads-->
                       


            </div>
            <div class="col-12 col-md-3">

                <div class="text-center mt-3">
                  <h2 class="widgettitle">বিজ্ঞাপন</h2>
		
		{!!$gs->sidebar_big_ads2!!}
		
		</div>                                    </div>
                                   </div>
								   





            </div>
			
			
			
			
			
        </div>
<!--Ads-->
                        <!--Ads-->
        <div class="row">
            <div class="col-12">
                <div class="bg-white">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <section id="sports-news">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="_news-border">
                                                <div class="bodymenu-link">
                                   




                                                    <a
                                                        href="{{ route('frontend.category',$campuscat->slug ?? 'Not Found')}}">
                                                                                                                                                                        <span>{{ $campuscat->title ?? 'Not Found'}}</span>
                                                    </a>
                                                    <a href="{{ route('frontend.category',$campuscat->slug ?? 'Not Found')}}"
                                                        class="float-end">
                                                        <div><i class="fas fa-arrow-right"></i></div>
                                                    </a>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-9">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="row sub-news">

                                                                                                                                        
                                                                    
																	
																	
																	 @foreach ($campuscatpostsmall as $row)
																	<div
                                                                        class="col-lg-12  news-separator-vertical-border">
                                                                        <div
                                                                            class="common-card-content position-relative ">
                                                                            <div
                                                                                class="image-lead position-relative text-center">
                                                                                <span class="imgWrep">
                                                                                    <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                                                </span>
                                                                                <a class="link"
                                                                                    href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                                            </div>
                                                                            <div class="news-content-box">
                                                                                <!-- news headline -->
                                                                                <div class="position-relative">
                                                                                    <h5 class="title">
                                                                                        {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                                                    <a class="link"
                                                                                        href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                                                </div>
                                                                                <!-- news headline -->

                                                                            </div>
                                                                        </div>
                                                                    </div>
 @endforeach    
                                                                    
                                                                    
																	

                                                                    
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="col-md-6 news-separator-vertical-border position-relative lead-news">
                                                                                                                                                                                                <div class="common-card-content position-relative ">
                                                                    
																	@foreach ($campuscatpostbig as $row)
																	<div
                                                                        class="image-lead position-relative text-center">
                                                                        <span class="imgWrep">
                                                                            <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" />                                                                        </span>
                                                                        <a class="link"
                                                                            href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                                    </div>
                                                                    <div class="news-content-box">
                                                                        <!-- news headline -->
                                                                        <div class="position-relative">
                                                                            <h5 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                                            <a class="link"
                                                                                href="archives/83.html"></a>
                                                                        </div>

                                                                        <div class="summery">
                                                                           {{strlen($row->short_description)>60 ? mb_substr($row->short_description,0,60,"utf-8") : $row->short_description}}&hellip;                                                                        </div>

                                                                    </div>
                                                                </div>
																 @endforeach 
																
                                                                                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="row sub-news">
                                                                     

																	 @foreach ($secondcampuscatpostsmall as $row)
                                                                    <div
                                                                        class="col-lg-12  news-separator-vertical-border">
                                                                        <div
                                                                            class="common-card-content position-relative ">
                                                                            <div
                                                                                class="image-lead position-relative text-center">
                                                                                <span class="imgWrep">
                                                                                    <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" />                                                                                </span>
                                                                                <a class="link"
                                                                                    href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                                            </div>
                                                                            <div class="news-content-box">
                                                                                <!-- news headline -->
                                                                                <div class="position-relative">
                                                                                    <h5 class="title">
                                                                                        {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h5>
                                                                                    <a class="link"
                                                                                        href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
                                                                                </div>
                                                                                <!-- news headline -->

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                             @endforeach
                                                                    
                                                                    

                                                                                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="border my-1"></div>
                                                    </div>

                                                    
                                                    <div class="col-12 col-md-3">
								
													           <div class="text-center mt-3">
<h2 class="widgettitle">বিজ্ঞাপন</h2>
       {!!$gs->sidebar_ads!!}
                                   </div>
                                               </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </section>


                                <div class="news-separator-horizontal-border"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

</section>

<section class="gallery">

    <section class="bottom-gap-40" id="photo-gallery">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <div class="menu-link">
                            <a href="{{ URL::to('/photo') }}">
                                <i class="fas fa-images"></i>
                                <span>ফটোগ্যালারি</span>
                            </a>
                            <span class="menu-link-border-middle-full"></span>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-9 news-separator-vertical-border">
                                <div class="lead-album">
                                    <div class="position-relative">

                                        <div id="home-lead-album" class="home-lead-album">
                                            <ul class="slides">

                                                                                                
																								
																								
																								
																								
																								
																 @foreach ($image_albums as $image_album)								
																								
																								<li
                                                    data-thumb="{{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                    <div class="sub2-lead-content">
                                                        <div class="img-content position-relative text-center">
                                                            <span class="imgWrep">
                                                                <img width="500" height="280" src="{{asset('assets/images/image-album/'.$image_album->photo)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/image-album/'.$image_album->photo)}} 500w, {{asset('assets/images/image-album/'.$image_album->photo)}} 300w, {{asset('assets/images/image-album/'.$image_album->photo)}} 768w, {{asset('assets/images/image-album/'.$image_album->photo)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                                <i
                                                                    class="fas fa-images position-absolute end-0 bottom-0 text-white p-1 fs-4"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h4 class="title overlay-headline">
                                                                {{$image_album->album_name}}                                                          </h4>
                                                        </div>

                                                        <a class="link" href="{{ route('gallery.view', $image_album->id) }}"></a>

                                                        <div class="photo_social_link">
                                                            <a target="_blank"
                                                                href="https://www.facebook.com/sharer.php?u={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                <i class="fab fa-facebook-f"></i>
                                                            </a>

                                                            <a target="_blank"
                                                                href="https://www.instagram.com/?url={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                <i class="fab fa-instagram"></i>
                                                            </a>

                                                            <a target="_blank"
                                                                href="https://www.twitter.com/share?url={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                <i class="fab fa-twitter"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="home-lead-album-share">
                                                        <div class="photo-gallery-share">

                                                            <span class="photo-gallery-share-but">
                                                                <div class="photo-gallery-share-view">
                                                                    <a target="_blank" class="facebook-f"
                                                                        href="https://www.facebook.com/sharer.php?u={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                        <i class="fab fa-facebook-f"></i>
                                                                    </a>

                                                                    <a target="_blank" class="instagram"
                                                                        href="https://www.instagram.com/?url={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                    </a>

                                                                    <a target="_blank" class="twitter"
                                                                        href="https://www.twitter.com/share?url={{asset('assets/images/image-album/'.$image_album->photo)}}">
                                                                        <i class="fab fa-twitter"></i>
                                                                    </a>

                                                                </div>

                                                                <span class="photo-gallery-share-icon">

                                                                    <i class="fas fa-share-alt me-2"></i>
                                                                    Share

                                                                </span>

                                                            </span>

                                                        </div>
                                                    </div>



                                                </li>
                                                     @endforeach                                          
																							   
																							   
																							   
																							   
																							   
																							   
																							   
																							   
																							   
																							   
																							   
                                                
                                            </ul>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-3">
                                <div class="other-album-list">
                                    
									
									 @foreach ($image_albums as $image_album)
                                    <a href="{{ route('gallery.view', $image_album->id) }}" class="sub2-lead-content mb-3 home-photo-album">
                                        <div class="img-content position-relative text-center">
                                            <span class="imgWrep">
                                                <img width="500" height="280" src="{{asset('assets/images/image-album/'.$image_album->photo)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/image-album/'.$image_album->photo)}} 500w, {{asset('assets/images/image-album/'.$image_album->photo)}} 300w, {{asset('assets/images/image-album/'.$image_album->photo)}} 768w, {{asset('assets/images/image-album/'.$image_album->photo)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                <i
                                                    class="fas fa-images position-absolute end-0 bottom-0 text-white p-1 fs-4"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="title overlay-headline">{{$image_album->album_name}}</h4>
                                        </div>
                                    </a>
                                   @endforeach
                                    


                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</section>

<section class="podcast">
    <section id="podcast" class="my-2 py-1">
        <div class="container-fluid">
            <div class="news-border">
                <div class="menu-link mb-2">
                    <a href="{{ route('frontend.category',$binodoncat->slug ?? 'Not Found')}}">

                        <span>{{ $binodoncat->title ?? 'Not Found'}}</span>
                    </a>

                </div>

                <div class="flexslider carousel border-0 m-0" id="podcastFlex">
                    <ul class="slides">
                                                
                        
						
						 @foreach ($binodoncatpostsmall as $row)
						<li class="p-2 border rounded">
                            <div class="flex-content">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                            <div class="img-content position-relative text-center">
                                                <span class="imgWrep">
                                                    <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                </span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="flex-grow-1">
                                        <a href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                            <h4 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h4>
                                           
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </li>
 @endforeach
                        


                        

                    </ul>
                </div>
            </div>
        </div>
    </section>
</section>

@endsection


