@extends('layouts.front')
@section('contents')
@section('meta')
<title>{{ $gs->title }} Unicode Converter | {{ $gs->title }} - ইউনিকোড কনভার্টার</title>
<meta name="robots" content="index, follow">
@endsection

<link href="{{asset('assets/frontend/bangla-converter/css/main1.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/frontend/bangla-converter/css/center.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('assets/frontend/bangla-converter/js/bijoy2uni.js')}}"></script>
<script src="{{asset('assets/frontend/bangla-converter/js/uni2bijoy.js')}}"></script>
<script src="{{asset('assets/frontend/bangla-converter/js/common.js')}}"></script>
<script src="{{asset('assets/frontend/bangla-converter/js/layout.js')}}"></script>
<script src="{{asset('assets/frontend/bangla-converter/js/count.js')}}"></script>
<script src="{{asset('assets/frontend/bangla-converter/js/js1.js')}}"></script>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="common-border-box p-4">
                <h1 class="text-center mb-4" style="font-size:28px;font-weight:700;color:#222;">বাংলা কনভার্টার</h1>

                <div class="mb-3">
                    <textarea class="unicode_textarea form-control" id="EDT" name="textarea" autofocus="autofocus" value="" placeholder="ইউনিকোড কি-বোর্ডের লেখা এখানে পেস্ট করুন" style="min-height:150px;resize:vertical;"></textarea>
                </div>

                <div class="text-center my-3">
                    <input class="btn btn-secondary me-2" onclick="ConvertToTextArea('CONVERTEDT');" type="button" value="বিজয়ে রূপান্তর">
                    <input class="btn btn-primary me-2" onclick="ConvertFromTextArea('CONVERTEDT');" type="button" value="ইউনিকোডে রূপান্তর">
                    <input class="btn btn-outline-danger" type="button" value="মুছে ফেলুন" onclick="ClearInput();">
                </div>

                <div class="mb-3">
                    <textarea class="bijoy_textarea form-control" id="CONVERTEDT" autofocus="autofocus" value="" placeholder="বিজয় কি-বোর্ডের লেখা এখানে পেস্ট করুন" style="min-height:150px;resize:vertical;"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function ClearInput() {
    document.getElementById("EDT").value = '';
    document.getElementById("CONVERTEDT").value = '';
    document.getElementById("EDT").focus();
}
</script>

<style>
.unicode_textarea, .bijoy_textarea {
    font-family: 'SolaimanLipi', Arial, sans-serif;
    font-size: 18px;
    line-height: 1.8;
}
</style>

@endsection