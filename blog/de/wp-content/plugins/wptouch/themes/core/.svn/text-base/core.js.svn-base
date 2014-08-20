/*
 * WPtouch 1.9.x -The WPtouch Core JS File
 */

/////-- Let's setup our namspace in jQuery -- /////
$wptouch = jQuery.noConflict();

if ( (navigator.platform == 'iPhone' || navigator.platform == 'iPod') && typeof orientation != 'undefined' ) { 
	var touchStartOrClick = 'touchstart'; 
} else {
	var touchStartOrClick = 'click'; 
};

/////-- Get out of frames! -- /////
if (top.location!= self.location) {top.location = self.location.href}

/////// -- New function fadeToggle() -- /////
$wptouch.fn.wptouchFadeToggle = function(speed, easing, callback) { 
	return this.animate({opacity: 'toggle'}, speed, easing, callback); 
};

/////-- Switch Magic -- /////
function wptouch_switch_confirmation() {
if (document.cookie && document.cookie.indexOf("wptouch_switch_cookie") > -1) {
// just switch
	$wptouch("a#switch-link").toggleClass("offimg");
	setTimeout('switch_delayer()', 1250); 
} else {
// ask first
	var answer = confirm("Switch to regular theme?");
		if (answer){
			$wptouch("a#switch-link").toggleClass("offimg");
			setTimeout('switch_delayer()', 1250); 
		}
	}
}

/////-- Prowl Results -- /////
if ( $wptouch('#prowl-success').length ) {
	setTimeout(function() { $wptouch('#prowl-success').fadeOut(350); }, 5250);
}
if ( $wptouch('#prowl-fail').length ) {
	setTimeout(function() { $wptouch('#prowl-fail').fadeOut(350); }, 5250);
}

/////// -- jQuery Tabs -- ///////
$wptouch(function() {
    var tabContainers = $wptouch('#menu-head > ul');   
    $wptouch('#tabnav a').bind(touchStartOrClick, function () {
        tabContainers.hide().filter(this.hash).show();
    $wptouch('#tabnav a').removeClass('selected');
    $wptouch(this).addClass('selected');
        return false;
    }).filter(':first').trigger(touchStartOrClick);
});

/////-- Ajax comments -- /////
function bnc_showhide_coms_toggle() {
	$wptouch('#commentlist').wptouchFadeToggle(350);
	$wptouch("img#com-arrow").toggleClass("com-arrow-down");
	$wptouch("h3#com-head").toggleClass("comhead-open");
}
	
function doWPtouchReady() {

/////-- Tweak jQuery Timer -- /////
	$wptouch.timerId = setInterval(function(){
		var timers = $wptouch.timers;
		for (var i = 0; i < timers.length; i++) {
			if (!timers[i]()) {
				timers.splice(i--, 1);
			}
		}
		if (!timers.length) {
			clearInterval($wptouch.timerId);
			$wptouch.timerId = null;
		} 
	}, 83);
	
$wptouch( 'a#switch-link' ).bind( touchStartOrClick, function(){
	wptouch_switch_confirmation();
	return false;
});
	
/////-- Menu Toggle -- /////
	$wptouch('#headerbar-menu a').bind( touchStartOrClick, function( e ){
		$wptouch('#wptouch-menu').wptouchFadeToggle(350);
		$wptouch("#headerbar-menu a").toggleClass("open");
	});

/////-- Search Toggle -- /////
	$wptouch('a#searchopen, #wptouch-search-inner a').bind( touchStartOrClick, function( e ){	
		$wptouch('#wptouch-search').wptouchFadeToggle(350);
	});
	
/////-- Prowl Toggle -- /////
	$wptouch('a#prowlopen').bind( touchStartOrClick, function( e ){	
		$wptouch('#prowl-message').wptouchFadeToggle(350);
	});
	
/////-- WordTwit Toggle -- /////
	$wptouch('a#wordtwitopen').bind( touchStartOrClick, function( e ){	
		$wptouch('#wptouch-wordtwit').wptouchFadeToggle(350);
	});

/////-- Gigpress Toggle -- /////
	$wptouch('a#gigpressopen').bind( touchStartOrClick, function( e ){	
		$wptouch('#wptouch-gigpress').wptouchFadeToggle(350);
	});

/////-- Login Toggle -- /////
	$wptouch('a#loginopen, #wptouch-login-inner a').bind( touchStartOrClick, function( e ){	
		$wptouch('#wptouch-login').wptouchFadeToggle(350);
	});
	
/////// -- Single Post Page Bookmark Toggle -- /////
$wptouch( 'a#obook' ).bind( touchStartOrClick, function() {
	$wptouch('#bookmark-box').wptouchFadeToggle(350);
});

/////-- Try to make imgs and captions nicer in posts -- /////
		$wptouch( '.singlentry img, .singlentry .wp-caption' ).each( function() {
			if ( $wptouch( this ).width() <= 250 ) {
				$wptouch( this ).addClass( 'aligncenter' );
			}
		});
	
/////-- Filter FollowMe Plugin -- /////
	if ( $wptouch( '#FollowMeTabLeftSm' ).length ) {
		$wptouch( '#FollowMeTabLeftSm' ).remove();
	}
	
} // End document ready

$wptouch( document ).ready( function() { doWPtouchReady(); } );