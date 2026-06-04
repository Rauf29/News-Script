@extends('layouts.front')
@section('meta')
    <title>{{$gallery->album_name}}</title>
<meta property="og:title" content="{{$gallery->album_name}}" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection
@section('contents')

<div class="container-fluid">

    <div class="left-lead-part">
        <div id="photo_home_page_content">
            <style type="text/css">
                .photo-gallery-item {
                    margin-bottom: 20px;
                }
                .photo-gallery-item img {
                    width: 100%;
                    height: auto;
                    border-radius: 4px;
                }
                .gallery-album-title {
                    font-size: 24px;
                    font-weight: bold;
                    padding: 15px 0;
                    border-bottom: 2px solid #0573e6;
                    margin-bottom: 20px;
                }
            </style>

            <div class="gallery-album-title">
                {{$gallery->album_name}}
            </div>

            @if($gallery->categories->count() > 0)
                @foreach($gallery->categories as $category)
                    <div class="gallery-category-title" style="font-size:18px;font-weight:bold;padding:10px 0;border-bottom:1px solid #ddd;margin-bottom:15px;margin-top:20px;">
                        {{$category->name}}
                    </div>
                    <div class="row">
                        @if($category->galleries->count() > 0)
                            @foreach($category->galleries as $image)
                                <div class="col-xs-12 col-md-3 photo-gallery-item">
                                    <a href="{{ route('gallery.image.show', $image->id) }}" target="_blank">
                                        <img src="{{asset('assets/images/image-gallery/'.$image->gallery)}}" alt="{{$gallery->album_name}}">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-2">
                                <h6>{{__('No images in this category.')}}</h6>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="row">
                    @if($gallery->galleries->count() > 0)
                        @foreach($gallery->galleries as $image)
                            <div class="col-xs-12 col-md-3 photo-gallery-item">
                                <a href="{{ route('gallery.image.show', $image->id) }}" target="_blank">
                                    <img src="{{asset('assets/images/image-gallery/'.$image->gallery)}}" alt="{{$gallery->album_name}}">
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center py-5">
                            <h5>{{__('No images found in this album.')}}</h5>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>

@endsection