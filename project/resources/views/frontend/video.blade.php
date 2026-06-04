@extends('layouts.front')
 @section('meta')
    <title>ভিডিও  গ্যালারী</title>
<meta property="og:title" content="ভিডিও গ্যালারী" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection

@section('contents')
 

<div class="container-fluid">
    <!--call breadcrumb-->
    <!--call video_home_page-->
    <div class="left-lead-part">
        <div id="video_home_page_content">
            <div class="d-flex catpageSubmenu mb-3">
                <a class="" href="#">ভিডিও </a>
            </div>
            <style>
                .heading-h2 {
                    font-weight: bold;
                }

                .videoSub {
                    display: block
                }

                .videoSub h5 {
                    font-size: 1.1rem;
                    font-weight: bold;
                    padding: 7px 0px;
                    margin: 0
                }

                .videoSub h4 {
                    padding: 7px 0px;
                    margin: 0
                }

                .more_photos_btn a {
                    display: inline-block;
                    font-size: 18px;
                    font-weight: 600;
                    padding: 5px 10px;
                    background: #fff;
                    color: #0573e6;
                    cursor: pointer;
                    border: 1px solid #0573e6;
                    border-radius: 5px;
                }

                .more_photos_btn a:hover {
                    color: #0573e6 !important;
                }
            </style>
            <div class="">
                <div class="row my-3">
                    <div class="col-sm-12">
                        <div class="row sunset-posts-container">
                   @php
				$video2=DB::table('posts')->inRandomOrder()->orderBy('id','DESC')->where('is_videoGallery',1)->limit(100000)->get();
				@endphp   
                                                        
														
																	                     @if ($video2->count()>0)
										@foreach($video2 as $row)
														<div class="col-sm-3">
    <div class="videoSubMore">
        <a href="https://youtube.com/watch?v={{ $row->embed_video}}">
            <div class="text-center vid-single position-relative"
                style="_height:180px; overflow: hidden;background: #f1f1f1;">
                <img src="https://img.youtube.com/vi/{{ $row->embed_video}}/mqdefault.jpg"
                    alt="{{strlen($row->title)>40 ? mb_substr($row->title,0,40,"utf-8") : $row->title}}"
                    class="images img-fluid position-relative" style="width:auto; height:180px">
                <img style="position: absolute;" src="{{asset('assets/frontend/assets/images/play-button-80X80.png')}}" class="play-icon" />
            </div>
            <h5 class="font-20 text-black heading-h2 pt-2 pb-2">
                {{strlen($row->title)>40 ? mb_substr($row->title,0,40,"utf-8") : $row->title}}            </h5>
        </a>
    </div>
</div>                            
                     @endforeach                                
									@else 







<div class="col-sm-3">
    <div class="videoSubMore">
        <a href="">
            <div class="text-center vid-single position-relative"
                style="_height:180px; overflow: hidden;background: #f1f1f1;">
                <img src=""
                    alt=" কোন ভিডিও নেই!  "
                    class="images img-fluid position-relative" style="width:auto; height:180px">
                <img style="position: absolute;" src="assets/images/play-button-80X80.png" class="play-icon" />
            </div>
            <h5 class="font-20 text-black heading-h2 pt-2 pb-2">
                কোন ভিডিও নেই!            </h5>
        </a>
    </div>
</div>                            
 @endif	








                        </div>
                    </div>
                </div>
            </div>


            <div class="loading-for-more" style="text-align:center; margin: 50px; font-size:30px; display:none">
                <i class="fa fa-spin fa-spinner"></i>
            </div>

            

        </div>
    </div>
</div>

  
@endsection