/*
 * ResVid ver. 1.0.0
 * jQuery Responsive Video Plugin
 *
 * Copyright (c) 2015 Mariusz Rek
 * Rascals Themes 2015
 *
 */

(function($){

 	$.fn.extend({ 
 		
		//pass the options variable to the function
 		ResVid: function(options) {


			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				syntax : ''
			}
				
			var options =  $.extend(defaults, options);

    		return $('iframe', this).each(function(i) {

    			if ( $( this ).parent().hasClass( 'wpb_video_wrapper' ) ) {
    				return;
    			}
				var 
					$o = options,
					$iframe = $(this);
					$players = /www.youtube.com|player.vimeo.com/;
				
				if ($iframe.attr('src') !== undefined && $iframe.attr('src') !== '' && $iframe.attr('src').search($players) > 0) {

					// Ratio
					var $ratio = ($iframe.height() / $iframe.width()) * 100;

					// Add some CSS to iframe
					$iframe.css({
						position : 'absolute',
						top : '0',
						left : '0',
						width : '100%',
						height : '100%'
					});

					// Add wrapper element
					$iframe.wrap('<div class="video-wrap" style="width:100%;position:relative;padding-top:'+$ratio+'%" />');
				}
				
				
			
    		});
    	}
	});
	
})(jQuery);


/*
 * TopTip ver. 1.1.0
 * jQuery Tooltip effect
 *
 * Copyright (c) 2016
 * Rascals Themes 2016
 *
 */
 

(function($){

   $.fn.topTip = function(options) {

	   	//Set the default values, use comma to separate the settings, example:
		var defaults = {
			syntax : ''
		}
			
		var options = $.extend(defaults, options),
			el_name = this.selector;

  		$( document ).on( 'click',  function(e) {
  			e.stopPropagation();
  			$('#tip').remove(); 
  		});
	    $( document ).on( 'mouseenter', el_name, function(e) {
			// Add tip object
			var 
				tip = {},
				title = '',
				min_width = 200;
				mouse_move = false,
				tip = { 
				'desc' : $(this).data('tip-desc'),
				'top' : $(this).offset().top,
				'content' :  $(this).find('.tip-content').html()
			};

			e.stopPropagation();
			$('#tip').remove();
			// Check if title is exists
			if (tip.content == undefined) return;

			// Append datatip prior to closing body tag
			$('body').append('<div id="tip"><div class="tip-content"><div class="tip-inner">'+tip.content+'</div></div></div>');

			// Set max width
			if ($(this).outerWidth() > min_width) {
				$('#tip .tip-inner').width($(this).outerWidth()-40);
			}

			// Store datatip's height and width for later use
			tip['h'] = $('#tip div:first').outerHeight()+100;
			tip['w'] = $('#tip div:first').outerWidth();

			// Set datatip's mask properties - position, height, width etc  
			$('#tip').css({position:'absolute', overflow:'hidden', width:'100%', top:tip['top']-tip['h'], height:tip['h'], left:0 });

			// Mouse Move
			if (mouse_move) {

				// Set tip position
				$('#tip div').css({ left:e.pageX-(tip['w']/2), top:tip['h']+5 });
				TweenMax.to( $( '#tip div' ), 0.5, { top:100, ease:Power2.easeOut } );

				// Move datatip according to mouse position, whilst over instigator element
				$( this ).mousemove(function(e){ $('#tip div').css({left: e.pageX-(tip['w']/2)}); });
			} else {
				// Set tip position
				var pos = $(this).offset();
				$('#tip div').css({ left: pos.left+'px', top:tip['h']+5 });
				TweenMax.to( $( '#tip div' ), 0.5, { top:100, ease:Power2.easeOut } );
			}


	    }).on('mouseleave click', el_name, function(e) {

	      	// Remove datatip instances
	    	$('#tip').remove(); 

	    });
	
	}

})(jQuery);


/*!
 * jquery.unevent.js 0.2
 * https://github.com/yckart/jquery.unevent.js
 *
 * Copyright (c) 2013 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/07/26
**/
;(function ($) {
    var on = $.fn.on, timer;
    $.fn.on = function () {
        var args = Array.apply(null, arguments);
        var last = args[args.length - 1];

        if (isNaN(last) || (last === 1 && args.pop())) return on.apply(this, args);

        var delay = args.pop();
        var fn = args.pop();

        args.push(function () {
            var self = this, params = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(self, params);
            }, delay);
        });

        return on.apply(this, args);
    };
}(this.jQuery || this.Zepto));