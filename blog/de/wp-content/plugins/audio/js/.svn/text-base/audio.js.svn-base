/*globals $, jQuery, window, document, Base64 */

var AudioPlayer = (function ($) {
	var instance = 1;
	
	function playsMP3() {
		var a = document.createElement('audio'); 
		return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
	}
	
	function playsOgg() {
		var a = document.createElement('audio'); 
		return !!(a.canPlayType && a.canPlayType('audio/ogg; codecs="vorbis"').replace(/no/, ''));	
	}	
	
	function maybe_decode(file) {
		var fileName, path, parts = [];
	
		if (file.indexOf('.mp3') === -1 || file.indexOf('.ogg') === -1) {
			if (file.indexOf('/') > -1) {
				parts = file.split('/');
				fileName = Base64.decode(parts[parts.length - 1]);
				parts.pop();
				parts.push(fileName);
				file = parts.join('/');			
			} else {
				file = Base64.decode(file);
			}
		}
		
		if (file.indexOf('http://') === -1) {
			file = 'http://' + window.location.host + decodeURIComponent(file);
		}
		
		return file;
	}	
	
	function createInstance(indx) {
		return ['<div id="jquery_jplayer_', indx, '" class="jp-player"></div>',
		'<div class="jp-playlist-player">',
			'<div class="jp-interface" id="jp_interface_', indx, '">', 
				'<div class="now-playing"></div>',
				'<ul class="jp-controls">', 
					'<li><a class="jp-previous" tabindex="1"></a></li>', 
					'<li><a class="jp-play jp-video-play" tabindex="1"></a></li>', 
					'<li><a class="jp-stop" tabindex="1"></a></li>', 					
					'<li><a class="jp-pause" tabindex="1"></a></li>', 
					'<li><a class="jp-next" tabindex="1"></a></li>',					
				'</ul>', 
				'<div class="jp-progress">', 
					'<div class="jp-seek-bar">', 
						'<div class="jp-play-bar"><span></span></div>', 
					'</div>', 
				'</div>', 
				'<div class="jp-volume">',
					'<a class="jp-mute" tabindex="1"></a>', 
					'<a class="jp-unmute" tabindex="1"></a>', 					
					'<a class="jp-volume-bar" tabindex="1"></a>',
					'<a class="jp-volume-bar-value" tabindex="1"></a>',		
				'</div>',			
				'<div class="jp-play-time-all">',
					'<div class="jp-current-time">0:00</div> / ', 
					'<div class="jp-duration">0:00</div>',
				'</div>', 
			'</div>', 
		'</div>'].join(''); 		
	}
	
	return function (wrapper) {
		
		var elem = $(wrapper), player, thisInstance = instance, markup,
		
			songs, oggs, matches, doOgg = false,
			bNext, bPrev, bPlay, bPause, 
			
			playItem = 0, playlist = [], oggFiles = 0,
			nowPlaying, AUTOPLAY = false;			
	
		function playlistInit() {
			if (AUTOPLAY) {
				playlistChange(playItem);
			} else {
				playlistConfig(playItem);
			}
		}
	 
		function playlistConfig(index) {	
			var track = playlist[index], meta;	
			
			meta = ['<span>&#8220;', track.song, '&#8221;</span>',
			'' !== track.album ? (' from <em>' + track.album + '</em> ') : '', 
			'by ', track.artist].join('');
			nowPlaying.html(meta);	
	
			playItem = index;
			
			if (doOgg) {
				player.jPlayer('setMedia', {
					oga: playlist[playItem].source
				});		
			} else {
				player.jPlayer('setMedia', {
					mp3: playlist[playItem].source
				});		
			}
		}
	 
		function playlistChange(index) {
			playlistConfig(index);
			player.jPlayer('play');
		}
	 
		function playlistNext() {
			var index = (playItem + 1 < playlist.length) ? playItem + 1 : 0;
			playlistChange(index);
		}
	 
		function playlistPrev() {
			var index = (playItem - 1 >= 0) ? playItem - 1 : playlist.length - 1;
			playlistChange(index);
		}
		
		function doComplete() {
			playlistNext();	
		}
	
		function doPrev() {
			playlistPrev();
			$(this).blur();
			return false;	
		}
		
		function doNext() {
			playlistNext();
			$(this).blur();
			return false;	
		} 
		
		function doPlay() {
		
		}
	
		songs = elem.find('.haudio');
		oggs = elem.find('a[type="audio/ogg"]');
		matches = songs.length === oggs.length;
		doOgg = matches && playsOgg();
		
		songs.each(function () {
			var elem = $(this), audioFile, mp3, ogg;
			
			ogg = elem.find('a[type="audio/ogg"]');			
			mp3 = elem.find('a[type="audio/mpeg"]');
			
			if (playsMP3()) {
				audioFile = mp3.attr('href');
			} else if (doOgg) {
				audioFile = ogg.attr('href');		
			} 
			
			if (!audioFile) {
				audioFile = mp3.attr('href');			
			}
			
			playlist.push({
				song : elem.find('.fn').eq(0).text(),
				album: elem.find('.album').text(),
				artist: elem.find('.org').text(),
				source: maybe_decode(audioFile)
			});
			
			elem.click(function () {
				playlistChange(songs.index(this));
			});
		});			
		
		markup = createInstance(instance);

		elem.prepend($(markup));
		
		nowPlaying = elem.find('.now-playing');

		bNext = elem.find('.jp-next');
		bPrev = elem.find('.jp-previous');
		bPlay = elem.find('.jp-play');
		bPause = elem.find('.jp-pause');		
	
		if (!player) {
			player = $('#jquery_jplayer_' + instance);
		
			player			
				.jPlayer({
					swfPath: 'http://' + window.location.host + '/blog/wp-content/plugins/audio/js/',
					preload: 'none',
					ready: function () {
						playlistInit();										
					},
					errorAlerts: true,
					warningAlerts: true,
					nativeSupport: true,
					oggSupport: doOgg,
					supplied : (doOgg ? 'oga' : 'mp3'),	
					cssSelectorAncestor: '#jp_interface_' + instance					
				})		
				.bind($.jPlayer.event.play, function () {
					$(this).jPlayer('pauseOthers');
				})
				.jPlayer('onSoundComplete', doComplete);						
		}
	
		bPrev.click(doPrev);
		bNext.click(doNext);
		bPlay.click(doPlay);		
		
		instance += 1;
		
		return {
		
		};
	};
}(jQuery));


(function ($) {
	$(document).ready(function () {
		$('.audio-playlist').each(function () {
			return new AudioPlayer(this);
		});
	});
}(jQuery));