@extends('layouts.admin')

@section('content')
<div class="content-area">
    <div class="row row-cards-one">
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg1">
                <div class="left">
                    <h5 class="title">{{ __('নিউজ') }} </h5>
                    @php
                        $user = Auth::guard('admin')->user()->role;
                    @endphp
                    @if ($user->name != 'admin' && $user->name != 'moderator')
                        <span class="number">{{ $author_post }}</span>
                    @else 
                        <span class="number">{{ $total_post }}</span>
                    @endif
                    <a href="{{ route('post.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg2">
                <div class="left">
                    <h5 class="title">{{ __('পেন্ডিং নিউজ') }}</h5>
                    @if ($user->name != 'admin' && $user->name != 'moderator')
                        <span class="number">{{ $author_pending }}</span>
                    @else 
                        <span class="number">{{ $pending_posts }}</span>
                    @endif
                    <a href="{{ route('pending.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-hourglass"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg3">
                <div class="left">
                    <h5 class="title">{{ __('ড্রাফট') }}</h5>
                    <span class="number">{{ $drafts }}</span>
                    <a href="{{ route('draft.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-pen-square"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg4">
                <div class="left">
                    <h5 class="title">{{ __('সিডিউল নিউজ') }}</h5>
                    <span class="number">{{ $schedules }}</span>
                    <a href="{{ route('schedule.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg5">
                <div class="left">
                    <h5 class="title">{{ __('আরআরএস ফিড') }}</h5>
                    <span class="number">{{ $rss}}</span>
                    <a href="{{ route('rss.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-rss"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
            <div class="mycard bg6">
                <div class="left">
                    <h5 class="title">{{ __('পুলস') }}</h5>
                    <span class="number">{{ $polls}}</span>
                    <a href="{{ route('addPolls.index') }}" class="link">{{ __('সব গুল') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="fas fa-poll"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->guard('admin')->user()->whereId(1)->exists())
        
    <div class="row row-cards-one">
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\Admin::where('id','!=',1)->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count()  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('নতুন রিপোর্টার') }}</h6>
                    <p class="text">{{ __('শেষের ৩০ দিনের') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ App\Models\Admin::where('id','!=',1)->count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('সকল রিপোর্টার') }}</h6>
                    <p class="text">{{ __('সমস্ত সময়ের জন্য') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Subscriber::get()->count()  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('সকল সাবস্ক্রাইবার') }}</h6>
                    <p class="text">{{ __('সমস্ত সময়ের জন্য') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Font::get()->count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('সমস্ত ফন্টস') }}</h6>
                    <p class="text">{{ __('সমস্ত সময়ের জন্য') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards-one">
        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <h5 class="card-header">{{ __('নতুন রিপোর্টার') }}</h5>
                <div class="card-body">
                    <div class="my-table-responsiv">
                        <table class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('ইমেইল') }}</th>
                                    <th>{{ __('জয়েনের তারিখ') }}</th>
                                </tr>
                                @foreach($userRole as $role)
                                    @foreach ($role->users()->orderBy('id','desc')->take(10)->get() as $data)
                                        <tr>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-xl-6">
            <div class="card">
                <h5 class="card-header">{{ __('ইমেইল সাবস্ক্রাইবার') }}</h5>
                <div class="card-body">
                    <div class="my-table-responsiv">
                        <table class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __("সিরিয়াল") }}</th>
                                    <th>{{ __("ইমেইল") }}</th>
                                </tr>
                                @foreach($subscribers as $data)
                                    <tr>
                                        <td>{{ $data->id }}</td>
                                        <td>{{ $data->email }}</td>
                                    </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection

@section('scripts')

@endsection