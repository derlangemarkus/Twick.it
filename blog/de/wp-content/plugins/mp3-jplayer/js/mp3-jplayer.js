<!--
// MP3-jPlayer 1.4.1
// www.sjward.org

var foxcurrentstate = "open";
var foxtogglediv = "playlist-wrap";
var foxtogglebutton = "playlist-toggle";
var foxtogglecount = 0;

function toggleplaylist(){
					if (foxcurrentstate == "open") {
						jQuery("#" + foxtogglediv).fadeOut(300);
						jQuery("#" + foxtogglebutton).empty();
						if (foxtogglecount == 1){
							jQuery("#" + foxtogglebutton).append('SHOW PLAYLIST');
							foxtogglecount = 0;
						}
						else {
							jQuery("#" + foxtogglebutton).append('SHOW');
						}
						foxcurrentstate = "closed";
						return;
					}
					if (foxcurrentstate == "closed") {
						jQuery("#" + foxtogglediv).fadeIn("slow");
						jQuery("#" + foxtogglebutton).empty();
						jQuery("#" + foxtogglebutton).append('HIDE');
						foxcurrentstate = "open"
						return;
					}			
}

jQuery(document).ready(function(){

	if ( typeof foxPlayList == "undefined" ) {
		return;
	}
	if (document.images) {	pic1= new Image(138,32); pic1.src=foxpathtoimages+"buttons2.png";				
							pic2= new Image(138,32); pic2.src=foxpathtoimages+"buttons2H.png";				  
							pic3= new Image(12,13); pic3.src=foxpathtoimages+"pos-handle.gif";
							pic4= new Image(12,13); pic4.src=foxpathtoimages+"pos-handleH.gif";
							pic5= new Image(12,13); pic5.src=foxpathtoimages+"pos-handle3.gif";
							pic6= new Image(12,13); pic6.src=foxpathtoimages+"pos-handle3H.gif";
							pic7= new Image(12,13); pic7.src=foxpathtoimages+"vol-handle2.gif";
							pic8= new Image(12,13); pic8.src=foxpathtoimages+"vol-handleH.gif";
	}
	
	var playItem = 0;
	var global_lp = 0;
	var jpPlayTime = jQuery("#jplayer_play_time");
	var jpTotalTime = jQuery("#jplayer_total_time");
	
	jQuery("#jquery_jplayer").jPlayer({
			ready: function() {
				displayPlayList();
				playListInit(foxAutoPlay);
			},
			oggSupport: false,
			volume: foxInitialVolume,
			swfPath: foxpathtoswf
	})
	.jPlayer("onProgressChange", function(loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime) {
			var lpInt = parseInt(loadPercent);
			var ppaInt = parseInt(playedPercentAbsolute);
			global_lp = lpInt;
			jQuery('#loaderBar').progressbar('option', 'value', lpInt);
			if(jQuery("#jquery_jplayer").jPlayer("getData", "diag.isPlaying")){
					if (playedTime==0 && lpInt==0){
							jQuery("#status").empty();
							jQuery("#status").append('<span class="mp3-finding">Connecting</span>');
							jQuery("#downloadmp3-button").removeClass("whilelinks");
							jQuery("#downloadmp3-button").addClass("betweenlinks");
							jQuery("div.jp-total-time").hide();
					}
					if (playedTime==0 && lpInt>0){
							jQuery("#status").empty();
							jQuery("#status").append('<span class="mp3-loading">Buffering</span>');
							jQuery("#downloadmp3-button").removeClass("betweenlinks");
							jQuery("#downloadmp3-button").addClass("whilelinks");
							jQuery("div.jp-total-time").show();
					}
					else if (playedTime>0){
							jQuery("#status").empty();
							jQuery("#status").append('Playing');
							jQuery("#downloadmp3-button").removeClass("betweenlinks");
							jQuery("#downloadmp3-button").addClass("whilelinks");
							jQuery("div.jp-total-time").show();
					}
			}
			else {
					
					if (playedTime>0){
							jQuery("#status").empty();
							jQuery("#status").append('Paused');
							jQuery("#downloadmp3-button").removeClass("betweenlinks");
							jQuery("#downloadmp3-button").addClass("whilelinks");
							jQuery("div.jp-total-time").show();
					}
					else if (playedTime==0){
							if(lpInt>0){
									jQuery("#status").empty();
									jQuery("#status").append('Stopped');
									jQuery("#downloadmp3-button").removeClass("betweenlinks");
									jQuery("#downloadmp3-button").addClass("whilelinks");
									jQuery("div.jp-total-time").show();
							}
							else {
									jQuery("#status").empty();
									jQuery("#status").append('Ready');
							}
					}
			}
			jQuery('#sliderPlayback').slider('option', 'value', ppaInt);
			jpPlayTime.text(jQuery.jPlayer.convertTime(playedTime));
			jpTotalTime.text(jQuery.jPlayer.convertTime(totalTime));
	})
	.jPlayer("onSoundComplete", function() {
			if ( foxPlaylistRepeat == "true" ) {
				playListNext();
			}
			else {
				if ( playItem+1 != foxPlayList.length ) {
					playListNext();
				}
				else {
					playListConfig(0);
				}
			}	
	});	
	jQuery("#player_progress_ctrl_bar a").live( "click", function() {
			jQuery("#jquery_jplayer").jPlayer("playHead", this.id.substring(3)*(100.0/global_lp));
			return false;
	});
	jQuery('#sliderPlayback').slider({
			max: 100,
			range: 'min',
			animate: true,
			slide: function(event, ui) {
				jQuery("#jquery_jplayer").jPlayer("playHead", ui.value*(100.0/global_lp));
			}
	});
	jQuery('#sliderVolume').slider({
			value : foxInitialVolume,
			max: 100,
			range: 'min',
			animate: true,
	
			slide: function(event, ui) {
				jQuery("#jquery_jplayer").jPlayer("volume", ui.value);
			}
	});
	jQuery('#loaderBar').progressbar();
	jQuery('#dialog_link, ul#icons li').hover(
			function() { jQuery(this).addClass('ui-state-hover'); },
			function() { jQuery(this).removeClass('ui-state-hover'); }
	);
	jQuery("#jplayer_previous").click( function() {
			playListPrev();
			jQuery(this).blur();
			return false;
	});
	jQuery("#jplayer_next").click( function() {
			playListNext();
			jQuery(this).blur();
			return false;
	});
	function displayPlayList() {
			jQuery("#jplayer_playlist ul").empty();
			for (i=0; i < foxPlayList.length; i++) {
				var listItem = (i == foxPlayList.length-1) ? "<li class='jplayer_playlist_item_last'>" : "<li>";
				listItem += "<a href='#' id='jplayer_playlist_item_"+i+"' tabindex='1'>"+ foxPlayList[i].name +"</a></li>";
				jQuery("#jplayer_playlist ul").append(listItem);
				jQuery("#jplayer_playlist_item_"+i).data( "index", i ).click( function() {
					var index = jQuery(this).data("index");
					if (playItem != index) {
						playListChange( index );
					} else {
						jQuery("#jquery_jplayer").jPlayer("play");
					}
					jQuery(this).blur();
					return false;
				});
			}
	}
	function playListInit(autoplay) {
			if(autoplay) {
				playListChange( playItem );
			} else {
				playListConfig( playItem );
			}
	}
	function playListConfig( index ) {
			jQuery("#jplayer_playlist_item_"+playItem).removeClass("jplayer_playlist_current").parent().removeClass("jplayer_playlist_current");
			jQuery("#jplayer_playlist_item_"+index).addClass("jplayer_playlist_current").parent().addClass("jplayer_playlist_current");
			playItem = index;
			jQuery("#jquery_jplayer").jPlayer("setFile", foxPlayList[playItem].mp3, foxPlayList[playItem].ogg);
			jQuery("#player-track-title").empty();
			jQuery("#player-artist").empty();
			jQuery("#player-track-title").append(foxPlayList[playItem].name);
			jQuery("#player-artist").append(foxPlayList[playItem].artist);
			// download mp3 link
			jQuery("#downloadmp3-button").empty();
			jQuery("#downloadmp3-button").append("<a href=\"" + foxPlayList[playItem].mp3 + "\">DOWNLOAD MP3</a>");
	}
	function playListChange( index ) {
			playListConfig( index );
			jQuery("#jquery_jplayer").jPlayer("play");
	}
	function playListNext() {
			var index = (playItem+1 < foxPlayList.length) ? playItem+1 : 0;
			playListChange( index );
	}
	function playListPrev() {
			var index = (playItem-1 >= 0) ? playItem-1 : foxPlayList.length-1;
			playListChange( index );
	}
	if (foxShowPlaylist == "false"){
		foxtogglecount = 1;
		toggleplaylist();
	}
});
//-->