(function( $, window, document, undefined ) {

	$('#doc-links a').bind('click', function(e) {

		e.preventDefault();
		var parts = ($(this).attr("href")).split("#");
		var target = '#' + parts[1];

		var moveto = $(target).length ? $(target).offset().top : 0;

		$('html, body').stop().animate(
			{ 
				scrollTop: moveto - 42
			}, 
			250,
			function() {
				location.hash = target;
			}
		);

		return false;

	});

})( jQuery, window, document );