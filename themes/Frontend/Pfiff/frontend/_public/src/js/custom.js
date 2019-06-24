/*--------------- custom banner ---------------*/
$(function () {
    $('.tab_boght_nav').click();
    $('.tab_viewed_nav').click();
});
/*--------------- toggel  ---------------*/
jQuery(function($) { // DOM ready and $ alias in scope

    /**
     * Option dropdowns. Slide toggle
     */
    $(".option-heading").on('click', function() {
        $(this).toggleClass('is-active').next(".option-content").stop().slideToggle(500);
    });
    $(".has-sub-level").on('click', function() {
        $(this).toggleClass('is-active').next(".second--level").stop().slideToggle(500);
    });

});

/*--------------- sldier listing  ---------------*/
//~ $(document).ready(function() {
    //~ $('.owl-carousel').owlCarousel({
        //~ loop: true,
        //~ responsiveClass: true,
        //~ responsive: {
            //~ 0: {
                //~ items: 2,
                //~ nav: true,
                //~ dots: false
            //~ },
            //~ 600: {
                //~ items: 3,
                //~ nav: true,
                //~ dots: false
            //~ },
            //~ 1000: {
                //~ items: 3,
                //~ nav: true,
                //~ loop: false,
                //~ dots: false
            //~ }
        //~ }
    //~ })
//~ });

/*--------------- FAQ accordian detail tab ---------------*/
document.addEventListener("DOMContentLoaded", function(event) {


    var acc = document.getElementsByClassName("accordion");
    var panel = document.getElementsByClassName('panel');

    for (var i = 0; i < acc.length; i++) {
        acc[i].onclick = function() {
            var setClasses = !this.classList.contains('active');
            setClass(acc, 'active', 'remove');
            setClass(panel, 'show', 'remove');

            if (setClasses) {
                this.classList.toggle("active");
                this.nextElementSibling.classList.toggle("show");
            }
        }
    }

    function setClass(els, className, fnName) {
        for (var i = 0; i < els.length; i++) {
            els[i].classList[fnName](className);
        }
    }

});

/* ------- Modal Box */
$(function(){
		$('.manufacturer-img').on('click', function(){
		var src = $(this).prev().find('img').attr('src');
		$('#myModal').find('img').attr('src', src);
		$('#myModal').show();
						});

						$('.close').on('click', function(){
							$('#myModal').hide();
						})
					});

