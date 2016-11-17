// When DOM is fully loaded
jQuery(document).ready(function($) {

	"use strict";


	/* Main Settings
	 ---------------------------------------------------------------------- */

	// Detect Touch Devices
	var isTouch = ( ( 'ontouchstart' in window ) || ( navigator.msMaxTouchPoints > 0 ) );

	if ( isTouch ) {

		$( 'body' ).addClass( 'touch-device' );

	}


	// Global Variables
	var 
		intro_slider = null;


	/* Remove / Update plugins after page loaded
	 ---------------------------------------------------------------------- */
	(function() {

		// OWL
		$( '#ajax-container #intro-slider' ).each( function(){

			var id = $( this ).attr( 'id' );

			if ( id == undefined ) return;

			// Destroy carousel if exists
			if ( $( '#' + id ).data( 'owlCarousel') != undefined ) {
				$( '#' + id ).data( 'owlCarousel' ).destroy();
			}
		});

		if ( $.fn.waypoints ) {
			$.waypoints('refresh');
			$.waypoints( 'destroy' );
		}

		// Isotope
		if ( $.fn.isotope ) {
			if ( $( '.masonry' ).data( 'isotope') ) {
				$( '.masonry' ).isotope( 'destroy' );
			}
			if ( $( '.items' ).data( 'isotope') ) {
				$( '.items' ).isotope( 'destroy' );
			}
		}
		
		
		/* UPDATE Scamp player content and events
		 ---------------------------------------------------------------------- */
		if ( typeof scamp_player !== 'undefined' && scamp_player != null ) {
			scamp_player.update_content();
			scamp_player.update_events( 'body' );
		}

	})();


	/* Autostart Scripts
	 ---------------------------------------------------------------------- */
	function scripts() {



		/* Resize
		 ---------------------------------------------------------------------- */
		(function() {

			var _resize = function(){
				var 
				 	resize_image = $( '.intro-resize, .intro-resize .image, .intro-resize .slide, #portfolio-carousel-wrap' ),
					win_width = $( window ).width(),
					win_height = $( window ).height(),
					resize_image_height = win_height;

				resize_image.css({
					height: resize_image_height+'px'
				});

			}

			// Init resize_image
			_resize();

			$( window ).on( 'resize', _resize );

			TweenMax.fromTo( '.intro-resize', 0.5, {
            	autoAlpha: 0,
            }, {
                autoAlpha: 1,
                ease: Power2.easeOut
            });

		})();


		/* Scroll actions
		 ---------------------------------------------------------------------- */
		(function() {
			
			var 
				header = $( '#header' ),
				page = $( window ),
				intro_el = $( '#ajax-content > .intro' ),
				qs_duration = 0.8, // QuickScroll Duration
				lastScrollTop = 0;


			// Unbind scroll actions
			page.off( 'scroll' );
			page.off( 'mousewheel DOMMouseScroll');

			// Scroll actions
			var scroll_actions = function(e) {

				var st = $(window).scrollTop(),
					wh = $( window ).height(),
					intro_height = intro_el.outerHeight();

				// Show header
				if ( st > lastScrollTop ){
					if ( st > 0 ) {
						header.addClass( 'hide-header' );
					}
				} else {
					if ( st > 0 ) {
						header.addClass( 'show-bg' );
					} else {
			   			header.removeClass( 'show-bg' );
			   		}
			   		header.removeClass( 'hide-header' );
				}
				
				
				// Scroll button
			   	if ( st > ( wh/2 ) ) {
				   	if ( st > lastScrollTop ){
				    	$( '#scroll-button' ).removeClass( 'active' );
				   	} else {
				   		$( '#scroll-button' ).addClass( 'active' );
				   	}
				} else {
					$( '#scroll-button' ).removeClass( 'active' );
				}

			   	lastScrollTop = st;

			};
			page.on( 'scroll', scroll_actions );

			scroll_actions();

			// Quick scroll
			if ( intro_el.hasClass( 'quick-scroll' ) && ! isTouch && $( '#content' ).length ) {

				var last_scroll_pos = 0,
					bottom_offset = 0;
				
				page.on( 'scroll', function(e) {

					var 
						scroll_top = $( window ).scrollTop(), // scroll top
						ih = intro_el.outerHeight(), // intro height
						hh = header.outerHeight();
								
					if ( ih <= 500 ) qs_duration = 0.4;

					if ( scroll_top > last_scroll_pos && scroll_top > 20  && scroll_top < ih-hh-bottom_offset ) {
						
						TweenMax.to( window, qs_duration, { scrollTo:{ y:ih }, ease:Power2.easeOut  } );
						TweenMax.to( intro_el, qs_duration, { alpha: 0, ease:Power2.easeOut  } );
						

					} else if ( scroll_top < last_scroll_pos && scroll_top < ih-hh )  {
						TweenMax.to( window, qs_duration, { scrollTo:{ y:0 }, ease:Power2.easeOut  } );
						TweenMax.to( intro_el, qs_duration, { alpha: 1, ease:Power2.easeOut  } );
						
					} 
			
					last_scroll_pos = scroll_top;
				}, 250 );

				$( '.scroll-anim-button' ).css('cursor', 'pointer');

				$( '.scroll-anim-button' ).on( 'click', function(event) {
					var
						scroll_top = $( window ).scrollTop(), // scroll top
						ih = intro_el.outerHeight(), // intro height
						hh = header.outerHeight();

					TweenMax.to( window, qs_duration, { scrollTo:{ y:ih }, ease:Power2.easeOut  } );
					TweenMax.to( intro_el, qs_duration, { alpha: 0, ease:Power2.easeOut  } );

					event.preventDefault;

				});

				page.on( 'mousewheel DOMMouseScroll', function( event ) {
					var 
						scroll_top = $( window ).scrollTop(), // scroll top
						ih = intro_el.outerHeight(), // intro height
						hh = header.outerHeight();

					    if ( event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0 ) {
					        // scroll up
					        if ( scroll_top < ih ) {
					        	TweenMax.to( window, qs_duration, { scrollTo:{ y:0 }, ease:Power2.easeOut } );
					        	TweenMax.to( intro_el, qs_duration, { alpha: 1, ease:Power2.easeOut  } );
					    	}
					    }
					    else {
					        // scroll down
					        if ( scroll_top < ih-hh-bottom_offset ) {
					        	TweenMax.to( window, qs_duration, { scrollTo:{ y:ih }, ease:Power2.easeOut  } );
					        	TweenMax.to( intro_el, qs_duration, { alpha: 0, ease:Power2.easeOut  } );
					        	
					    	}
					    }
					
				});
			}

						
		})();


		/* Intro ZOOM OUT effect
		 ---------------------------------------------------------------------- */
		(function() {
 
			if ( $( '.intro.intro-image-zoom').length <= 0 ) return
			var introSection = $('.intro.intro-image-zoom'),
				introSectionHeight = introSection.height(),
				scaleSpeed = 0.3,
				opacitySpeed = 1; 
			
			$( '#content' ).css({ 'margin-top' : introSectionHeight });

			var MQ = 960;

			function animateIntro () {
				var scrollPercentage = ( $( window ).scrollTop()/introSectionHeight ).toFixed( 5 ),
					scaleValue = 1 - scrollPercentage*scaleSpeed;
				if( $( window ).scrollTop() < introSectionHeight) {
					var s = $(window).scrollTop();
					introSection.css({
						'top' : (-introSectionHeight+s) + 'px',
					    '-moz-transform': 'scale(' + scaleValue + ') translateZ(0)',
					    '-webkit-transform': 'scale(' + scaleValue + ') translateZ(0)',
						'-ms-transform': 'scale(' + scaleValue + ') translateZ(0)',
						'-o-transform': 'scale(' + scaleValue + ') translateZ(0)',
						'transform': 'scale(' + scaleValue + ') translateZ(0)',
						'opacity': 1 - scrollPercentage*opacitySpeed
					});
				}
			}

			function triggerAnimation(){
				if ( $( window ).width() >= MQ ) {
					introSection.css( { 'position' : 'absolute', 'top' : -introSectionHeight + 'px' } );
					introSectionHeight = introSection.height();
					$( '#content' ).css( { 'margin-top' : introSectionHeight } );
					$( window ).on( 'scroll', animateIntro );
				} else {
					introSection.css( { 'position' : 'relative', 'top': 0 } );
					$( '#content' ).css( { 'margin-top' : 0 } );
					$( window ).off( 'scroll', animateIntro );
				}
			}

			$( window ).on( 'resize', function(){
				triggerAnimation();
			});

			triggerAnimation();
			

		})();


		/* Intro Slider
		 ---------------------------------------------------------------------- */
		(function() {


	 		if ( $( '#intro-slider' ).length <= 0 ) return;

	 		
			$( '.intro .intro-captions' ).css( 'opacity', 1 );

	 		// Remove default styles
	 		if ( $( '.intro.anim-css' ).length ) {
					TweenMax.to( '#intro-slider .overlay, #intro-slider .caption-top, #intro-slider .caption-bottom', 0, { opacity:0, x:0, y:0, scale:1, delay:1, ease:Linear.easeNone } );
				$( '.intro .caption-divider' ).css( 'width', 0 );
			}

	 		var players = {};

			function afterUpdate() {

				var slider = $( this.$elem ),
					that = $('.owl-item:eq('+this.owl.currentItem+')', slider );

				// Zoom
				if ( zoom ) {
					that.find( '.slide-image' ).addClass( 'zoom' );
				}

	  		}
	  		
	  		function afterMove(){
				
				var slider = $( this.$elem ),
					prev = $('.owl-item:eq('+this.owl.prevItem+')', slider ),
					that = $('.owl-item:eq('+this.owl.currentItem+')', slider );

				// Zoom
				if ( zoom ) that.find( '.image' ).addClass( 'zoom' );

				// Animations
				_slider_animation( this.owl.currentItem );
				if ( zoom ) {
					TweenMax.to( '#intro-slider .owl-item:eq('+this.owl.prevItem+') .image', 0, { scale:1, repeat:0, yoyo:false, delay:1, ease:Linear.easeNone } );
				}
				if ( $( '.intro.anim-css' ).length ) {
						$( '#intro-slider .owl-item:eq('+this.owl.prevItem+')  .caption-divider' ).css( 'width', 0 );
						TweenMax.to( '#intro-slider .owl-item:eq('+this.owl.prevItem+') .overlay, #intro-slider .owl-item:eq('+this.owl.prevItem+')  .caption-top, #intro-slider .owl-item:eq('+this.owl.prevItem+')  .caption-bottom', 0, { opacity:0, x:0, y:0, delay:1, scale:1, ease:Linear.easeNone } );
				}

				// Video
				if ( that.find( '.slide' ).hasClass( 'video-slide' ) ) {
					var video_id = that.find( '.image-video' ).attr( 'id' ),
						key = video_id,
						video_yt_id = $( '#' + video_id ).data( 'video-id' );
					
					if ( video_id in players ) {

						players[key] = $( '#' + video_id ).data( 'ytPlayer' ).player;
						players[key].playVideo();
					} else {
						players[key] = video_yt_id = $( '#' + video_id ).data( 'video-id' );
						players[key] = $( '#' + video_id ).YTPlayer({
							fitToBackground: true,
							videoId : video_yt_id
						});
					}
	
				}

				if ( prev.find( '.slide' ).hasClass( 'video-slide' ) ) {
					var 
						video_id = prev.find( '.image-video' ).attr( 'id' ),
						key = video_id;
					if ( $( '#' + video_id ).hasClass( 'loaded' ) ) {
						players[key] = $( '#' + video_id ).data( 'ytPlayer' ).player;
						players[key].pauseVideo();
					}
				}

			}

			// Carousel slider
			var zoom = false,
				intro_slider = $( '#intro-slider' ),
				navigation = intro_slider.data( 'slider-nav' ),
				pagination = intro_slider.data( 'slider-pagination' ),
				speed = intro_slider.data( 'slider-speed' ),
				pause_time = intro_slider.data( 'slider-pause-time' );

				if ( $( '#intro-slider .image-video' ).length ) {
					pause_time = false;
				}

			intro_slider.owlCarousel({
			    navigation : navigation,
			    pagination : pagination,
			    slideSpeed : speed,
			    autoPlay : pause_time,
			   	navigationText: [
			      '<div class="nav-slider nav-slider-prev"><i class="icon icon-chevron-left"></i></div>',
			      '<div class="nav-slider nav-slider-next"><i class="icon icon-chevron-right"></i></div>'
			    ],
			    singleItem : true,
			    afterMove : afterMove,
			    afterUpdate : afterUpdate
	  		});

			// Set startup animations
	  		if ( $( '#intro-slider' ).hasClass( 'zoom' ) ) {
	  			zoom = true;
	  			$( '#intro-slider' ).find( '.owl-item:eq(0) .image' ).addClass( 'zoom' );
	  		}
	  		
	  		_slider_animation(0);

	  		// Video
	  		if ( $( '#intro-slider' ).find( '.owl-item:eq(0)' ).find( '.image-video' ).length ) {
				var video_id = $( '#intro-slider' ).find( '.owl-item:eq(0) .image-video' ).attr( 'id' ),
					key = video_id,
					video_yt_id = $( '#' + video_id ).data( 'video-id' );

				players[key] = $( '#' + video_id ).YTPlayer({
					fitToBackground: true,
					videoId : video_yt_id
				});
				
			}

			// Slider animations
			function _slider_animation(eq) {

				if ( $( '.intro.anim-css' ).length <=0 ) return;

				var d = 1, // delay
					o = 0, // opacity
					subtitle_y = -60;

				// Overlay opacity
				if ( $( '#intro-slider .owl-item:eq('+eq+') .overlay.noise' ).length ) {
					o = 0.04;
				} else if ( $( '#intro-slider .owl-item:eq('+eq+') .overlay.dots' ).length ) {
					o = 1;
				} else {
					o = 0.80
				}

				if ( zoom ) {
					TweenMax.to( '#intro-slider .owl-item:eq('+eq+') .image', 40, { 
						scale:1.4, 
						repeat:-1, 
						yoyo:true, 
           				rotationZ: "0.01deg",
            			transformOrigin: "0 0", 
            			ease:Linear.easeNone }
            		);
				}

				if ( $( '#intro-slider .owl-item:eq('+eq+') .overlay' ).length ) {
					d = 1;
					TweenMax.fromTo( '#intro-slider .owl-item:eq('+eq+') .overlay', 1, {
		                alpha: 0,
			            }, {
			                alpha: o,
			                delay : d,
			                ease: Power2.easeOut
			            });
				}


			  	TweenMax.fromTo( '#intro-slider .owl-item:eq('+eq+') .caption-divider', 1, {
	                width: 0,
	            }, {
	                width: '100%',
	                delay: d+0.6,
	                ease: Power2.easeOut
	            });

	            TweenMax.fromTo( '#intro-slider .owl-item:eq('+eq+') .caption-top', 1, {
			        autoAlpha: 0,
			        y: 30,
			        scale: 0.97
		      	}, {
			        autoAlpha: 1,
			        scale: 1,
			        y: 0,
			        delay: d+0.8,
			        ease: Power4.easeOut
		      	});
				
	            TweenMax.fromTo( '#intro-slider .owl-item:eq('+eq+') .caption-bottom', 1, {
	             	autoAlpha: 0,
			        y: -30,
			        scale: 0.97
		      	}, {
			        autoAlpha: 0.9,
			        scale: 1,
			        y: 0,
			        delay: d+0.8,
			        ease: Power4.easeOut
	            });

	            TweenMax.fromTo( '#intro-slider .owl-item:eq('+eq+') .scroll-anim-button', 1, {
	                autoAlpha: 0,
	                y:-40,
	            }, {
	                autoAlpha: 0.7,
	                y:0,
	                delay: d+0.8,
	                ease: Power2.easeOut
	            });

			}

	  	})();


	  	/* Content Slider
		 ---------------------------------------------------------------------- */
		(function() {

	 		if ( $( '.content-slider' ).length <= 0 ) return;

			$( '.content-slider' ).each( function() {

				// Carousel slider
				var 
					content_slider = $( this ),
					id = '#' + $( this ).attr( 'id' ),
					navigation = content_slider.data( 'slider-nav' ),
					pagination = content_slider.data( 'slider-pagination' ),
					speed = content_slider.data( 'slider-speed' ),
					pause_time = content_slider.data( 'slider-pause-time' );

				$( id ).owlCarousel({
				    navigation : navigation,
				    pagination : pagination,
				    slideSpeed : speed,
				    autoPlay : pause_time,
					   	navigationText: [
					      '<div class="nav-slider nav-slider-prev"><i class="icon icon-chevron-left"></i></div>',
					      '<div class="nav-slider nav-slider-next"><i class="icon icon-chevron-right"></i></div>'
					    ],
			    	autoHeight : true,
				    singleItem : true
		  		});


			});
			
	  	})();


	  	/* Carousel slider
		 ---------------------------------------------------------------------- */
		(function() {
			$( '.carousel-slider' ).each( function(){

				var id = $( this ).attr( 'id' ),
					effect = $( this ).data( 'effect' ),
					nav = $( this ).data( 'nav' ),
					autoplay = $( this ).data( 'autoplay' ),
					pagination = $( this ).data( 'pagination' ),
					items = $( this ).data( 'items' ),
					single_item = true;

				if ( items != undefined && items > 1 ) {
					single_item = false;
				}

				if ( id == undefined ) return;
				
				$( '#' + id ).owlCarousel({
				    navigation : nav,
				    pagination : pagination,
				    navigationText: [
				      '<div class="nav-slider nav-slider-prev"><i class="icon icon-chevron-left"></i></div>',
				      '<div class="nav-slider nav-slider-next"><i class="icon icon-chevron-right"></i></div>'
				    ],
				    singleItem : single_item,
				    items : items,
				    autoPlay : autoplay,
				     //Basic Speeds
				    slideSpeed : 400,
				    paginationSpeed : 800,
				    rewindSpeed : 1000
		  		});

				$( '.owl-link', this ).on( 'click', function( event ){
				    var $this = $( this );
				   
				  });

		  	});
		})();


		/* Parallax
		 ---------------------------------------------------------------------- */
		(function() {

			var images;
			
			function init() {

				images = [].slice.call( $('.parallax') );
				if(!images.length) { return }
				
				$( window ).on( 'scroll', doParallax );
				$( window ).on( 'resize', doParallax );
				doParallax();
			}
			
			function getViewportHeight() {
				var a = document.documentElement.clientHeight, b = window.innerHeight;
				return a < b ? b : a;
			}
			
			function getViewportScroll() {
				if(typeof window.scrollY != 'undefined') {
					return window.scrollY;
				}
				if(typeof pageYOffset != 'undefined') {
					return pageYOffset;
				}
				var doc = document.documentElement;
				doc = doc.clientHeight ? doc : document.body;
				return doc.scrollTop;
			}
			
			function doParallax() {
				var el, elOffset, elHeight,
					offset = getViewportScroll(),
					vHeight = getViewportHeight();
				
				for(var i in images) {
					el = images[i];
					if ( $( el ).css( 'background-image' ) != 'none') {
						elOffset = el.offsetTop;
						elHeight = el.offsetHeight;
						
						if((elOffset > offset + vHeight) || (elOffset + elHeight < offset)) { continue; }
						
						TweenMax.to( el, 0.5, { backgroundPosition:'50% '+Math.round((elOffset - offset)*3/10)+'px', ease:Power2.easeOut } );
					}
				}
			}

			init()
		})();


		/* Intro animations
	 	 ---------------------------------------------------------------------- */
		
		(function() {

			function _intro_animations() {


				if ( $( '.intro.anim-css' ).length <= 0 || $( '.intro-slider-outer' ).length ) return;

				var d = 0.5, // delay
					o = 0, // opacity
					subtitle_y = -60;

				if ( $( '.intro .overlay.noise' ).length ) {
					o = 0.04;
				} else if ( $( '.intro .overlay.dots' ).length ) {
					o = 1;
				} else if ( $( '.intro .overlay.light' ).length ) {
					o = 0.85;
				} else {
					o = 0.80
				}

				if ( $( '.intro .image' ).hasClass( 'zoom' ) ) {
					TweenMax.to( '.intro .image', 40, { 
						scale:1.4, 
						repeat:-1, 
						yoyo:true, 
           				rotationZ: "0.01deg",
            			transformOrigin: "0 0", 
            			ease:Linear.easeNone } 
            		);
				}

				if ( $( '.intro .overlay' ).length ) {
					TweenMax.fromTo( '.intro .overlay', 1, {
		                autoAlpha: 0,
			            }, {
			                autoAlpha: o,
			                delay : d,
			                ease: Power2.easeOut
			            });
				}
				
				$( '.intro .caption-divider' ).css( 'width', 0 );
				$( '.intro .intro-captions' ).css( 'opacity', 1 );
				$( '.intro .profile-image' ).css( 'opacity', 1 );

				TweenMax.fromTo( '.intro .profile-image', 1, {
			        autoAlpha: 0,
			        scale:0.8
		      	}, {
			        autoAlpha: 1,
			        scale: 1,
			        delay: d+0.6,
			        ease: Power2.easeOut
		      	});

			  	TweenMax.fromTo( '.intro .caption-divider', 1, {
	                width: 0,
	            }, {
	                width: '100%',
	                delay: d+0.6,
	                ease: Power2.easeOut
	            });

	            TweenMax.fromTo( '.intro .caption-top', 1, {
			        autoAlpha: 0,
			        y: 30,
			        scale: 0.97
		      	}, {
			        autoAlpha: 1,
			        scale: 1,
			        y: 0,
			        delay: d+0.8,
			        ease: Power4.easeOut
		      	});
				
	            TweenMax.fromTo( '.intro .caption-bottom', 1, {
	             	autoAlpha: 0,
			        y: -30,
			        scale: 0.97
		      	}, {
			        autoAlpha: 0.9,
			        scale: 1,
			        y: 0,
			        delay: d+0.8,
			        ease: Power4.easeOut
	            });

	            TweenMax.fromTo( '.intro .scroll-anim-button', 1, {
	                autoAlpha: 0,
	                y:-40,
	            }, {
	                autoAlpha: 0.7,
	                y:0,
	                delay: d+0.8,
	                ease: Power2.easeOut
	            });

			}

			_intro_animations();

		})();


		/* MASONRY GRID
	 	 ---------------------------------------------------------------------- */
	 	(function() {
			if ( ! $( '.masonry' ).length ) return;

			if ( $( 'body' ).hasClass( 'wp-ajax-loader' ) ) {
	 			$( '.masonry' ).isotope({
					itemSelector : '.masonry-item',
					transitionDuration: 0,
					layoutMode: 'fitRows',
				});
				setTimeout( function(){ $( '.masonry' ).isotope( 'layout' ) }, 3000);
	 		} else {
		 		$( window ).on( 'load', function(){
					$( '.masonry' ).isotope({
						itemSelector : '.masonry-item',
						transitionDuration: 0,
						layoutMode: 'fitRows',
					});
				});
				setTimeout( function(){ $( '.masonry' ).isotope( 'layout' ) }, 3000);
	 		}
	 		$( window ).on( 'resize', function(){
				setTimeout( function(){ $( '.masonry' ).isotope( 'layout' ) }, 1000);
			} );

			if ( ! $( '.masonry.masonry-anim' ).length ) return;
			var $count = 1;
			var _addClass = function(){
				setTimeout( function() {
					var added_item = $( '.masonry.masonry-anim' ).find( '.masonry-item' ).eq($count-1);
					added_item.addClass( 'masonry-item--appear' );
					var added_item_tip = added_item.find('.tip');
					added_item_tip.addClass( 'active-tip' );

					if ( $( '.masonry.masonry-anim' ).find( '.masonry-item' ).length >= $count ) {
						$count++;
						_addClass();
					}
				}, 300);
			}
			
			_addClass();


		})();


		/* WP gallery
	 	 ---------------------------------------------------------------------- */
	 	(function() {
	 		if ( ! $( '.gallery' ).length ) return;

	 		if ( $( 'body' ).hasClass( 'wp-ajax-loader' ) ) {
	 			$( '.gallery' ).isotope({
					itemSelector : '.gallery-item',
				});
				setTimeout( function(){ $( '.gallery' ).isotope( 'layout' ) }, 1000);
	 		} else {
		 		$( window ).on( 'load', function(){
		 			$( '.gallery' ).isotope({
						itemSelector : '.gallery-item'
					});
		 		});
	 		}
			
		})();


		/* Intro Tabs
		 ---------------------------------------------------------------------- */
		(function() {
 
			if ( $( '.intro-tabs-wrap').length <= 0 ) return
			
			var 
				tabs = $( '.intro-tabs-wrap');

			tabs.find( 'a' ).each( function(i) {
				var id = $( this ).attr('data-id');
				if ( $( id ).length ) {
					$( id ).addClass( 'row-intro-tab' );
					if ( i > 0 ) {
						$( id ).addClass( 'hidden' );
					} else {
						$( this ).addClass( 'active' );
						tabs.removeClass( 'intro-tabs-before-init' );
					}
				}

			});
			
			tabs.find( 'a' ).on( 'click', function(e){
				e.preventDefault;

				var id = $( this ).attr('data-id');

				tabs.find( 'a' ).removeClass( 'active' ); 
				$( this ).addClass( 'active' );
				$( '.row-intro-tab' ).addClass( 'hidden' );
				$( id ).removeClass( 'hidden' );
				if ( $.fn.isotope ) {
					setTimeout( function(){ $( '.masonry' ).isotope( 'layout' ) }, 100);
					if ( $( '.gallery' ).length ) {
						setTimeout( function(){ $( '.gallery' ).isotope( 'layout' ) }, 100);
					}
				}

			});
			

		})();


		/* Small Functions
		 ---------------------------------------------------------------------- */
		(function() {

			/* Resonsive videos
		 	 ------------------------- */
			if ( $.fn.ResVid ) {
				$( 'body' ).ResVid();
			}

			/* Anim thumbs
		 	 ------------------------- */
		 	var $count = 1;

			var _addClass = function($container){
				setTimeout( function() {
					$container.find( '.thumb-anim' ).eq($count-1).addClass( 'thumb-anim--appear' );
					if ( $container.find( '.thumb-anim' ).length >= $count ) {

						$count++;

						_addClass();
					}
				}, 200);

			}
			$( '.thumb-anim' ).addClass( 'thumb-anim--appear' );

			//_addClass();


			/* Youtube Video
		 	 ------------------------- */
			if ( ! isTouch ) {

			 	if ( $( '#video-bg' ).length ) {
			 		
			 		var 
			 			video_id = $( '#video-bg' ).data( 'video-id' ),
			 			mute = $( '#video-bg' ).data( 'mute' );
			 			console.log(mute)

					$( '#video-bg' ).YTPlayer({
						fitToBackground: true,
						videoId : video_id,
						mute : mute,
						pauseOnScroll : false
					});
					
				}	
			}  else {
				$( '#video-bg' ).removeClass( 'desktop-video' );
			}

			/* Countdown
		 	 ------------------------- */
			if ( $.fn.countdown ) {
				$( '.countdown' ).each( function(e) {
					var date = $( this ).data( 'event-date' );

			        $( this ).countdown( date, function( event ) {
			            var $this = $( this );

			            switch( event.type ) {
			                case "seconds":
			                case "minutes":
			                case "hours":
			                case "days":
			                case "weeks":
			                case "daysLeft":
			                    $this.find( '.' + event.type ).html( event.value );
			                    break;

			                case "finished":
			              
			                    break;
			            }
			        });
			    });
		    }

		})();


		/* Google Maps
 	 	 ---------------------------------------------------------------------- */
		(function() {
			if ( $.fn.gmap3 ) {

				var styles = [{
				      featureType: "administrative",
				      elementType: "geometry",
				      stylers: [{
				        color: "#a7a7a7"
				      }]
				    }, {
				      featureType: "administrative",
				      elementType: "labels.text.fill",
				      stylers: [{
				        visibility: "on"
				      }, {
				        color: "#737373"
				      }]
				    }, {
				      featureType: "landscape",
				      elementType: "geometry.fill",
				      stylers: [{
				        visibility: "on"
				      }, {
				        color: "#efefef"
				      }]
				    }, {
				      featureType: "poi",
				      elementType: "geometry.fill",
				      stylers: [{
				        visibility: "on"
				      }, {
				        color: "#dadada"
				      }]
				    }, {
				      featureType: "poi",
				      elementType: "labels",
				      stylers: [{
				        visibility: "off"
				      }]
				    }, {
				      featureType: "poi",
				      elementType: "labels.icon",
				      stylers: [{
				        visibility: "off"
				      }]
				    }, {
				      featureType: "road",
				      elementType: "labels.text.fill",
				      stylers: [{
				        color: "#696969"
				      }]
				    }, {
				      featureType: "road",
				      elementType: "labels.icon",
				      stylers: [{
				        visibility: "off"
				      }]
				    }, {
				      featureType: "road.highway",
				      elementType: "geometry.fill",
				      stylers: [{
				        color: "#ffffff"
				      }]
				    }, {
				      featureType: "road.highway",
				      elementType: "geometry.stroke",
				      stylers: [{
				        visibility: "on"
				      }, {
				        color: "#b3b3b3"
				      }]
				    }, {
				      featureType: "road.arterial",
				      elementType: "geometry.fill",
				      stylers: [{
				        color: "#ffffff"
				      }]
				    }, {
				      featureType: "road.arterial",
				      elementType: "geometry.stroke",
				      stylers: [{
				        color: "#d6d6d6"
				      }]
				    }, {
				      featureType: "road.local",
				      elementType: "geometry.fill",
				      stylers: [{
				        visibility: "on"
				      }, {
				        color: "#ffffff"
				      }, {
				        weight: 1.8
				      }]
				    }, {
				      featureType: "road.local",
				      elementType: "geometry.stroke",
				      stylers: [{
				        color: "#d7d7d7"
				      }]
				    }, {
				      featureType: "transit",
				      elementType: "all",
				      stylers: [{
				        visibility: "on"
				      }]
				    }, {
				      featureType: "water",
				      elementType: "geometry.fill",
				      stylers: [{
				        color: "#d3d3d3"
				      }]
				    }]

				$( '.gmap' ).each( function(){

					// Get Marker
					var marker = '';
					if ( theme_vars.map_marker !== '' ) {
						marker = theme_vars.map_marker;
					} else {
						marker = theme_vars.theme_uri + '/images/map-marker.png';
					}

					var 
						gmap = $( this ),
						address = gmap.data( 'address' ), // Google map address e.g 'Level 13, 2 Elizabeth St, Melbourne Victoria 3000 Australia'
						zoom = gmap.data( 'zoom' ), // Map zoom value. Default: 16
						zoom_control, // Use map zoom. Default: true
						scrollwheel; // Enable mouse scroll whell for map zooming: Default: false

					if ( gmap.data( 'zoom_control' ) == 'true' ) {
						zoom_control = true;
					} else {
						zoom_control = false;
					}

					if ( gmap.data( 'scrollwheel' ) == 'true' ) {
						scrollwheel = true;
					} else {
						scrollwheel = false;
					}

					gmap.gmap3({
						address: address,
						zoom: zoom,
						zoomControl: zoom_control, // Use map zoom. Default: true
						scrollwheel: scrollwheel, // Enable mouse scroll whell for map zooming: Default: false
						mapTypeId : google.maps.MapTypeId.ROADMAP,
						mapTypeControlOptions: {
				          mapTypeIds: [google.maps.MapTypeId.ROADMAP, "style1"]
				        }
					}).marker({
						address: address,
				        icon: marker
				    });

				});
			}
		})();

	}; // end scripts
	scripts();


	/* Magnific popup
 	 ---------------------------------------------------------------------- */
	(function() {
	 
	 	// Image
		$( '.imagebox' ).magnificPopup( { type:'image' } );
		$( '.vclightbox .vc_figure a' ).magnificPopup( { type:'image' } );

		$( '.vclightbox-iframe .vc_figure a' ).magnificPopup( { type:'iframe' } );

		// WP Gallery
		$( '.gallery' ).each(function() {

			var gallery = $( this ),
				id = $( this ).attr( 'id' ),
				attachment_id = false;
			if ( $( 'a[href*="attachment_id"]', gallery ).length ) {
				return false;
			}
			$( 'a[href*="uploads"]', gallery ).each( function(){
				$( this ).attr( 'data-group', id );
				$( this ).addClass( 'thumb' );
				if ( $( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).length ) {
					var caption = $( this ).parents( '.gallery-item' ).find( '.gallery-caption' ).text();
					$( this ).attr( 'title', caption );
				}	

			});

			$( this ).magnificPopup({
				delegate: 'a', 
		        type: 'image',
		        fixedBgPos: true,
		        gallery: {
		          enabled:true
		        }
		    });

		});

		// Theme Gallery
		$( '.gallery-images-grid, .gallery-shortcode-grid, .gallery-shortcode-images-grid' ).magnificPopup({
			delegate: 'a.g-item', 
	        type: 'image',
	        image: {
				verticalFit: true,
				titleSrc: function(item) {
	        
		        var caption = item.el.attr('title');
		        
		        var pinItURL = "http://pinterest.com/pin/create/button/";
		        
		        // Refer to http://developers.pinterest.com/pin_it/
		        pinItURL += '?url=' + 'http://dimsemenov.com/plugins/magnific-popup/';
		        pinItURL += '&media=' + item.el.attr('href');
		        pinItURL += '&description=' + caption;

		        return '<a class="pin-it" href="'+pinItURL+'" target="_blank" data-pin-do="buttonPin" data-pin-config="none" data-pin-color="white"><img src="http://assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_20.png" /></a>' + caption;
				}
			},
			callbacks: {
			    elementParse: function( item ) {

					if ( item.el.hasClass( 'iframe-link' ) ) {
						item.type = 'iframe';
					} else {
						item.type = 'image';
					}

			    }
			},
	        gallery: {
	          enabled:true
	        }
	    });


	})();

});