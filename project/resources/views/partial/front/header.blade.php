<header class="non-sticky">
        <div id="midHeader">
            
            <div class="container-fluid">
                <div class="d-flex">
                    <div class="flex-fill">
												@php
								Session::has('language') ? $lid=Session::get('language') : $lid = (DB::table('languages')->where('is_default','=',1)->first()->id)
							@endphp
							
							@php
								$header_footer_logo = d_logo($lid);
							@endphp
                        <a class="logo" href="{{route('frontend.index')}}">
                            <img class="img-fluid logo"
                                src="{{asset('assets/images/logo/'.$gs->logo)}}" />
                        </a>
                    </div>
                    <div class="flex-fill pt-2 top_header_menu_container">

                        <ul id="top-quick-links" class="menu"><li id="menu-item-48" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-48"><a href="{{ URL::to('/ajkersongbad') }}"><i class="fa fa-table list" aria-hidden="true"></i>আজকের পত্রিকা</a></li>
<li id="menu-item-51" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-51"><a href="{{ $gs->epaper_link }}"><i class="fa fa-newspaper me-2"></i>ই-পেপার</a></li>
<li id="menu-item-49" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-49"><a href="https://www.facebook.com/{{ $gs->facebook_page_url }}"><i class="fa fa-thumbs-up"></i> সোশ্যাল মিডিয়া</a></li>
<li id="menu-item-50" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-50"><a href="{{ URL::to('/converter') }}"><i class="fa fa-language" aria-hidden="true"></i>বাংলা কনভার্টার</a></li>
</ul>
                    </div>
                    <div class="flex-fill text-end pt-2 extra-opt-container">
                        <section id="navigation">
                            <div class="d-flex justify-content-left position-relative">
                                <div class="extra-opt">
                                    <span>

                                        <a href="javascript: void(0)" id="dropdownSearch">
                                            <i class="fas fa-search open_icon"></i>
                                            <i class="fas fa-times close_icon"></i>
                                        </a>
                                        <!-- <div class="dropdown-menu dropdown-menu-end dropdownSearch" aria-labelledby="dropdownSearch"> -->
                                        <div class="dropdown-menu dropdown-menu-end dropdownSearch p-0">
                                            <!-- <div class="_border _rounded">
                                                <div class="position-relative">
                                                    <span class="search-icon search_button">
                                                        <i class="fas fa-search"></i>
                                                    </span>
                                                    <input type="text" name="q"
                                                        class="form-control form-control-sm srch_keyword "
                                                        placeholder="সার্চ করুন..." value="" />
                                                </div>
                                            </div> -->
                                            <form style="width:100%;" role="search" method="get" id="searchform"
                                                action="{{ route('front.news_search') }}">
                                                <div class="form-inner">
                                                    <input type="text" value="" name="search" id="s" required
                                                        placeholder="সার্চ করুন..." autocomplete="off" />
                                                    <button type="submit" class="search-icon "><i
                                                            class="fa fa-search"></i></button>
                                                </div>
                                            </form>
                                            <div id="search-results" class="dropdown-menu" style="display:none;width:100%;max-height:400px;overflow-y:auto;"></div>
                                        </div>
<script>
jQuery(document).ready(function($){
    var searchForm = $('#searchform');
    var searchInput = $('#s');
    var resultsDiv = $('#search-results');
    var timer;

    searchForm.on('submit', function(e){
        e.preventDefault();
        var q = searchInput.val().trim();
        if(!q) return;
        $.get($(this).attr('action'), {search: q, ajax: true}, function(html){
            resultsDiv.html(html).show();
        });
    });

    searchInput.on('keyup', function(){
        clearTimeout(timer);
        var q = $(this).val().trim();
        if(q.length < 2){ resultsDiv.hide(); return; }
        timer = setTimeout(function(){
            $.get(searchForm.attr('action'), {search: q, ajax: true}, function(html){
                resultsDiv.html(html).show();
            });
        }, 400);
    });

    $(document).on('click', function(e){
        if(!$(e.target).closest('.dropdownSearch').length){
            resultsDiv.hide();
        }
    });
});
</script>
                                    </span>
                                    <span class="dropdown_menu_hover">
                                        <a href="#" class="dropdown-toggle" id="dropdownNotification">
                                            <span class="badge"></span>
                                            <svg xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                preserveAspectRatio="xMidYMid meet" focusable="false"
                                                class="style-scope yt-icon"
                                                style="pointer-events: none; display: inline-block; width: 100%; height: 100%;"
                                                width="24" height="24">
                                                <g class="style-scope yt-icon" fill="#030303">
                                                    <path
                                                        d="M10,20h4c0,1.1-0.9,2-2,2S10,21.1,10,20z M20,17.35V19H4v-1.65l2-1.88v-5.15c0-2.92,1.56-5.22,4-5.98V3.96 c0-1.42,1.49-2.5,2.99-1.76C13.64,2.52,14,3.23,14,3.96l0,0.39c2.44,0.75,4,3.06,4,5.98v5.15L20,17.35z M19,17.77l-2-1.88v-5.47 c0-2.47-1.19-4.36-3.13-5.1c-1.26-0.53-2.64-0.5-3.84,0.03C8.15,6.11,7,7.99,7,10.42v5.47l-2,1.88V18h14V17.77z"
                                                        class="style-scope yt-icon" fill="#030303"></path>
                                                </g>
                                            </svg>
                                        </a>

                                        <div class="dropdown_menu dropdown-menu dropdown-menu-end dropdownNotification">
                                            
											
											@foreach($is_trendings as $is_trending)	
                                            <div class="border-bottom _dropdown-item clearfix py-2">
                                                <a class="" href="{{ route('frontend.postBySubcategory.details',[$is_trending->category->slug,$is_trending->slug])}}">
                                                    {{strlen($is_trending->title)>40 ? mb_substr($is_trending->title,0,40,"utf-8") : $is_trending->title}}..                                               </a>
                                                <div class="time">
                                                    <i class="far fa-clock me-1"></i>
                                                   প্রকাশঃ {{$is_trending->createdAt()}} ইং                                               </div>
                                            </div>
                                           @endforeach
                                            
                                            

                                            

                                        </div>
                                    </span>


                                </div>
                            </div>

                            <style>
                                .src_input:focus {
                                    background: #fff;
                                    outline: 2px solid #fff;
                                }

                                .extra-opt span svg {
                                    width: 18px;
                                    height: auto;
                                }

                                #navigation .dropdownNotification a:hover {
                                    color: #1a73e8;
                                }
                            </style>

                        </section>
                    </div>
                    <div class="mobile_menu_toggle_container">
                        <i class="fas fa-bars menu_open"></i>
                        <i class="fas fa-xmark menu_close" style="display:none;"></i>
                    </div>
                </div>
            </div>


            <section id="top-nav">
                <div class="container-fluid">
                    <div class="d-flex justify-content-center position-relative">
                        <nav id="mobile_scroll">
                            <ul>
							   @foreach ($categories as $category)
								 @if ($loop->first)
                                <li>
                                    <a href="{{ route('frontend.index')}}">
                                        <i class="fas fa-home"></i>
                                    </a>
                                </li>
								 @endif

 @if ($category->child()->count() > 0)
                                <li id="menu-item-118" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
					@else
					@if ($loop->first)
					@else 
						<li id="menu-item-118" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
                                        @endif
				@endif
			@endforeach	 
			 @if (!auth()->user())
			<li id="menu-item-118" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('front.LogReg') }}">লগইন</a></li>
				                                     @endif
									@if (auth()->user())
									     @php
											 $data = auth()->user();
										 @endphp	
<li id="menu-item-118" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('user.dashboard') }}">ড্যাশবোর্ড</a></li>
    @endif	





					
							</ul>
                        </nav>


                        <span class="dropdown_menu_hover dropdownAllMenuIcon mobile_hide">

                            <a class="dropdown dropdownAllMenuBut">
                                <i class="fas fa-bars open_icon"></i>
                                <i class="fas fa-xmark close_icon" style="display:none;"></i>
                            </a>
                            <!-- <div class="dropdown-menu dropdown-menu-end dropdownAllMenu" aria-labelledby="dropdownAllMenu"> -->
                            <div class="dropdown-menu dropdown_menu dropdown-menu-end dropdownAllMenu">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between align-items-center pe-4">
                                        <div class="date-desc">আজকের {{ $gs->title }} সংবাদ</div>
                                        <span class="dropdownAllMenuClose btn btn-sm btn-light rounded-circle p-0" style="width:30px;height:30px;font-size:20px;line-height:28px;text-align:center;">&times;</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="news-separator-horizontal-border"></div>
                                    </div>
                                    <div class="col-12">
                                        <ul>
										                                @foreach ($categories as $category)
								 @if ($loop->first)
                                            <li id="menu-item-53" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.index')}}">{{$category->title}}</a></li>
                                          @endif
										 
@if ($category->child()->count() > 0)
 <li id="menu-item-53" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
  @foreach ($category->child as $child)
<li id="menu-item-53" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.postBySubcategory.details',[$category->slug,$child->slug])}}">{{$child->title}}</a></li>
	@endforeach	
						@else
					@if ($loop->first)
					@else 
<li id="menu-item-53" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
             @endif
				@endif
			@endforeach
			
										 
										</ul>
                                    </div>
                                    <div class="col-12">
                                        <div class="news-separator-horizontal-border"></div>
                                        <div class="text-center">
                                            <ul class="top-extra-menus">
                                                <li>
                                                    <a href="{{ URL::to('/video') }}">
                                                        <img style="width:20px; margin-right: 5px"
                                                            src="{{asset('assets/frontend/assets/images/video-stories.png')}}">
                                                        <span>ভিডিও স্টোরি</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ URL::to('/photo') }}">
                                                        <img style="width:20px; margin-right: 5px"
                                                            src="{{asset('assets/frontend/assets/images/photo-stories.png')}}">
                                                        <span>ফটো স্টোরি</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ URL::to('/photo') }}">
                                                        <i class="fas fa-images"></i>
                                                        <span>ফটোগ্যালারি</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ URL::to('/video') }}">
                                                        <i class="fas fa-photo-video"></i>
                                                        <span>ভিডিও গ্যালারি</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>

                    </div>
                </div>
            </section>

            <div id="mySidenav" class="megaMenu sidenav">
                <div class="px-3 pb-2 pt-3 date-time d-flex justify-content-between align-items-center">
                  আজকের {{ $gs->title }} সংবাদ
                  <span id="mobileMenuClose" style="cursor:pointer;font-size:24px;color:#333;font-weight:bold;padding:0 10px;">&times;</span>
                </div>
                
                <form style="width:100%;" role="search" method="get" id="searchform" class="srch_form"
                    action="{{ route('front.news_search') }}">
                    <div class="form-inner">
                        <input type="text" value="" name="search" id="s" required placeholder="সার্চ করুন..." />
                        <button type="submit" id="seachsubmit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
                <div class="meg-ul">
                    <ul>
					                                @foreach ($categories as $category)
								 @if ($loop->first)
					
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.index')}}">{{$category->title}}</a></li>
									  @endif
									   @if ($category->child()->count() > 0)
                        <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
						  @foreach ($category->child as $child)
						  <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.postBySubcategory.details',[$category->slug,$child->slug])}}">{{$child->title}}</a></li>
						  @endforeach	
						  					@else
					@if ($loop->first)
					@else
						   <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
						  
						               @endif
				@endif
			@endforeach	
						  
  
						
						<li>
                            <a href="{{ URL::to('/video') }}" class="photo_m">
                                <img class="img-fluid v-storys"
                                    src="{{asset('assets/frontend/')}}/assets/images/video-stories.png"> ভিডিও
                                স্টোরি</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/photo') }}" class="photo_m">
                                <img class="img-fluid v-storys"
                                    src="{{asset('assets/frontend/')}}/assets/images/photo-stories.png"> ফটো স্টোরি</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/photo') }}" class="video_m">
                                <i class="fas fa-images"></i>
                                ফটোগ্যালারি</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('/video') }}" class="video_m">
                                <i class="fas fa-photo-video"></i>
                                ভিডিও গ্যালারি</a>
                        </li>


                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>

        </div>

    </header>



    <header class="sticky">
        <div class="container-fluid">
            <div class="d-flex position-relative">
                <div class="flex-fill">

                    <a class="logo w-100" href="{{route('frontend.index')}}">
                        <img class="img-fluid logo" src="{{asset('assets/images/'.$gs->favicon)}}" /> | আজকের তারিখঃ <span id="date-today"></span> বঙ্গাব্দ
						
						
						</a>
                </div>
                <div class="flex-fill pt-2">
                    <nav>
                        <ul>
						        @foreach ($categories as $category)
								 @if ($loop->first)
						
                            <li>
                                <a href="{{ route('frontend.index')}}">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
							  @endif
							
   @if ($category->child()->count() > 0)
 <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
			@else
					@if ($loop->first)
					@else 
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
             @endif
				@endif
			@endforeach	
			
	          @if (!auth()->user())			
<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('front.LogReg') }}">লগইন</a></li>
                                     @endif
									@if (auth()->user())
									     @php
											 $data = auth()->user();
										 @endphp

<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-118"><a href="{{ route('user.dashboard') }}">ড্যাশবোর্ড</a></li>
   @endif	

                        </ul>
                    </nav>
                    <span class="dropdown_menu_hover dropdownAllMenuIcon">

                        <a class="dropdown dropdownAllMenuBut">
                            <i class="fas fa-bars open_icon"></i>
                            <i class="fas fa-xmark close_icon" style="display:none;"></i>
                        </a>

                        <div class="dropdown-menu dropdown_menu dropdown-menu-end dropdownAllMenu">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between align-items-center pe-4">
                                আজকের {{ $gs->title }} সংবাদ
                                <span class="dropdownAllMenuClose btn btn-sm btn-light rounded-circle p-0" style="width:30px;height:30px;font-size:20px;line-height:28px;text-align:center;">&times;</span>
                                </div>
                                <div class="col-12">
                                    <div class="news-separator-horizontal-border"></div>
                                </div>
                                <div class="col-12">
                                    <ul>
        

                                                                           @foreach ($categories as $category)
								 @if ($loop->first)
	   <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.index')}}">{{$category->title}}</a></li>
  @endif
 @if ($category->child()->count() > 0)
 <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
@foreach ($category->child as $child)
<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.postBySubcategory.details',[$category->slug,$child->slug])}}">{{$child->title}}</a></li>
 	@endforeach	    
					@else
					@if ($loop->first)
					@else 
<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-53"><a href="{{ route('frontend.category',$category->slug)}}">{{$category->title}}</a></li>
             @endif
				@endif
			@endforeach







	</div>
                                <div class="col-12">
                                    <div class="news-separator-horizontal-border"></div>
                                    <div class="text-center">
                                        <ul class="top-extra-menus">
                                            <li>
                                                <a href="{{ URL::to('/video') }}">
                                                    <img style="width:20px; margin-right: 5px"
                                                        src="{{asset('assets/frontend/')}}/assets/images/video-stories.png">
                                                    <span>ভিডিও স্টোরি</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ URL::to('/photo') }}">
                                                    <img style="width:20px; margin-right: 5px"
                                                        src="{{asset('assets/frontend/')}}/assets/images/photo-stories.png">
                                                    <span>ফটো স্টোরি</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ URL::to('/photo') }}">
                                                    <i class="fas fa-images"></i>
                                                    <span>ফটোগ্যালারি</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ URL::to('/video') }}">
                                                    <i class="fas fa-photo-video"></i>
                                                    <span>ভিডিও গ্যালারি</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>


                </div>
            </div>
        </div>
    </header>