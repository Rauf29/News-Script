@extends('layouts.front')
@section('contents')
    @section('meta')
<title>{{$data->title}}</title>
<meta property="og:title" content="{{$data->title}}" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection	
@push('css')

@endpush
         
		 <div id="category_content">


    <style type="text/css">
        .category-breadcrumb,
        .breadcrumb_cat {
            border-top: 1px solid #ddd;
            padding-top: 18px;
        }

        .cat_lead h5.title {
            font-size: 1.75rem !important;
            font-weight: bold;
            padding: 10px 0px 7px 0;
            line-height: 34px;
        }

        .cat_lead div.summery {
            font-size: 1rem;
            -webkit-line-clamp: 4;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-align: justify;
            overflow: hidden;
        }

        .cat_sub_lead h5.title {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 7px 0px;
        }

        #category_content .cat_sub_lead h5.title {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 10px 10px 3px 10px;
            margin-bottom: 0px;
        }

        .catsubMoremedianews #img {
            width: 250px;
            overflow: hidden;
        }

        .catsubMoremedianews .sum {
            font-weight: normal;
            font-size: 1rem;
            -webkit-line-clamp: 4;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            text-align: justify;
            overflow: hidden;
        }

        .catsub_featured img {
            height: 150px;
            width: auto;
        }

        .catsub_featured_photo img {
            height: 160px;
            width: auto;
        }

        .catsub_featured .content_title h2 {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .cat_lead_all {
            _border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
        }

        .breadcrumb-menu ul>li a.active,
        .breadcrumb-title span a.active {
            margin-top: -3px;
        }

        .news-cover-box {
            background: #f7f8fa;
            box-shadow: 0 -5px 4px -6px #6c757d;
            padding: 15px 0;
        }
    </style>

    <div class="news-cover-box">
        <div class="container-fluid">
            <div class="common-border-box p-2">
                <div id="district_site_map">
                    


                    <ul class="breadcrumb">
                        <li><a href="/">প্রচ্ছদ</a></li>
                        <li class="separator"><a><i class="fas fa-angle-double-right"></i></a></li>
                                                <li class="child">{{$data->title}}</li>
                    </ul>
                    <style>
                        .seperator {
                            padding: 0 10px
                        }

                        .child a {
                            color: #000
                        }

                        .breadcrumb li.dtl_child a,
                        li.child a,
                        li.child,
                        .breadcrumb li a {
                            color: #333333;
                            font-size: 18px;
                            font-weight: bold;
                        }

                        .breadcrumb .separator {
                            padding: 0px 10px;
                            font-size: 14px;
                        }

                        .breadcrumb-title {
                            _width: 15%;
                            _float: left;
                            padding-right: 20px;
                            display: table-cell;
                            white-space: nowrap;
                            vertical-align: top
                        }

                        .breadcrumb-title img {
                            _float: left;
                            margin-right: 10px;
                            display: inline-block
                        }

                        .breadcrumb-title span a {
                            font-size: 20px;
                            color: #000;
                            display: inline-block;
                            padding-right: 10px
                        }
                    </style>

                </div>
                <div class="category-breadcrumb border-top">



                    <div class="breadcrumb-title">
                    </div>



                </div>
                <div class="row lead-section">
                    <div class="col-12 col-md-12">
                        <div class="row mt-3">
                            <div class="col-md-12 cat_lead_all">
                                <div class="row">
								 @foreach ($posts1 as $post1)
                                    <div class="col-md-6">
                                                                                
                                        <div class="cat_lead">
                                            <div class="common-card-content position-relative ">
                                                <div class="image-lead position-relative text-center">
                                                    <span class="imgWrep">
                                                        <img width="500" height="280" src="{{asset('assets/images/post/'.$post1->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" fetchpriority="high" srcset="{{asset('assets/images/post/'.$post1->image_big)}} 500w, {{asset('assets/images/post/'.$post1->image_big)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />                                                    </span>
                                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post1->category->slug,$post1->slug])}}"></a>
                                                </div>
                                                <div class="news-content-box">
                                                    <div class="position-relative">
                                                        <h5 class="title">{{ strlen($post1->title)>100 ? mb_substr($post1->title,0,100,'utf-8').'...' : $post1->title}}</h5>
                                                        <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post1->category->slug,$post1->slug])}}"></a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
@endforeach
                                        
										
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                                   @foreach ($posts2 as $post2)                                     
                                            <div class="col-md-6 mb-4">
                                                <div class="cat_sub_lead">
                                                    <div class="common-card-content position-relative ">
                                                        <div class="image-lead position-relative text-center">
                                                            <span class="imgWrep">
                                                                <img width="500" height="280" src="{{asset('assets/images/post/'.$post2->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" srcset="{{asset('assets/images/post/'.$post2->image_big)}} 500w, {{asset('assets/images/post/'.$post2->image_big)}} 300w, {{asset('assets/images/post/'.$post2->image_big)}} 768w, {{asset('assets/images/post/'.$post2->image_big)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                                                            </span>
                                                            <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post2->category->slug,$post2->slug])}}">
                                                            </a>
                                                        </div>
                                                        <div class="news-content-box">
                                                            <div class="position-relative">
                                                                <h5 class="title">{{ strlen($post2->title)>100 ? mb_substr($post2->title,0,100,'utf-8').'...' : $post2->title}}</h5>
                                                                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post2->category->slug,$post2->slug])}}"></a>
                                                            </div>

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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-3">
        <div class="col"></div>
        <div class="col-lg-7">
            <div class="catsubMoremedianews sunset-posts-container">
                             
				   @if ($posts->count()>0)    		
			 @foreach ($posts as $post)			
	<div class="sub-news">
    <a href="{{ route('frontend.postBySubcategory.details',[$post->category->slug,$post->slug])}}">
        <div class="d-flex pb-3 mb-3 border-bottom">
            <div class="flex-shrink-0">
                <div id="img" class="position-relative clearfix">
                    <span class="imgWrep">
                        <img width="500" height="280" src="{{asset('assets/images/post/'.$post->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" loading="lazy" srcset="{{asset('assets/images/post/'.$post->image_big)}} 500w, {{asset('assets/images/post/'.$post->image_big)}} 300w" sizes="auto, (max-width: 500px) 100vw, 500px" />                    </span>
                </div>
            </div>
            <div class="flex-grow-1 ms-2">
                <h5 class="mb-3 px-2 fw-bold">{{ strlen($post->title)>100 ? mb_substr($post->title,0,100,'utf-8').'...' : $post->title}}</h5>
                <p class="mb-3 px-2 sum">{{ strlen($post->short_description)>300 ? mb_substr($post->short_description,0,300,'utf-8').'...' : $post->short_description}}&hellip;</p>
            </div>
        </div>
    </a>
</div>                
@endforeach
                               @else
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-danger text-danger text-center">{{__('এই ক্যাটাগরিতে কোন সংবাদ নেই!')}}</p>
                                        </div>
                                    </div>
                                </div>
                        @endif   



           </div>
        </div>
        <div class="col"></div>
    </div>


    <div class="loading-for-more" style="text-align:center; margin: 50px; font-size:30px; display:none">
        <i class="fa fa-spin fa-spinner"></i>
    </div>

    
            <div class="text-center clearfix cmn_more_clr more_photos_btn mt-3">
                {{ $posts->links() }}
            </div>
            

</div>
		
		
@endsection