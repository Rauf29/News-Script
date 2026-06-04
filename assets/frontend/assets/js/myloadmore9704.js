jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
	$('#find_more').click(function(){
		jQuery('.loading-for-more').show();
		var button = $(this),
		    data = {
			'action': 'loadmore',
			'query': misha_loadmore_params.posts, // that's how we get params from wp_localize_script() function
			'page' : misha_loadmore_params.current_page
		};
 
		$.ajax({ // you can also use $.post here
			url : misha_loadmore_params.ajaxurl, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.hide(); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) { 
					// button.text( 'More posts' ).prev().before(data); // insert new posts
					jQuery('.sunset-posts-container').append(data);; // insert new posts
					misha_loadmore_params.current_page++;
 
					if ( misha_loadmore_params.current_page == misha_loadmore_params.max_page ) 
						button.remove(); 
 
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					// button.remove(); // if no data, remove the button as well
				}
				jQuery('.loading-for-more').hide();
				button.show();
			}
		});
	});
});