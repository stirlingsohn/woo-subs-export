(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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


	
	$('#wse-ajax-form').on('submit', function(e) {
		e.preventDefault();
	    
	    var form = $(this);
	    var msgField = form.find('.wse-message');
	    var resultField = form.find('.wse-result');
	    var spinner = form.find('.spinner');

	    // reset form
	    msgField.html('');
	    resultField.html('');

	    spinner.addClass('is-active');

	    $.post(form.attr('action'), form.serialize(), function(response) {
	        console.log(response);
	        spinner.removeClass('is-active');
	        if ( response.error_message ) {
	            msgField.html( response.error_message );
	        } else {
	            //form.find('.form-content').slideToggle(500);
	            msgField.html( response.success_message );
	            resultField.html( response.data );
	        }
	    }, 'json');
	
	});
	

})( jQuery );