(function( $ ) {

	jQuery(document).ready(function( $ ){

		setTimeout(function(){

			$('.recruitology-widget').each( function(i){

				var target_div = '';
				switch(i){
					case 0: target_div = '#simple-widget-preview';break;
					case 1: target_div = '#job-search-widget-preview';break;
					case 2: target_div = '#advanced-widget-preview';break;
				}

				$(target_div).append( $(this));

			})

		}, 1000);



	 });


})( jQuery );
