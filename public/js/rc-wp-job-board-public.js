(function( $ ) {

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function( $ ){

		console.log(rc_settings);
		console.log( $('.recruitology-widget') );

		setTimeout(function(){
			$('#rc-jb-holder').append( $('.recruitology-widget') );

			if( rc_settings ){
				$('.job-listings-headline strong').html( rc_settings['title-text'] );
				$('.job-listings-tagline').html( rc_settings['tagline-text'] );

				var rc_css = '';

				if( !rc_settings['show-border'] ){
					rc_css += ".job-listings-outer-container{  border: none !important; }";
				}

				if( !rc_settings['show-logo'] ){
					rc_css += "#header_logo{  display: none !important; }";
				}

				if( !rc_settings['show-header-text'] ){
					rc_css += ".job-listings-header-container{  display: none !important; }";
				}

				var rc_primary_color = rc_settings['primary-color'];
				rc_css += ".recruitology-widget th,.recruitology-widget a{ color: " + rc_primary_color + " !important; }";
				rc_css += ".recruitology-widget button{ background-color: " + rc_primary_color + " !important; border-color: " + rc_primary_color + " !important; }";

				var alt_row_color = rc_settings['alt-row-color'];
				rc_css += ".recruitology-widget table tr:nth-child(even){ background-color: " + alt_row_color + " !important; }";

				$('.rc-widget-styles').html(rc_css);


			}


		}, 1500);



	});

})( jQuery );
