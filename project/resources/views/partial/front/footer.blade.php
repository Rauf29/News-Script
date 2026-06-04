<footer>
    <div class="border-bottom border-top">
        <div class="container-fluid">
            <div class="d-flex justify-content-between py-2">
                <div class="footer_logo">
                    <a class="logo" href="{{route('frontend.index')}}">
                        <img style="width:120px" class="img-fluid logo"
                            src="{{asset('assets/images/logo/'.$gs->logo)}}" />
                    </a>
                </div>
                <div class=" bottom-navigation">
                    
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid py-2 mt-3 site-address">
        <div class="row">
            <div class="col-md-6">
                <p class="site-add-p">
                    <span class="sompadok">সম্পাদক ও প্রকাশক: {{ $gs->prokashok }} | নির্বাহী সম্পাদক: {{ $gs->sompadok }}</span></br>
                   {{ $gs->adress }}               </p>
            </div>
            <div class="col-md-6">
                ফোনঃ {{ $gs->phone }} । বিজ্ঞাপন বিভাগঃ {{ $gs->phone2 }}
 <a href="{{ $gs->email }}" class="__cf_email__" data-cfemail="8fe1eaf8fccfe1eaf8fca1edeee1e8e3eef8eaedfca1ece0e2">ই-মেইলঃ {{ $gs->email }} , {{ $gs->email2 }}</a><a href="{{ $gs->email }}" class="__cf_email__" data-cfemail="244d4a424b644a4153570a46454a434845534146570a474b49"></a>            </div>
        </div>

    </div>
    <div class="py-3 border-top" id="footer-social">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-7 mb-3">
                    <div class="title d-inline-block">
                        <i class="fas fa-share-alt"></i>
                        <span style="margin-top: 7px; display: inline-block; font-weight: bold;font-size: 14px;">সোশ্যাল
                            মিডিয়া</span>
                    </div>
                    <div class="soacial-icon mt-2">
                        <div class="d-flex flex-row">
						
						@foreach ($social_links as $social_link) 
                            <a href="{{ $social_link->link}}" class="{{$social_link->name}}">
                                <i class="{{$social_link->icon}}"></i>
                            </a>
							@endforeach	
							
                           
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="newsletter">
                        <h5 class="title d-inline-block">
                            <i class="far fa-envelope-open" style="font-size: 30px; float: left"></i>
                            <span style="margin-top: 7px; display: inline-block;">নিউজলেটার </span>
                        </h5>
                        <div class="d-block">প্রতিদিন মেইলে আপডেট পেতে সাবস্ক্রাইব করুন।</div>
                        <form action="{{ route('front.subscribers.store') }}" method="POST" class="mt-2">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control form-control-sm" placeholder="ইমেইল দিন" name="email" required>
                                <button class="btn btn-primary btn-sm" type="submit">সাবস্ক্রাইব</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="mobile_app">
                        <h5 class="title d-inline-block">
                            <i class="fas fa-mobile-alt" style="font-size: 30px; float: left"></i>
                            <span style="margin-top: 7px; display: inline-block;">মোবাইল অ্যাপস</span>
                        </h5>
                        <div>
                            <a class="d-block" href="{{ $gs->app1 }}">
                                <i class="far fa-share-square me-2"></i>অ্যান্ড্রয়েড
                            </a>
                            <a class="d-block" href="{{ $gs->app2 }}">
                                <i class="far fa-share-square me-2"></i>আইফোন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-light py-2">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div>
                    {!! $gs->copyright_text !!}              </div>

                <div>
                    Powered by <a href="https://techpeaks.com.bd/">TechPeaks Solutions</a>               </div>
            </div>
        </div>
    </div>

</footer>