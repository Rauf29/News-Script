@php
	$seo=DB::table('seotools')->first();
@endphp
<!DOCTYPE html>
<html lang="en-GB">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="TechPeaks Solutions">
    @hasSection('meta')
        @yield('meta')
    @else
        <title>{{ $gs->title }}</title>
    @endif
    @if($gs->facebook_app_id)
    <meta property="fb:app_id" content="{{ $gs->facebook_app_id }}" />
    @endif
    <link rel="shortcut icon" href="{{asset('assets/images/'.$gs->favicon)}}" type="image/x-icon">

    	 {!!$gs->adsense_code!!}
		  {!!$gs->search_console!!}
	{!! $seo->google_analytics !!}




<style id='classic-theme-styles-inline-css' type='text/css'>
/*! This file is auto-generated */
.wp-block-button__link{color:#fff;background-color:#32373c;border-radius:9999px;box-shadow:none;text-decoration:none;padding:calc(.667em + 2px) calc(1.333em + 2px);font-size:1.125em}.wp-block-file__button{background:#32373c;color:#fff;text-decoration:none}
</style>
<style id='global-styles-inline-css' type='text/css'>
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
</style>
<link rel='stylesheet' id='share-this-share-buttons-sticky-css' href='{{asset('assets/frontend/css/mu-style5ab0.css?ver=1736199275')}}' type='text/css' media='all' />
<link rel='stylesheet' id='wp-polls-css' href='{{asset('assets/frontend/polls-css2a9a.css?ver=2.77.2')}}' type='text/css' media='all' />
<style id='wp-polls-inline-css' type='text/css'>
.wp-polls .pollbar {
	margin: 1px;
	font-size: 6px;
	line-height: 8px;
	height: 8px;
	background-image: url('{{asset('assets/frontend/images/default/pollbg.gif')}}');
	border: 1px solid #c8c8c8;
}

</style>
<link rel='stylesheet' id='codedokan-style-css' href='{{asset('assets/frontend/style9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='bootstarp-css' href='{{asset('assets/frontend/assets/css/bootstrap.min9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='fonts-css' href='{{asset('assets/frontend/assets/css/fonts9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='lightbox_css-css' href='{{asset('assets/frontend/assets/css/jquery.lightbox9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='flex_slider_style-css' href='{{asset('assets/frontend/assets/css/flexslider9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome-css' href='{{asset('assets/frontend/assets/css/fontawesome9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='main-css-css' href='{{asset('assets/frontend/assets/css/main9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='responsive-css-css' href='{{asset('assets/frontend/assets/css/responsive9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='responsive-css-css' href='{{asset('assets/frontend/assets/css/responsive9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='toastr-css' href='{{asset('assets/admin/css/toastr.css')}}' type='text/css' media='all' />
<script type="text/javascript" src="{{asset('assets/frontend/js/jquery/jquery.minf43b.js?ver=3.7.1')}}" id="jquery-core-js"></script>
<script type="text/javascript" src="{{asset('assets/frontend/js/jquery/jquery-migrate.min5589.js?ver=3.4.1')}}" id="jquery-migrate-js"></script>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethisb6db.js?ver=2.3.3#property=67554864d5bedc001907e4fb&amp;product=inline-buttons&amp;source=sharethis-share-buttons-wordpress" id="share-this-share-buttons-mu-js"></script>


	<style type="text/css">
		.ajax-calendar{
			position:relative;
		}

		#ajax_ac_widget th {
		background: none repeat scroll 0 0 #2cb2bc;
		color: #FFFFFF;
		font-weight: normal;
		padding: 5px 1px;
		text-align: center;
		 font-size: 16px;
		}
		#ajax_ac_widget {
			padding: 5px;
		}
		
		#ajax_ac_widget td {
			border: 1px solid #CCCCCC;
			text-align: center;
		}
		
		#my-calendar a {
			background: none repeat scroll 0 0 #008000;
			color: #FFFFFF;
			display: block;
			padding: 6px 0;
			width: 100% !important;
		}
		#my-calendar{
			width:100%;
		}
		
		
		#my_calender span {
			display: block;
			padding: 6px 0;
			width: 100% !important;
		}
		
		#today a,#today span {
			   background: none repeat scroll 0 0 #2cb2bc !important;
			color: #FFFFFF;
		}
		#ajax_ac_widget #my_year {
			float: right;
		}
		.select_ca #my_month {
			float: left;
		}

	</style>



<style id="codedokan-dynamic-css" title="dynamic-css" class="redux-options-output">body{font-family:SolaimanLipi;line-height:16px;font-weight:normal;font-style:normal;font-size:16px;}</style>    



</head>



<body class="home blog wp-custom-logo">

    <style type="text/css">
        .dropbtn {
            color: #1f1f1f !important;
            font-size: 14px !important;
            line-height: 20px !important;
            font-weight: 600 !important
        }



        .dropbtn {
            background-color: #fff;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            _padding: 2px 9px;
            _border: 1px solid #ccc;
            _border-radius: 5px;
            _margin-right: 8px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 99999;
        }

        .dropdown-content a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #ccc;
        }

        .show {
            display: block !important;
        }
    </style>
<script>
function dateToday(id, lang) {
    var now = new Date();
    var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    var day = days[now.getDay()];
    var date = now.getDate();
    var month = months[now.getMonth()];
    var year = now.getFullYear();
    var str = day + ', ' + date + ' ' + month + ' ' + year;
    if (lang === 'bangla') {
        var bn = {'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
        var bnDay = {'Sunday':'রবিবার','Monday':'সোমবার','Tuesday':'মঙ্গলবার','Wednesday':'বুধবার','Thursday':'বৃহস্পতিবার','Friday':'শুক্রবার','Saturday':'শনিবার'};
        var bnMonths = {'January':'জানুয়ারি','February':'ফেব্রুয়ারি','March':'মার্চ','April':'এপ্রিল','May':'মে','June':'জুন','July':'জুলাই','August':'আগস্ট','September':'সেপ্টেম্বর','October':'অক্টোবর','November':'নভেম্বর','December':'ডিসেম্বর'};
        str = bnDay[day] + ', ' + date.toString().replace(/\d/g, function(m){ return bn[m]; }) + ' ' + bnMonths[month] + ' ' + year.toString().replace(/\d/g, function(m){ return bn[m]; });
    }
    var el = document.getElementById(id);
    if (el) { el.innerHTML = str; }
}
dateToday('date-today', 'bangla');
</script>

<script>
function displayTime() {
    var clock = document.getElementById('Clock');
    if (!clock) return;

    const timeNow = new Date();
    let hoursOfDay = timeNow.getHours();
    let minutes = timeNow.getMinutes();
    let seconds = timeNow.getSeconds();
    let period = "AM";

    if (hoursOfDay > 12) {
        hoursOfDay -= 12;
        period = "PM";
    }
    if (hoursOfDay === 0) {
        hoursOfDay = 12;
        period = "AM";
    }

    hoursOfDay = hoursOfDay < 10 ? "0" + hoursOfDay : hoursOfDay;
    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    var time = hoursOfDay + ":" + minutes + ":" + seconds + " " + period;
    clock.innerHTML = time;

    var chars = {'1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯','0':'০','A':'এ','P':'পি','M':'এম'};
    clock.innerHTML = clock.innerHTML.replace(/[1234567890AMP]/g, function(m) { return chars[m]; });
}
setInterval(displayTime, 1000);
displayTime();
</script>
						
    
	
	
	    <!-- Header Part-->
    @include('partial.front.header')
    <!-- Header Part End-->
	
	
	
	
	
	
     <!--Content of each page-->
    @yield('contents')
	<!--Content of each page end-->



	<!-- Footer Area Start -->
	@include('partial.front.footer')
	<!-- Footer Area End -->

 <link rel='stylesheet' id='dashicons-css' href='{{asset('assets/frontend/css/dashicons.min9704.css?ver=6.7.1')}}' type='text/css' media='all' />
<link rel='stylesheet' id='thickbox-css' href='{{asset('assets/frontend/js/thickbox/thickbox9704.css?ver=6.7.1')}}' type='text/css' media='all' />

<script type="text/javascript" src="{{asset('assets/admin/js/toastr.js')}}"></script>
{!! Toastr::message() !!}
<script type="text/javascript" src="{{asset('assets/frontend/assets/js/script.js')}}" id="script-js"></script>
<script type="text/javascript" src="{{asset('assets/frontend/assets/js/jquery.lightbox.js')}}" id="script_lightbox-js"></script>
<script type="text/javascript" src="{{asset('assets/frontend/assets/js/jquery.flexslider.js')}}" id="script_flexslider-js"></script>


<div id="back-top" class="back-top" style="">
    <span></span>
</div>

</body>


</html>
