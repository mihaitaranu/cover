/* When DOM is fully loaded */ 
jQuery(document).ready(function($) {

	var check_interval = setInterval(function(){ check_result() }, 500);

	function check_result() {
	 	var result = $( '#muttley-importer-message' ).text();
	 	if ( result.indexOf('All done. Have fun!') >= 0 ) {
	 		clearTimer();
	 		$( '#muttley-importer-success' ).fadeIn();
	 		$( '.muttley-importer-content' ).fadeOut();
	 		$( '.button-primary muttley-import-start' ).hide();
	 	}

	}

	function clearTimer() {
	    clearInterval(check_interval);
	}

});