@extends('layouts.front')
@section('contents')
@section('meta')
<title>{{$data->title}}</title>
<meta name="Description" content="{!! $data->short_description !!}">
<meta name="Keywords" content="{!! $data->meta_tag !!}">
<meta property="og:title" content="{{$data->title}}" />
<meta property="og:description" content="{!! $data->short_description !!}" />
<meta property="og:image" content="{{asset('assets/images/post/'.$data->image_big)}}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="article" />
@endsection

<div class="container-fluid">
    <div class="dtl_content_layer px-0 pb-3 mt-3">
        <div class="row">
            <div class="col-md-9">
                <div id="details_content" class="infinity-data">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2 pb-2" id="site_map_dtl">
                                <style type="text/css">
                                    .breadcrumb {
                                        padding: 0;
                                        margin-bottom: 0;
                                        background: #fff;
                                    }

                                    .breadcrumb .separator {
                                        padding: 0px 10px;
                                        font-size: 14px;
                                    }

                                    .breadcrumb li.dtl_child a,
                                    li.child a,
                                    li.child,
                                    .breadcrumb li a {
                                        color: #333333;
                                        font-size: 18px;
                                        font-weight: bold;
                                    }

                                    /*.breadcrumb li.more a,*/
                                    .breadcrumb li.active {
                                        color: #1a73e8;
                                    }

                                    .brd_vid_cat {
                                        border-left: 10px solid #001e48;
                                        padding-left: 10px;
                                        line-height: 20px;
                                    }
                                </style>
                                <ul class="breadcrumb">
                                    <li class="dtl_child">
                                        <a href="/">
                                            <i class="fas fa-home"></i>
                                        </a>
                                    </li>
                                    <li class="separator">
                                        <a>/</a>
                                    </li>
                                    <li class="child">
                                        <a href="">
                                            {{$data->category->title}}                                        </a>
                                    </li>
                                </ul>

                                <!--end breadcrumb-->
                                <div class="clr"></div>
                            </div>
                            <div class="rpt_and_share_block mt-2">
                                <div class="rpt_info_section border-bottom mb-2 pb-2">
                                    <div class="rpt_name mt-2">
                                        <i class="far fa-user me-2"></i>
										@if ($data->admin_id == 0 && $data->user_id != 0)
                                        {{ $data->user->name }} 
                                        @else		
{{$data->admin->name}}
 @endif
											
                                    </div>
                                    <div class="entry_update mb-0">
                                        <i class="far fa-clock me-2"></i>
                                   প্রকাশ : {{$data->createdAt()}} ইং</div>
                                    <div class="edition">
                                        <i class="fas fa-pen me-2"></i>অনলাইন সংস্করণ</div>
                                </div>
                                <div class="mb-2 pb-2 border-bottom">
                                    <style>
                                        .share_section #st-1 .st-total.st-hidden {
                                            display: block;
                                        }

                                        .share_section .sharethis-inline-share-buttons .st-total {
                                            display: inline-block !important;
                                            position: relative;
                                            /* width: 60px; */
                                            border-right: 1px solid #cecece;
                                            margin-right: 15px;
                                            text-align: center;
                                            color: #282828 !important;
                                            line-height: 10px;
                                        }

                                        .share_section #st-1 .st-total>span.st-shares {
                                            font-size: 12px !important;
                                        }

                                        .share_section #st-1 .st-total {
                                            font-weight: bold;
                                            margin-right: 7px
                                        }

                                        .share_section .st-total>span.st-shares {
                                            font-size: 12px !important;
                                            font-weight: bold !important;
                                        }

                                        .xoom-out span,
                                        .xoom-in span {
                                            width: 40px;
                                            height: 40px;
                                            display: inline-block;
                                            background: #404040;
                                            color: #fff;
                                            cursor: pointer;
                                            border-radius: 50%;
                                            padding: 8px 11px;
                                            font-size: 18px;
                                            margin-left: 4px;
                                        }
                                    </style>
                                    <!--end share_section-->

                                </div>
                                <!--end rpt_info_section-->
                                <div id="related_news">
                                    <style type="text/css">
                                        .dtl_content_block {
                                            text-align: left !important;
                                        }

                                        div.hl a {
                                            font-size: 16px;
                                            line-height: 20px;
                                            color: #000;
                                            font-weight: bold;
                                        }

                                        .more_dtl_news img.news_img {
                                            height: 170px;
                                            width: auto
                                        }

                                        .more_news_vedio {
                                            position: absolute;
                                            top: 32%;
                                            left: 40%;
                                        }

                                        #morenews_content .more_dtl_news .news_headline {
                                            font-size: 18px;
                                            font-weight: bold;
                                        }

                                        .dtl_tags_news_title {
                                            display: inline-block;
                                            border-left: 5px solid #959595;
                                            margin-top: 15px;
                                            margin-bottom: 15px;
                                            padding-left: 10px;
                                        }

                                        .more_dtl_news:hover .hl>a {
                                            color: #0573e6 !important;
                                        }

                                        #related_news .flex-content .img-content {
                                            width: 80px;
                                        }

                                        #related_news .sub-news h4.title {
                                            font-size: 15px !important;
                                        }

                                        #related_news .sub-news:first-child .news-separator-horizontal-border {
                                            border: none;
                                        }
                                    </style>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="dtl_tags_news_title">
											                 @php
				$popular=DB::table('posts')->inRandomOrder()->orderBy('id','DESC')->where('is_feature',1)->limit(5)->get();
				@endphp  
                                                <a href="">
                                                    এ সম্পর্কিত আরও খবর
                                                </a>
                                            </div>
                                            <div class="border-bottom mb-2"></div>
                                        </div>
                                    </div>
                                    <div class="common-border-box">
                                        <div class="selected-news">
                                           
										     @foreach($popular as $row) 
										   
										   <div class="sub-news">
                                                <div class="news-separator-horizontal-border"></div>
                                                <div class="flex-content position-relative" id="flex-left-image">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                <div class="img-content position-relative text-center">
                                                                    <span class="imgWrep">
                                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$row->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" fetchpriority="high" srcset="{{asset('assets/images/post/'.$row->image_big)}} 500w, {{asset('assets/images/post/'.$row->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a class="_link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}">
                                                                <h4 class="title">{{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}</h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                    @endforeach                                    
                                                                                       
																					   
																					   
																					   
                                            
                                        </div>
                                    </div>
                                </div>
                            <div class="col-12 col-md-12">
                <div class="text-center mt-3">
                                    </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="text-center mt-3">
                                    </div>
            </div>
                <!-- ads -->
                            </div>
                            <!--end row-->
                        </div>
                        <div class="col-md-9">

                            <style>
                                .headline_edit {
                                    color: red !important;
                                    font-size: 16px;
                                    /* background: red; */
                                    padding: 5px;
                                    border-radius: 5px;
                                }

                                .headline_content_block h5 {
                                    font-size: 17px;
                                    color: #1149ba;
                                    font-weight: bold;
                                }

                                .headline_content_block h6 {
                                    font-size: 17px;
                                    color: red;
                                    font-weight: bold;
                                }

                                .headline_content_block div.col-10:nth-child(odd) {
                                    padding-right: 0px;
                                }

                                .headline_content_block div.col-2:nth-child(even) {
                                    padding-left: 5px;
                                }

                                .print_social {
                                    display: flex;
                                    align-items: center;
                                    justify-content: flex-end;
                                }

                                .print_social i.fa-print {
                                    color: #fff;
                                    background-color: #222222;
                                    padding: 12px;
                                    border-radius: 50%;
                                }
                            </style>
                            <div class="headline_content_block post_template-0">

                                <div class="headline_section mb-2">
                                    <h2 class="details-title fw-bold" style="color: ">{{$data->title}}</h2>
                                </div>

                                <div class="mobile_post_meta">
                                    <div class="rpt_info_section">
                                        <div class="rpt_name mt-2">
                                            <span>
                                                <i class="fa fa-user me-2"></i>
												@if ($data->admin_id == 0 && $data->user_id != 0)
                                            {{ $data->user->name }}    
 @else											
	  {{$data->admin->name}}  
	 @endif   
												</span>
                                        </div>
                                        <div class="entry_update">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            প্রকাশ : {{$data->createdAt()}} ইং                                           <span class="mx-2">|</span>অনলাইন সংস্করণ</div>
                                    </div>
                                    <!--end rpt_info_section-->



                                    <!-- <div id="related_news"></div> -->
                                </div>

                                
                                        <div class="print_social">
                                            @php $shareUrl = url()->current(); $shareTitle = $data->title; @endphp
                                            <div class="share_social_icons d-flex align-items-center gap-2">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="share-icon facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($shareTitle) }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="share-icon twitter" title="Twitter"><i class="fab fa-twitter"></i></a>
                                                <a href="https://wa.me/?text={{ urlencode($shareTitle.' '.$shareUrl) }}" target="_blank" rel="noopener" class="share-icon whatsapp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                                <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener" class="share-icon telegram" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
                                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}" target="_blank" rel="noopener" class="share-icon linkedin" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                                <div class="print_icon ms-2">
                                                    <a href='/print/{{ $data->id }}/{{ $data->slug }}' title="Print news" target="_blank" class="print-butn">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <style>
                                            .share_social_icons { flex-wrap: wrap; }
                                            .share-icon {
                                                width: 36px; height: 36px; display: inline-flex; align-items: center;
                                                justify-content: center; border-radius: 50%; color: #fff;
                                                text-decoration: none; font-size: 15px; transition: opacity .15s;
                                            }
                                            .share-icon:hover { opacity: .8; color: #fff; }
                                            .share-icon.facebook { background: #1877f2; }
                                            .share-icon.twitter { background: #000; }
                                            .share-icon.whatsapp { background: #25d366; }
                                            .share-icon.telegram { background: #0088cc; }
                                            .share-icon.linkedin { background: #0a66c2; }
                                            .xoom-out span,
                                            .xoom-in span {
                                                width: 40px;
                                                height: 40px;
                                                display: inline-block;
                                                background: #404040;
                                                color: #fff;
                                                cursor: pointer;
                                                border-radius: 50%;
                                                padding: 8px 11px;
                                                font-size: 18px;
                                                margin-left: 4px;
                                            }
                                        </style>
                                        <div class="share_section d-flex align-items-center ms-auto">
                                            <a id="fontmines" class="xoom-out" style="cursor: pointer;"><span>অ-</span></a>
                                            <a id="fontPlus" class="xoom-in" style="cursor: pointer;"><span>অ+</span></a>
                                        </div>
                                        </div>
                            </div>
                            <!--end headline_content_block-->

                          
                            <div class="_border-bottom mb-3">
                                <div class="row">
                                    <div class="col-md-7">

                                    </div>
                                    <div class="col-md-5">
                                        <div class="d-flex justify-content-end dtl_share_blk clearfix">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dtl_section" id="dtl_part">
                                <style>
                                    .dtl_img_section {
                                        margin-bottom: 15px;
                                        width: 100%;
                                        padding: 0 0 0 0;
                                        position: relative;
                                    }

                                    .dtl_img_section img {
                                        width: 100% !important;
                                        height: auto;
                                        cursor: pointer;
                                    }
                                </style>
                                <div class="dtl_img_section post_template-0">
                                    <div class="img">
                                        <div class="inner_img detailImg"
                                            data-src="{{asset('assets/images/post/'.$data->image_big)}}"
                                            data-sub-html="ছবির ক্যাপশন: {{ $data->images_caption }}">
                                            <img width="750" height="390" src="{{asset('assets/images/post/'.$data->image_big)}}" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$data->image_big)}} 750w, {{asset('assets/images/post/'.$data->image_big)}} 300w" sizes="(max-width: 750px) 100vw, 750px" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="dtl_content_section" style="line-height:2;font-size:16px;">
                                            
											@if ($data->post_type == 'article')
                                   <p> {!! $data->description !!} </p>
								  @endif
								  @if ($data->post_type == 'video')
								
                                  @if ($data->embed_video)							
								 <p>  {!! $data->description !!} </p>
								   <iframe width="100%" height="400" src="https://www.youtube.com/embed/{!!$data->embed_video!!}" title="Types Of ভাড়াটিয়া || Comedy Special || Sanjay Das - Bishakto Sanju | Joy-Rupam-Ayan-Shuvro || 2024" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
								  @else 
									    <video controls >
                                            <source src="{{asset('assets/videos/'.$data->video)}}" type="video/mp4">
                                        </video>
										@endif
								   
								   @endif
								   
								                              @if ($data->post_type == 'audio')
	<p style="text-align: center;"><b>&nbsp;অডিও&nbsp; ফাইল</b></p>
<audio controls="" style="width:100%">
				 <source src="{{asset('assets/audios/'.$data->audio)}}" type="audio/mp3">
				</audio>
				 {!! $data->description !!}
				@endif
											
											
											
											
											
                                        </div>
                                    </div>
                                </div>

                                
                                <div id="facebook_comments" style="margin:15px 0">
                                    <div style="margin-bottom:10px;">
                                        <p class="comment">
                                            <span></span>
                                            <span>মন্তব্য করুন</span>
                                        </p>
                                    </div>
                                    <div class="fb_comments">
                                        <div id="wpdevar_comment_1" style="width:100%;text-align:left;">
		<span style="padding: 10px;font-size:22px;font-family:monospace;color:#000000;"></span>
		<div class="fb-comments" data-href="{{ url()->current() }}" data-order-by="social" data-numposts="3" data-width="100%" style="display:block;"></div></div><style>#wpdevar_comment_1 span,#wpdevar_comment_1 iframe{width:100% !important;} #wpdevar_comment_1 iframe{max-height: 100% !important;}</style>                                    </div>
                                </div>
                                <style>
                                    #facebook_comments p.comment {
                                        color: #3578e5;
                                        position: relative;
                                        padding-left: 15px;
                                        font-weight: bold;
                                    }

                                    #facebook_comments p.comment>span:first-child {
                                        position: absolute;
                                        left: 0px;
                                        top: 5px;
                                        display: inline-block;
                                        background: #3578e5;
                                        height: 20px;
                                        width: 5px;
                                        border-radius: 5px
                                    }

                                    #facebook_comments p.comment>span:nth-child(2) {
                                        font-size: 20px;
                                        line-height: 30px
                                    }

                                    #facebook_comments .fb_comments {
                                        border-radius: 5px;
                                        border: 1px solid #e6e6e6
                                    }
                                </style>

                            </div>
                        </div>
                    </div>




                </div>
            </div>
            <div class="col-md-3">
                <style type="text/css">
                    .dtl_content_block {
                        text-align: left !important;
                    }

                    div.hl a {
                        font-size: 16px;
                        line-height: 20px;
                        color: #000;
                        font-weight: bold;
                    }

                    .more_dtl_news img.news_img {
                        height: 170px;
                        width: auto
                    }

                    .more_news_vedio {
                        position: absolute;
                        top: 32%;
                        left: 40%;
                    }

                    .dtl_more_news_title {
                        display: inline-block;
                        color: #000;
                        border-left: 5px solid #959595;
                        margin-top: 15px;
                        margin-bottom: 15px;
                        padding-left: 10px;
                        line-height: 20px;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    #morenews_content .more_dtl_news .news_headline {
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .spc_tags .news_headline {
                        font-size: 16px;
                        font-weight: 600;
                        color: #121212;
                    }

                    .spc_tags li:hover .news_headline {
                        color: #1a73e8 !important
                    }

                    .spc_tags .time {
                        color: #999999;
                        font-size: 14px;
                        font-weight: normal;
                    }

                    .spc_tags {
                        list-style: none;
                    }

                    .spc_tags li {
                        position: relative;
                    }

                    .spc_tags .bullet {
                        width: 25px
                    }

                    .spc_tags .bullet .h-border {
                        position: absolute;
                        top: 3px;
                        left: 7px;
                        width: 2px;
                        background: #6a6a6a;
                        display: inline-block;
                        bottom: -5px;
                    }

                    .spc_tags li:first-child .bullet .h-border {
                        top: 10px;
                    }

                    .spc_tags li:last-child .bullet .h-border {
                        bottom: 0px;
                    }

                    .spc_tags .bullet i {
                        color: #6a6a6a;
                        font-size: 16px;
                        margin-top: 10px;
                    }
                </style>
                <section>
                </section>
                <style>
                    .morebtn {
                        width: 100%;
                        font-size: 18px;
                        padding: 5px 10px;
                        background: #e7f3ff;
                        color: #121212;
                        cursor: pointer;
                        border-radius: 10px;
                        display: block;
                        margin-top: 10px;
                    }

                    .morebtn:hover {
                        background: #b2d5f7 !important;
                    }
                </style>

                <script>
                    $(document).ready(function () {
                        function findMoreVideo(dat, tags, id, ele) {
                            var dat = dat;
                            $.ajax({
                                type: 'get',
                                datType: 'json',
                                url: 'https://www.kalbela.com/templates/web-view/details_page/spc_tags_list_ajax.php',
                                data: {
                                    'page': dat,
                                    'tags': tags,
                                    'id': id
                                },
                                beforeSend: function () {
                                    ele.parents('section').find('.loading-for-more').show();
                                },
                                success: function (data) {
                                    ele.parents('section').find('.val_page_btm').append(data);
                                    ele.parents('section').find('.loading-for-more').hide();

                                    /*$.ajax({
                                        type: 'get',
                                        datType:'json',
                                        url: 'https://www.kalbela.com/templates/web-view/details_page/spc_tags_list_ajax.php',
                                        data: {'page':parseInt(dat)+1,'tags':tags,'id':id},
                                        beforeSend: function () {
                                        },
                                        success: function (data) {
                                            if(data.length<50){
                                                $('#find_more').remove();
                                            }
                                        }
                                    });*/

                                }
                            });
                        }
                        $('.find_more').on('click', function () {
                            var id = $(this).attr('data-id');
                            var p = $(this).attr('data-page');
                            var tags = $(this).attr('data-tags');
                            findMoreVideo(p, tags, id, $(this));
                            $(this).attr('data-page', parseInt(p) + 1);
                        });
                    });
                </script>

                <div>

                    <div class="tab_block_one common-border-box h-100">
    <div class="tab_bar_block_new">
        <ul class="list-inline mb-3">
            <li class="active" tabIndex="latest_list_block1">সর্বশেষ</li>
            <li tabIndex="popular_list_block1">জনপ্রিয়</li>
        </ul>
    </div>

    <div class="list_display_block1 box_shadow" id="latest_list_block1">
        <div id="latestview1">
            
			
			
                            @php
				$latest=DB::table('posts')->inRandomOrder()->orderBy('id','DESC')->where('is_trending',1)->limit(20)->get();
				@endphp 
			
			 @foreach ($latest as $row) 
			<div class="sub2-lead-content">
                <div class="d-flex">
                    <div class="flex-fill">
                        <h4 class="title">
                            <i class="fa-solid fa-angle-right"></i>
                          {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}                        </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="news_sl">{{ $loop->iteration }}</span>
                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
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
		                @php
				$alocito1=DB::table('posts')->inRandomOrder()->orderBy('id','DESC')->where('is_slider',1)->limit(1)->get();
				$alocito2=DB::table('posts')->inRandomOrder()->orderBy('id','DESC')->where('is_slider',1)->skip(1)->limit(20)->get();
				@endphp
		
		@foreach ($alocito2 as $row)
                        <div class="sub2-lead-content">
                <div class="d-flex">
                    <div class="flex-fill">
                        <h4 class="title">
                            <i class="fa-solid fa-angle-right"></i>
                            {{strlen($row->title)>60 ? mb_substr($row->title,0,60,"utf-8") : $row->title}}                       </h4>
                    </div>
                </div>
                <div class="clearfix"></div>
                <span class="news_sl"> {{ $loop->iteration }}</span>
                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$row->id,$row->slug])}}"></a>
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
                <div class="col-12 col-md-12">
                <div class="text-center mt-3">
                                    </div>
            </div>
            <div class="col-12 col-md-12">
                <div class="text-center mt-3">
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
                <script>
                    $('.tab_bar_block_new li').on('click', function () {

                        if (!$(this).hasClass('active')) {

                            var tabIndex = $(this).attr('tabIndex');

                            $(this).parents('.tab_block_one').find('.tab_bar_block_new li').removeClass(
                                'active');

                            $(this).addClass('active');

                            $(this).parents('.tab_block_one').find('.list_display_block1').hide();

                            $(this).parents('.tab_block_one').find('#' + tabIndex).fadeIn();

                        }

                    });
                </script>

            </div>
        </div>

    </div>
</div>

@endsection