@extends('layouts.front')
@section('contents')
    @section('meta')
<title>{{$data->title}}</title>
<meta property="og:title" content="{{$data->title}}" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection	

<div class="container-fluid py-3">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                <span style="background:#1a73e8;color:#fff;padding:6px 18px;border-radius:4px;font-weight:700;font-size:16px;">{{$data->title}}</span>
            </div>

            @if ($posts->count()>0)
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
                    @foreach ($posts as $post)
                    <div class="col">
                        <div class="common-card-content position-relative common-border-box h-100">
                            <div class="image-lead position-relative text-center">
                                <span class="imgWrep d-block">
                                    <img width="500" height="280" src="{{asset('assets/images/post/'.$post->image_big)}}" class="attachment-custom-size size-custom-size wp-post-image w-100" alt="" style="height:180px;object-fit:cover;border-radius:8px 8px 0 0;" decoding="async" loading="lazy" />
                                </span>
                                <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post->id,$post->slug])}}"></a>
                            </div>
                            <div class="news-content-box p-2">
                                <div class="position-relative">
                                    <h5 class="title fw-bold" style="font-size:15px;line-height:1.4;">
                                        {{ strlen($post->title)>80 ? mb_substr($post->title,0,80,'utf-8').'...' : $post->title}}
                                    </h5>
                                    <a class="link" href="{{ route('frontend.postBySubcategory.details',[$post->id,$post->slug])}}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-danger mb-0">{{__('আজকে কোনো সংবাদ নেই!')}}</p>
                </div>
            @endif

            <div class="text-center mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .common-card-content .title {
        color: #222;
        transition: color .15s;
    }
    .common-card-content:hover .title {
        color: #1a73e8;
    }
    .image-lead .link {
        position: absolute;
        inset: 0;
    }
    .news-content-box .link {
        position: absolute;
        inset: 0;
    }
</style>

@endsection