@extends('layouts.front')

@section('contents')
<div class="container">
    <h1>Posts by Date: {{ $date ?? '' }}</h1>
    @forelse ($datas ?? [] as $post)
        <div class="single-news">
            <h4><a href="{{ route('frontend.postBySubcategory.details', [$post->category->slug ?? '', $post->slug]) }}">{{ $post->title }}</a></h4>
        </div>
    @empty
        <p>No posts found for this date.</p>
    @endforelse
</div>
@endsection
