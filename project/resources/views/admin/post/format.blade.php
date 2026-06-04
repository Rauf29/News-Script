@extends('layouts.admin')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('CATEGORY') }}">
<input type="hidden" id="attribute_data" value="{{ __('ADD NEW ATTRIBUTE') }}">
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('All Posts') }}</h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('slider.index') }}">{{ __('Posts') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-12 text-right">
            <a href="{{ route('post.index') }}" class="btn btn-primary btn-sm">{{__('All Posts')}}</a>
        </div>
    </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('article.create') }}" class="add-post-area">
                   <div class="icon">
                    <i class="far fa-file-alt"></i>
                   </div>
                   <h6>
                       {{__('Article')}}
                   </h6>
                   <p>{{__('An article with images')}}</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
               <a href="{{ route('image.album.index') }}" class="add-post-area">
                <div class="icon">
                    <i class="far fa-images"></i>
                </div>
                <h6>
                    {{__('Gallery')}}
                </h6>
                <p>{{__('A collection of images')}}</p>
            </a>
            </div>
            <div class="col-lg-4 col-md-6">
            <a href="/admin/rss" class="add-post-area">
                <div class="icon">
                    <i class="fas fa-rss"></i>
                </div>
                <h6>
                    {{__('Rss Feed')}}
                </h6>
                <p>{{__('RSS Feeds article')}}</p>
            </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="/admin/schedule" class="add-post-area">
                 <div class="icon">
                    <i class="fa fa-calendar"></i>
                 </div>
                 <h6>
                     {{__('Schedule Post')}}
                 </h6>
                 <p>{{__('All Schedule Post')}}</p>
             </a>
             </div>

            <div class="col-lg-4 col-md-6">
            <a href="{{ route('video.create') }}" class="add-post-area">
                <div class="icon">
                    <i class="fas fa-film"></i>
                </div>
                <h6>
                    {{__('Video')}}
                </h6>
                <p>{{__('Upload or embed videos')}}</p>
            </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('audio.create') }}" class="add-post-area">
                    <div class="icon">
                        <i class="fas fa-volume-up"></i>
                    </div>
                    <h6>
                        {{__('Audio')}}
                    </h6>
                    <p>{{__('Upload audios')}}</p>
                </a>
            </div>
        </div>
</div>



@endsection
