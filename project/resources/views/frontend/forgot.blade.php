<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password | {{ $gs->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/fonts/flaticon/font/flaticon.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/login/assets/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/admin/css/toastr.css')}}">
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
                    <h3>Forgot Password</h3>
                    <div class="login-inner-form">
                        <form id="forgotform" action="{{ route('front.forgot.submit') }}" method="POST">
                          @csrf
                            <div class="form-group clearfix">
                                <div class="form-box">
                                    <input name="email" type="email" class="form-control" placeholder="{{__('Type Email Address')}}" aria-label="Email Address">
                                    <i class="flaticon-mail-2"></i>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-primary btn-lg btn-theme">{{__('Send Reset Link')}}</button>
                            </div>
                            <div class="form-group clearfix text-center">
                                <a href="{{ route('front.LogReg') }}">{{__('Back to Login')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/login/assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/login/assets/js/app.js')}}"></script>
<script src="{{asset('assets/admin/js/toastr.js')}}"></script>
{!! Toastr::message() !!}
<script src="{{asset('assets/front/js/login.js')}}"></script>
<script>
(function($) {
    "use strict";
    $(document).ready(function(){
        $("#forgotform").on('submit',function(e){
            e.preventDefault();
            var $btn = $(this).find('button[type=submit]');
            $btn.prop('disabled',true);
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
                        $('input[type=email]').val('');
                    }
                    $btn.prop('disabled',false);
                }
            });
        });
    });
})(jQuery);
</script>
</body>
</html>
