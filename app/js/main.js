jQuery(document).ready(function() {
	

	/************* Main header Fixing ***********/
  var htop = $('.navbar').offset().top - parseFloat($('.navbar').css('marginTop').replace(/auto/, 0));
  $(window).scroll(function (event) {
    var y = $(this).scrollTop() - 3;
    if (y >= htop) {
      $('.navbar').addClass('fixedhead');
    } else {
      $('.navbar').removeClass('fixedhead');
    }
    //$('body').attr('data-offset' ,  $('.banner').height() );
  });

});
