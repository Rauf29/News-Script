@extends('layouts.front')
@section('contents')
@section('meta')
<title>{{$page->title}}</title>
<meta name="Description" content="{!! $page->description!!}">
<meta property="og:title" content="{{$page->title}}" />
<meta property="og:description" content="{!! $page->description!!}" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection
             
                         
 <div class="create-page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="create-pageTitle">                        
                            <span> {{$page->title}} </span>     
                        </div>
                        
                        <div class="create-page-details">
                        <p> {!! $page->description!!} </p>
						</div>
                        
                    </div>
                </div>
            </div>
        </div>

@endsection