@if($results->count()>0)
    @foreach ($results as $post)
    <a href="{{ route('frontend.postBySubcategory.details',[$post->category->slug,$post->slug]) }}" class="dropdown-item py-2 d-flex align-items-center gap-2">
        <img src="{{ $post->image_big ? asset('assets/images/post/'.$post->image_big) : $post->rss_image }}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;" alt="">
        <div>
            <div style="font-size:13px;line-height:1.3;">{{ strlen($post->title)>60 ? mb_substr($post->title,0,60,'utf-8').'...' : $post->title }}</div>
            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
        </div>
    </a>
    @endforeach
    <div class="dropdown-divider"></div>
    <a href="{{ route('front.news_search') }}?search={{ request('search') }}" class="dropdown-item text-center text-primary fw-bold">
        <i class="fa fa-search me-1"></i> সব ফলাফল দেখুন
    </a>
@else
    <div class="dropdown-item text-muted text-center py-3">
        <small>"{{ request('search') }}" — কোন ফলাফল পাওয়া যায়নি</small>
    </div>
@endif