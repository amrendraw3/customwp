var disable_modal_centering = false;
/* Reveal js */
(function(e){e(".mmt[data-reveal-id]").live("click",function(t){ 
	if( jQuery(this).data('modal_centering') == 'true' ){
		disable_modal_centering = true;
	}
	/* Check that enable modal */
	if( e(t).parents('.mmt').data('enable_modal') == 'false' ) return;
	t.preventDefault();var n=e(this).attr("data-reveal-id");e("#"+n).reveal(e(this).data())});e.fn.reveal=function(t){var n={animation:"fadeAndPop",animationspeed:300,closeonbackgroundclick:true,dismissmodalclass:"close-reveal-modal"};var t=e.extend({},n,t);return this.each(function(){function a(){s=false}function f(){s=true}var n=e(this),r=parseInt(n.css("top")),i=n.height()+r,s=false,o=e(".reveal-modal-bg");if(o.length==0){o=e('<div class="reveal-modal-bg" />').insertAfter(n)}n.bind("reveal:open",function(){o.unbind("click.modalEvent");e("."+t.dismissmodalclass).unbind("click.modalEvent");if(!s){f();if(t.animation=="fadeAndPop"){n.css({top:e(document).scrollTop()-i,opacity:0,visibility:"visible"});o.fadeIn(t.animationspeed/2);n.delay(t.animationspeed/2).animate({top:e(document).scrollTop()+r+"px",opacity:1},t.animationspeed,a())}if(t.animation=="fade"){n.css({opacity:0,visibility:"visible",top:e(document).scrollTop()+r});o.fadeIn(t.animationspeed/2);n.delay(t.animationspeed/2).animate({opacity:1},t.animationspeed,a())}if(t.animation=="none"){n.css({visibility:"visible",top:e(document).scrollTop()+r});o.css({display:"block"});a()}}n.unbind("reveal:open")});n.bind("reveal:close",function(){if(!s){f();if(t.animation=="fadeAndPop"){o.delay(t.animationspeed).fadeOut(t.animationspeed);n.animate({top:e(document).scrollTop()-i+"px",opacity:0},t.animationspeed/2,function(){n.css({top:r,opacity:1,visibility:"hidden"});a()})}if(t.animation=="fade"){o.delay(t.animationspeed).fadeOut(t.animationspeed);n.animate({opacity:0},t.animationspeed,function(){n.css({opacity:1,visibility:"hidden",top:r});a()})}if(t.animation=="none"){n.css({visibility:"hidden",top:r});o.css({display:"none"})}}n.unbind("reveal:close")});n.trigger("reveal:open");var u=e("."+t.dismissmodalclass).bind("click.modalEvent",function(){n.trigger("reveal:close")});if(t.closeonbackgroundclick){o.css({cursor:"pointer"});o.bind("click.modalEvent",function(){n.trigger("reveal:close")})}e("body").keyup(function(e){if(e.which===27){n.trigger("reveal:close")}})})}})(jQuery);

(function ( $ ) {
	"use strict";

	var mmt_debug = false;

	var waitForFinalEvent = (function () {
	  var timers = {};
	  return function (callback, ms, uniqueId) {
	    if (!uniqueId) {
	      uniqueId = "mmt_uniqueID";
	    }
	    if (timers[uniqueId]) {
	      clearTimeout (timers[uniqueId]);
	    }
	    timers[uniqueId] = setTimeout(callback, ms);
	  };
	})();

	function mmt_center_rows(){
		
		var _width = 0;
		var _total_element_width = 0;
		var _margin_left = 0;

		// Center align the mmt elements
		$('.mmt_container>.mmt_row').each(function(index, element){

			if( $('.mmt_container').data('align') != 'center' )	return;

			_total_element_width = 0;
			_width = $(this).innerWidth();


			$(this).children('.mmt').each(function(index, element){

				_total_element_width = _total_element_width + $(this).outerWidth();
				
			});

			if( _width < _total_element_width || $(".mmt").css('float') != 'left' ){
				_margin_left = "";
			}
			else{
				_margin_left = (_width-_total_element_width)/2;
			}

			$(this).children('.mmt').animate({
				left: _margin_left 
			},300);

		});

	}

	function mmt_center_modal(){

		if( disable_modal_centering ){
			return;
		}
		
		// Centers the modal
		var _window_width = 0;
		var _modal_width = 0;
		var _current_margin_left = 0;
		var _expected_margin_left = 0;

		_modal_width = $(".mmt_container .reveal-modal").outerWidth();
		_window_width = $(window).width();
		_expected_margin_left = (_window_width-_modal_width)/2;
		_current_margin_left = $(".mmt_container .reveal-modal").offset().left;

		$(".mmt_container .reveal-modal").animate({
			left: 	(_expected_margin_left)
		},300);

		// Used for debug only
		if(mmt_debug == true){
			console.log( 'window width:' + _window_width );
			console.log( 'modal width:' + _modal_width );
			console.log( 'current margin left:' + _current_margin_left );
			console.log( 'expected margin left:' + _expected_margin_left );
		}

	}

	$(document).ready(function(){

		var resizing = 0;

		if( $('.mmt_container').data('debug') == true ){
			mmt_debug = true;
		}

		if( $('.mmt_container').length > 0 ){
			mmt_center_rows();
			mmt_center_modal();
			$(window).resize(function(){

				waitForFinalEvent(function(){
			      mmt_center_rows();
			      mmt_center_modal();
			    }, 200, "mmt_unique");
			});
		}

		// Hover over cursor MMT
		$('.mmt').each(function(){
			$(this).css('cursor','pointer');
		});

	});

}(jQuery));