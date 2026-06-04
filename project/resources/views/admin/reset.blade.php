<!doctype html>
<html lang="en" dir="ltr">
  
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="author" content="TechPeaks Solutions">
    <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Reset Password | {{ $gs->title }}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/'.$gs->favicon)}}" type="image/x-icon">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/fonts/flaticon/font/flaticon.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/css/style.css')}}">
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/admin/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/icofont.min.css')}}">
    <link href="{{asset('assets/admin/plugins/fullside-menu/css/dark-side-style.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/plugins/fullside-menu/waves.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/plugin.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" />   
      <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-coloroicker.css') }}">
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/css/custom.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/toastr.css')}}" rel="stylesheet" />
@yield('styles')
</head>
<body id="top">
<div class="page_loader"></div>
<div class="login-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="form-section">
                    <div class="logo">
                        <a href="/">
                            <img src="{{asset('assets/images/logo/'.$gs->logo)}}" alt="logo">
                        </a>
                    </div>
                    <h3>নতুন পাসওয়ার্ড সেট করুন</h3>
                    <div class="login-inner-form">
					@include('includes.admin.form-login')
                     <form id="resetform" action="{{ route('admin.reset.password.submit') }}" method="POST">
                          {{ csrf_field() }}
                          <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group clearfix">
                                <div class="form-box">
                                    <input name="password" type="password" class="form-control" autocomplete="off" placeholder="{{ __('New Password (min 8 chars)') }}" aria-label="New Password">
                                    <i class="flaticon-password"></i>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="form-box">
                                    <input name="password_confirmation" type="password" class="form-control" autocomplete="off" placeholder="{{ __('Confirm New Password') }}" aria-label="Confirm Password">
                                    <i class="flaticon-password"></i>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <button class="btn btn-primary btn-lg btn-theme">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="{{asset('assets/admin/js/vendors/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/vendors/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/fullside-menu/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/fullside-menu/waves.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugin.js')}}"></script>
    <script src="{{asset('assets/admin/js/tag-it.js')}}"></script>
    <script src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{asset('assets/admin/js/load.js')}}"></script>
    <script src="{{asset('assets/admin/js/custom.js')}}"></script>
    <script src="{{asset('assets/admin/js/myscript.js')}}"></script>
<script src="{{asset('assets/admin/js/toastr.js')}}"></script>
{!! Toastr::message() !!}
<script src="{{asset('assets/login/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/app.js')}}"></script>
<script>
(function($) {
    "use strict";
    $(document).ready(function(){
        $("#resetform").on('submit',function(e){
            e.preventDefault();
            $('button.submit-btn').prop('disabled',true);
            $.ajax({
                method:"POST",
                url:$(this).prop('action'),
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    if ((data.errors)) {
                        toastr.error(data.errors[0]);
                    } else {
                        toastr.success(data);
                        window.location = '{{ route("admin.loginForm") }}';
                    }
                    $('button.submit-btn').prop('disabled',false);
                }
            });
        });
    });
})(jQuery);
</script>
</body>
</html>
