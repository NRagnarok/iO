jQuery(function($) {'use strict',
	
	//Countdown js
	 $("#countdown").countdown({
			date: tempsEvent,
			format: "on"
		},
		
		function() {
			// callback function
		});
	
	// Carousel Auto Slide Off
	$('#event-carousel, #sponsor-carousel ').carousel({
		interval: 3000,
		cycle: true
	});


	// Contact form validation
	var form = $('.contact-form');
	form.submit(function () {'use strict',
		$this = $(this);
		$.post($(this).attr('action'), function(data) {
			$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();
		},'json');
		return false;
	});

	$('.main-nav ul').onePageNav({
		currentClass: 'active',
	    changeHash: false,
	    scrollSpeed: 900,
	    scrollOffset: 0,
	    scrollThreshold: 0.3,
	    filter: ':not(.no-scroll)'
	});

});