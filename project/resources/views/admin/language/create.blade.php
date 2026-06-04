@extends('layouts.admin')

@section('styles')

<style type="text/css">
  
textarea.input-field {
  padding: 20px 20px 0px 20px;
  border-radius: 0px;
}

</style>

@endsection

@section('content')

            <div class="content-area">
              <div class="mr-breadcrumb">
                <div class="row">
                  <div class="col-lg-12">
                      <h4 class="heading">{{ __('Add Language') }} <a class="add-btn" href="{{route('admin.language.index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="javascript:;">{{ __('Language Settings') }}</a></li>
                        <li>
                          <a href="{{ route('admin.language.index') }}">{{ __('Website Language') }}</a>
                        </li>
                        <li>
                          <a href="{{ route('admin.language.create') }}">{{ __('Add Language') }}</a>
                        </li>
                      </ul>
                  </div>
                </div>
              </div>
              <div class="add-product-content">
                <div class="row">
                  <div class="col-lg-12">
                    @include('includes.admin.form-error')
                    @include('includes.admin.form-success')
                    <div class="product-description">
                      <div class="body-area">
                      <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                      <form id="geniusform" action="{{route('admin.language.store')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
            
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Language') }}</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="language" placeholder="{{ __('Language') }}"  value="English">
                          </div>
                        </div>
                        

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Language Direction') }}</h4>

                            </div>
                          </div>
                          <div class="col-lg-7">
                            <select name="rtl" class="input-field" >
                              <option value="0">{{ __('Left To Right') }}</option>
                              <option value="1">{{ __('Right To Left') }}</option>
                            </select>
                          </div>
                        </div>
                      <hr>
                        
                        <h4 class="text-center">{{ __('SET LANGUAGE KEYS & VALUES') }}</h4>

                      <hr>
                        <div class="row">
                          <div class="col-lg-2">
                            <div class="left-area">

                            </div>
                          </div>
                         <div class="col-lg-8">
                            <div class="featured-keyword-area">
                              <div class="lang-tag-top-filds" id="lang-section">

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Search what you want</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Search what you want</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Trending Now!</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Trending Now!</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Login</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Login</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Register</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Register</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Dashboard</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Dashboard</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Logout</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Logout</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >FEATURED</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >FEATURED</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >RECENT</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >RECENT</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >TOP VIEWS</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >TOP VIEWS</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >CATEGORIES</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >CATEGORIES</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Follow Us</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Follow Us</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >TAGS</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >TAGS</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Poll</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Poll</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Previous Result</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Previous Result</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Vote</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Vote</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >View Result</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >View Result</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Newsletter</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Newsletter</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Subscribe to our newsletter to stay.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Subscribe to our newsletter to stay.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Enter Your Email Address</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Enter Your Email Address</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Subscribe</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Subscribe</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >TODAYS FEATURED NEWS</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >TODAYS FEATURED NEWS</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >View all</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >View all</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Image Gallery</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Image Gallery</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >More news</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >More news</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Load More</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Load More</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Sponsor Ad</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Sponsor Ad</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Home</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Home</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >News</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >News</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Leave A Comment</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Leave A Comment</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Read More</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Read More</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Share</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Share</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Category has no news.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Category has no news.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Writer Dashboard</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Writer Dashboard</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Follow</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Follow</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Followers</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Followers</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Post</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Post</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Author has no News.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Author has no News.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Member Since</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Member Since</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Search Key has no News.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Search Key has no News.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Login & Register</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Login & Register</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >LOGIN NOW</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >LOGIN NOW</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Type Email Address</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Type Email Address</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Type Password</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Type Password</textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Remember Password</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Remember Password</textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Or</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Or</textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Sign In with social media</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Sign In with social media</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Signup Now</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Signup Now</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Full Name</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Full Name</textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Email Address</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Email Address</textarea>
                                    </div>
                                  </div>
                                </div>


                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Phone Number</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Phone Number</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Password</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Password</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Confirm Password</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Confirm Password</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Enter Code</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Enter Code</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Correct Answer</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Correct Answer</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Wrong Answer</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Wrong Answer</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Date has no News.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Date has no News.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Sub Category has no News.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Sub Category has no News.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >This Tag has no News.</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >This Tag has no News.</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="lang-area">
                                  <span class="remove lang-remove"><i class="fas fa-times"></i></span>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <textarea name="keys[]" class="input-field" placeholder="Enter Language Key" >Loading</textarea>
                                    </div>

                                    <div class="col-lg-6">
                                      <textarea name="values[]" class="input-field" placeholder="Enter Language Value" >Loading</textarea>
                                    </div>
                                  </div>
                                </div>
                                
                              </div>
                              <a href="javascript:;" id="lang-btn" class="add-fild-btn"><i class="icofont-plus"></i> Add More Field</a>
                            </div>
                          </div>

                          <div class="col-lg-2">
                            <div class="left-area">

                            </div>
                          </div>

                        </div>
        
                        <hr>
                        <div class="row">
                          <div class="col-lg-5">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Language') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection

@section('scripts')

<script type="text/javascript">
    "use strict";
    var lang = {
      'language_key':'{{ __('Enter Language Key') }}',
      'language_value':'{{ __('Enter Language Key') }}',
    }
</script>
<script src="{{asset('assets/admin/js/language.js')}}"></script>

@endsection