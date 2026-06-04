@extends('layouts.front')
 @section('meta')
    <title>ফটো গ্যালারী</title>
<meta property="og:title" content="ফটো গ্যালারী" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection
@section('contents')
 


<div class="container-fluid">

    <!--call photo_home_page-->

    <div class="left-lead-part">
        <div id="photo_home_page_content">
            <style type="text/css">
                .videoLead img.images {
                    height: 335px;
                    width: auto;
                }

                .photoSubSub img.images {
                    height: 160px;
                    width: auto;
                }

                .photo-hl h5 {
                    font-weight: bold;
                    font-size: 18px;
                }

                .pt-Last-lead {
                    height: 70px !important;
                }

                .pht_catlead_hdln {
                    display: block
                }

                .pht_catlead_hdln h5 {
                    font-size: 1.1rem;
                    font-weight: bold;
                    padding: 7px 0px;
                    margin: 0
                }

                .pht_catlead_hdln h4 {
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

            <div class="d-flex catpageSubmenu mb-3">
                <a class="" href="/photo">ছবি</a>
                <i class="fa-regular fa-circle"></i>

                <a class="pe-2" href="#">ঢালিউড</a>
                <i class="fa-regular fa-circle"></i>

                <a class="pe-2" href="#">বলিউড</a>
                <i class="fa-regular fa-circle"></i>

                <a class="pe-2" href="#">টালিউড</a>

                <i class="fa-regular fa-circle"></i>

                <a class="pe-2" href="#">হলিউড</a>
                <i class="fa-regular fa-circle"></i>
                <a class="pe-2" href="#">অন্যান্য</a>

            </div>
            <div class="photo-home">

                <div class="row" id="photoHomeSubMore">
                    <div class="col-lg-12">
                        <div class="row sunset-posts-container">


						 				@php
				$photobig=DB::table('image_albums')->orderBy('id','DESC')->limit(10000000)->get();
				@endphp 
                                @if ($photobig->count()>0)
                               @foreach ($photobig as $row)
 <div class="col-xs-12 col-md-3">
    <div class="submore">
        <a href="{{ route('gallery.view', $row->id) }}">
            <div class="img bg-light text-center position-relative">
                <span class="imgWrep">
                    <img width="500" height="280" src="{{asset('assets/images/image-album/'.$row->photo)}}" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" fetchpriority="high" srcset="{{asset('assets/images/image-album/'.$row->photo)}} 500w, {{asset('assets/images/image-album/'.$row->photo)}} 300w, {{asset('assets/images/image-album/'.$row->photo)}} 768w, {{asset('assets/images/image-album/'.$row->photo)}} 800w" sizes="(max-width: 500px) 100vw, 500px" />                    <i class="fas fa-images position-absolute end-0 top-0 text-white p-1 fs-4"></i>
                </span>
            </div>
            <div class="pht_cat_hdln bg-white box_shadow py-2 clearfix">
                <h5 class="fw-bold text-body">{{$row->album_name}}</h5>
            </div>
        </a>
    </div>
</div>                            
          
	@endforeach
						@else 


 <div class="col-xs-12 col-md-3">
    <div class="submore">
        <a href="assets/images/nopic.png">
            <div class="img bg-light text-center position-relative">
                <span class="imgWrep">
                    <img width="500" height="280" src="assets/images/nopic.png" class="attachment-custom-size size-custom-size wp-post-image" alt="" decoding="async" fetchpriority="high" srcset="assets/images/nopic.png 500w, assets/images/nopic.png 300w, assets/images/nopic.png 768w, assets/images/nopic.png 800w" sizes="(max-width: 500px) 100vw, 500px" />                    <i class="fas fa-images position-absolute end-0 top-0 text-white p-1 fs-4"></i>
                </span>
            </div>
            <div class="pht_cat_hdln bg-white box_shadow py-2 clearfix">
                <h5 class="fw-bold text-body">কোন গ্যালারী ইমেইজ নেই</h5>
            </div>
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