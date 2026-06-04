@extends('layouts.front')
@section('contents')
 @section('meta')
    <title>আমাদের প্রতিনিধি</title>
<meta property="og:title" content="আমাদের প্রতিনিধি" />
<meta property="og:image" content="{{asset('assets/images/'.$gs->og_baner)}}" />
@endsection	 	
<section class="archive-section">

			
			
<!---news option******************--->
			<div class="row">
			    	
							
							                @php
            $horizontal1=DB::table('users')->limit(100000)->get();
            @endphp	
						@foreach($horizontal1 as $row)	
				<div class="col-md-3">
					<div class="profile_news">
						<a href="#"><img width="500" height="300" src="{{asset('assets/images/admin/'.$row->photo)}}" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" srcset="{{asset('assets/images/admin/'.$row->photo)}} 500w, {{asset('assets/images/admin/'.$row->photo)}} 300w" sizes="(max-width: 500px) 100vw, 500px" />						<div class="family_border">
							<h4 class="family">{{$row->name}} :: {{$row->designation}}</a></h4>
							<h4 class="family_deg"></a></h4>
						</div>
					</div>
				</div>
				@endforeach	
				
									
			</div>
	</section>
		
@endsection