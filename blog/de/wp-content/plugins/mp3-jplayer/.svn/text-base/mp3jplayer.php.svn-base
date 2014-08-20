<?php  /* 
Plugin Name: MP3-jPlayer
Plugin URI: http://sjward.org/jplayer-for-wordpress
Description: A flexible MP3 player with a playlist that can be added to your content or sidebar. 
Version: 1.4.1
Author: Simon Ward
Author URI: http://www.sjward.org
License: GPL2
  
		Copyright 2011  Simon Ward  (email: sinomward@yahoo.co.uk)
	
		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License, version 2, as 
		published by the Free Software Foundation.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
		*/

if ( !class_exists("mp3Fox") )
{
	class mp3Fox
	{
		// ------------------ //
		var $version_of_plugin = "1.4.1"; // Update me! //
		var $option_count = 22;
		// ------------------ //
		
		var $iscompat = false;
		var $playerHasBeenSet = "false";
		var $customFieldsGrabbed = "false";
		var $countPlaylist = 0;
		var $tagflag = "false";
		var $scriptsflag = "false";
		var $postMetaKeys = array();
		var $postMetaValues = array();
		var $IDflag_inMeta = "false";
		var $feedKeys = array();
		var $feedValues = array();
		var $listDisplayMode = "";
		var $stylesheet = "";
		var $mp3LibraryWP = array();
		var $mp3LibraryI = array();
		var $PlayerPlaylist = array( 'artists' => array(), 'titles' => array(), 'files' => array(), 'order' => array(), 'count' => 0 );
		var $idfirstFound = "";
		var $adminOptionsName = "mp3FoxAdminOptions";
		var $theSettings = array();
		// debug //
		var $playerSetMethod = "*not attempted*";
		var $putTag_runCount = 0;
		var $shortcode_runCount = 0;
		var $defaultAdd_runCount = 0;
		var $widget_runcount = 0;
		var $playerAddedOnRun = 0;
		var $debugCount = "0";
		var $scriptsForced = "false";
		var $activeWidgets = array();
	
		
   /**
	* 	Handles auto/forced SCRIPT ADDITION.
	*	singular pages - scripts are added if there's tracks in custom fields, or if required by widget, or if forced.
	*	index page - scripts are added if 'show player on index' option is ticked.
	*	called by wp_head() hook
	*/
		function check_if_scripts_needed() {
			
			$this->make_compatible(); // make sure all plugin options are available //
			if ( ($this->scriptsflag == "true" && $this->theSettings['disable_template_tag'] == "false") || $this->theSettings['force_scripts_from_admin'] == "true" ) {
				if ( $this->stylesheet == "" ) {
					$this->stylesheet = $this->theSettings['player_theme'];
				}
				$this->add_Scripts( $this->stylesheet );
				$this->scriptsForced = "true";
				if (is_singular() ) {
					$this->TT_grab_Custom_Meta();
				}
				return;
			}
			if ( (is_home() || is_archive()) && $this->theSettings['player_onblog'] == "true" ) {
				$this->add_Scripts( $this->theSettings['player_theme'] );
			}
			if ( is_singular() ) {
				if ( $this->TT_grab_Custom_Meta() > 0 || $this->widget_needs_scripts() ) { // check meta before widget scripts! //
					$this->add_Scripts( $this->theSettings['player_theme'] );
				}
			}
			return;
		}
		
	
   /**
	* 	Handles DEFAULT player placement via CONTENT.
	*	If on the posts index then meta key matches are run on each loop. 
	*	If singular then picking up any tracks found from meta key match run from header 
	*	Called by the_content() hook
	*/
		function add_player($content='') {
			
			$this->defaultAdd_runCount++;
			if ($this->playerHasBeenSet == "true") {
				return $content;
			}
			if ( empty($this->idfirstFound) && (is_home() || is_archive()) && $this->theSettings['player_onblog'] == "true" ) { // Store id of 1st post with tracks for widget/tag to use when on non-singular pages //
				if ( $this->TT_grab_Custom_Meta() > 0 ) { 
					global $post; 
					$this->idfirstFound = $post->ID; 
				}
			}
			if ( $this->tagflag == "true" && $this->theSettings['disable_template_tag'] == "false" ) {
				return $content;
			}
			if ( is_home() && $this->theSettings['player_onblog'] == "true" ) { // Check meta now (on each loop) //
				if ( $this->TT_grab_Custom_Meta() > 0 ) {
					$customvalues = $this->postMetaValues;
					$customkeys = $this->postMetaKeys;
				} 
				else {
					return $content;
				}
			}
			else if ( is_singular() && $this->customFieldsGrabbed == "true" ) { // Try grab the meta from earlier //
				$customvalues = $this->postMetaValues;
				$customkeys = $this->postMetaKeys;
			}
			else {
				return $content;
			}
			
			// build playlist //
			$thePlayList = $this->generate_playlist( $customkeys, $customvalues, 1 );
			if ( $thePlayList['count'] == 0 ) {
				return $content;
			}
			$this->countPlaylist = $thePlayList['count'];
			$this->PlayerPlaylist = $thePlayList;			
			
			if ( is_active_widget( false, false, 'mp3-jplayer-widget' , true ) || strpos($content, "[mp3-jplayer") !== false ) {
				return $content;
			}
			// write startup js and player html //
			$this->write_startup_vars( $thePlayList['count'], $this->theSettings['auto_play'], $this->theSettings['playlist_show'] );
			$this->write_playlist( $thePlayList );
			$theplayer = $this->write_player_html( $thePlayList['count'], $this->theSettings['player_float'], $this->theSettings['show_downloadmp3'] );
			$content = $theplayer . $content . "<br clear=\"all\" />";
			$this->playerHasBeenSet = "true";
			// debug info //
			$this->playerSetMethod = "content (default)";
			$this->playerAddedOnRun = $this->defaultAdd_runCount;
			return $content;
		}


   /**
	*	Handles player placement via SHORTCODE. 
	*	The attributes overide the settings page values.
	*	Called via [mp3-jplayer] shortcode.
	*/
		function shortcode_handler($atts, $content = null) {
			
			$this->shortcode_runCount++;
			if ( ($this->tagflag == "true" && $this->theSettings['disable_template_tag'] == "false") || $this->playerHasBeenSet == "true" || $this->customFieldsGrabbed == "false" ) {
				return;
			}
			if ( is_active_widget(false, false, 'mp3-jplayer-widget', true) && ((is_home() || is_archive()) || (is_singular() && $this->theSettings['give_shortcode_priority'] == "false")) ) {
				return;
			}
			extract(shortcode_atts(array( // Defaults //
				'pos' => $this->theSettings['player_float'], 
				'dload' => $this->theSettings['show_downloadmp3'],
				'play' => $this->theSettings['auto_play'],
				'list' => $this->theSettings['playlist_show'],
				'shuffle' => false,
				'id' => '',
				'slice' => ''
			), $atts));
			
			// If FEED:ID was flagged in the custom fields and the shortcode contains an id then try add tracks to current playlist //
			if ( $id != "" && $this->IDflag_inMeta == "true" ) { 
				$id = trim($id);
				if ( $this->TT_grab_Custom_Meta($id) > 0 ) {
					$thePlayList = $this->generate_playlist( $this->postMetaKeys, $this->postMetaValues, 1 );
					if ( $thePlayList['count'] > 0 ) {
						foreach ( $this->PlayerPlaylist['order'] as $i => $val ) {
							array_push( $thePlayList['order'], $i + $thePlayList['count'] );
							array_push( $thePlayList['artists'], $this->PlayerPlaylist['artists'][$i] );
							array_push( $thePlayList['titles'], $this->PlayerPlaylist['titles'][$i] );
							array_push( $thePlayList['files'], $this->PlayerPlaylist['files'][$i] );
						}
						$thePlayList['count'] += $this->PlayerPlaylist['count'];
						unset( $this->PlayerPlaylist );
						$this->PlayerPlaylist = $thePlayList;
					}		
				}
			}
			if ( $this->PlayerPlaylist['count'] < 1 ) {
				return;
			}
			if ( $slice != "" && $slice > 0 ) {
				$this->take_playlist_slice( $slice );
			}
			// Write startup js and player html //
			if ( $shuffle ) {
				if ( $this->PlayerPlaylist['count'] > 1 ) { shuffle( $this->PlayerPlaylist['order'] ); }
			}
			if ( $list == "radio" || $list == "hidden" || $list == "closed" ) {
				$this->listDisplayMode = $list;
				$list = "false";
			}
			if ( $list == "open" ) { $list = "true"; }
			$this->write_startup_vars( $this->PlayerPlaylist['count'], $play, $list );
			$this->write_playlist( $this->PlayerPlaylist );
			$theplayer = $this->write_player_html( $this->countPlaylist, $pos, $dload );
			$this->playerHasBeenSet = "true";
			// Debug info //
			$this->playerSetMethod = "shortcode";
			$this->playerAddedOnRun = $this->shortcode_runCount;
			return $theplayer;			
		}
		
	
   /**
	*	Handles player placement via mp3j_put() TAG.
	*/
		function template_tag_handler( $id = "", $pos = "", $dload = "", $play = "", $list = "" ) {
			
			$this->putTag_runCount++;
			if ( $this->playerHasBeenSet == "true" || $this->theSettings['disable_template_tag'] == "true" || $this->tagflag == "false" ) {
				return;
			}
			if ( ((is_home() || is_archive()) && $this->theSettings['player_onblog'] == "true") || is_singular() ) {
				if ( $id == "first" ) {
					$id = $this->idfirstFound;
				}
				if ( $this->TT_grab_Custom_Meta($id) > 0 && $id != "feed" ) {
					$customvalues = $this->postMetaValues;
					$customkeys = $this->postMetaKeys;
				}
				else if ( $id == "feed" ) {
					$customvalues = $this->feedValues;
					$customkeys = $this->feedKeys;
				}
				else {
					return;
				}
			}
			else {
				return;
			}
			
			// Build a playlist //
			$thePlayList = $this->generate_playlist( $customkeys, $customvalues, 1 );
			if ( $thePlayList['count'] == 0 ) {
				return;
			}
			$this->countPlaylist = $thePlayList['count'];
			$this->PlayerPlaylist = $thePlayList;
			
			// Write startup js and player html //
			if ( $pos == "" ) { $pos = $this->theSettings['player_float']; }
			if ( $dload == "" ) { $dload = $this->theSettings['show_downloadmp3']; }
			if ( $play == "" ) { $play = $this->theSettings['auto_play']; }
			
			if ( $list == "" ) { $list = $this->theSettings['playlist_show']; }
			if ( $list == "radio" || $list == "hidden" || $list == "closed" ) {
				$this->listDisplayMode = $list;
				$list = "false";
			}
			if ( $list == "open" ) { $list = "true"; }
			
			$this->write_startup_vars( $thePlayList['count'], $play, $list );
			$this->write_playlist( $thePlayList );
			$theplayer = $this->write_player_html( $thePlayList['count'], $pos, $dload );
			echo $theplayer;
			$this->playerHasBeenSet = "true";
			// debug info //
			$this->playerSetMethod = "mp3j_put";
			$this->playerAddedOnRun = $this->putTag_runCount;
			
			return;			
		}
	

   /**
	*	GENERATES A PLAYLIST, puts the custom meta through sorting/filtering routine and returns arrays
	*	ready for write_playlist().
	*
	*	$method not used yet
	*/	
		function generate_playlist( $customkeys, $customvalues, $method = 1 ) {
			
			if ( count($customkeys) == 0 ) { return; }
			$theSplitMeta = $this->splitup_meta( $customkeys, $customvalues );
			$theAssembledMeta = $this->compare_swap( $theSplitMeta, $customkeys, $customvalues );
			$theTrackLists = $this->sort_tracks( $theAssembledMeta, $customkeys );
			$thePlayList = $this->remove_mp3remote( $theTrackLists );
			return $thePlayList;
		}


   /**
	*	Selects a random selection of x tracks from the playlist
	*	while preserving track running order
	*/
		function take_playlist_slice( $slicesize ) {
			
			if ( ($n = $this->PlayerPlaylist['count']) < 1 ) { return; }
			$n = $this->PlayerPlaylist['count'];
			$slicesize = trim($slicesize);
			if ( !empty($slicesize) && $slicesize >= 1 ) {
				if ( $n > 1 ) {
					if ( $slicesize > $n ) { $slicesize = $n; }
					$picklist = array();
					for ( $i = 0; $i < $n; $i++ ) { // make a numbers array //
						$picklist[$i] = $i;
					} 
					shuffle( $picklist );
					$picklist = array_slice( $picklist, 0, $slicesize ); // take a shuffled slice //
					natsort( $picklist ); // reorder it //
					$j=0;
					foreach ( $picklist as $i => $num ) { // use it to pick the random tracks in order //
						$Ptitles[$j] = $this->PlayerPlaylist['titles'][$num];
						$Partists[$j] = $this->PlayerPlaylist['artists'][$num];
						$Pfiles[$j] = $this->PlayerPlaylist['files'][$num];
						//$Porder[$j++] = $this->PlayerPlaylist['order'][$num];
						$Porder[$j] = $j;
						$j++;
					}
					$thePlayList = array(	'artists' => $Partists, 
											'titles' => $Ptitles,
											'files' => $Pfiles,
											'order' => $Porder,
											'count' => $j );
					unset($this->PlayerPlaylist);
					$this->PlayerPlaylist = $thePlayList;
					$this->countPlaylist =  $thePlayList['count'];
					return $thePlayList;
				}
			}
		}


   /**
	*	FLAGS for an UPCOMING mp3j_put TAG.
	*	Called via mp3j_flag.
	*/	
		function flag_tag_handler($set = 1) {
			
			if ( $set == 0 ) { $this->tagflag = "false"; }
			if ( $set == 1 ) { $this->tagflag = "true"; }
			return;
		}
	
	
   /**
	*	FLAGS for SCRIPTS to be added.
	*	Called via mp3j_addscripts template tag.
	*/	
		function scripts_tag_handler( $style = "" ) {
			
			$this->scriptsflag = "true";
			if ( $style == "" ) {
				$this->theSettings = get_option($this->adminOptionsName);
				$this->stylesheet = $this->theSettings['player_theme'];
			}
			else { $this->stylesheet = $style; }
			return;
		}
		
	
   /**
	*	Returns Mp3 LIBRARY in INDEXED arrays.
	*	Called via mp3j_grab_library.
	*/			
		function grablibrary_handler( $thereturn ) {
			
			if ( empty($this->mp3LibraryI) ) { $this->grab_library_info(); }
			$thereturn = $this->mp3LibraryI;			
			return $thereturn;
		}


   /**
	*	Returns Mp3 LIBRARY as returned from the SELECT query.
	*	Called via mp3j_grab_library.
	*/			
		function grablibraryWP_handler( $thereturn ) {
			
			if ( empty($this->mp3LibraryWP) ) { $this->grab_library_info(); }
			$thereturn = $this->mp3LibraryWP;
			return $thereturn;
		}

	
  /**
	*	READS mp3's from a LOCAL DIRECTORY.
	*	Returns an array of their uri's.
	*/			
		function grab_local_folder_mp3s( $folder ) {
		
			$Srooturl = $_SERVER['HTTP_HOST'];
			$rooturl = str_replace("www.", "", $Srooturl);				
			$items = array();
			$debug = $this->theSettings['echo_debug'];
			if ( ($lp = strpos($folder, $rooturl)) || preg_match("!^/!", $folder) ) {
				if ( $lp !== false ) {
					$folderpath = str_replace($rooturl, "", $folder);
					$folderpath =  str_replace("www.", "", $folderpath);
					$folderpath =  str_replace("http://", "", $folderpath);
				}
				else {
					$folderpath = $folder;
				}
				$path = $_SERVER['DOCUMENT_ROOT'] . $folderpath;
				if ($handle = @opendir($path)) {
					$j=0;
					while (false !== ($file = readdir($handle))) {
						if ( $file != '.' && $file != '..' && filetype($path.'/'.$file) == 'file' && preg_match("!\.mp3$!i", $file) ) {
							$items[$j++] = $file;
						}
					}
					closedir($handle);
					if ( ($c = count($items)) > 0 ) {
						natcasesort($items);
						$folderpath = preg_replace( "!/+$!", "", $folderpath );
						foreach ( $items as $i => $mp3 ) {
							$items[$i] = "http://" . $Srooturl . $folderpath . "/" . $mp3;
						}
					}
					if ( $debug == "true" ) { echo "\n<!-- \n\nMP3-jPlayer\nDone\nmp3's in folder: " . $c . "\nhttp://" . $Srooturl . $folderpath . "\n\n -->"; }
					return $items;
				}
				else {
					if ( $debug == "true" ) { echo "\n<!-- \n\nMP3-jPlayer\nFailed to open local folder, check path and permissions.\nhttp://" . $Srooturl . $folderpath . "\n\n-->"; }
					return true;
				}
			}
			else {
				if ( $debug == "true" ) { echo "\n<!-- \n\nMP3-jPlayer\nFolder path is either unreadable or remote, didn't attempt to read it.\n" . $folderpath . "\n\n -->"; }
				return false;
			}
		}


   /**
	* 	GETS the current ACTIVE player WIDGETS and checks their settings to see if any
	*	are in mode 2 or 3 (playing a set list, if so then scripts will be needed regardless of custom fields).
	*	Returns true if it finds an active widget in mode 2 or 3
	*/
		function widget_needs_scripts() {
			
			$activeplayerwidgets = array();
			$widgetneedsScripts = false;
			
			// get instances of active players //
			$name = "sidebars_widgets";
			$sidebarsettings = get_option($name);
			$n = 0;
			foreach ( $sidebarsettings as $key => $arr ) {
				if ( strpos($key, "sidebar") !== false ) {
					foreach ( $arr as $i => $widget ) {
						if ( strchr($widget, "mp3-jplayer-widget") ) {
							$activeplayerwidgets[$n++] = $widget;
						} 
					}
				}
			}
			$this->activeWidgets = $activeplayerwidgets; // Debug //
			
			// if active then check their modes //
			if ( !empty($activeplayerwidgets) ) {
				$name = "widget_mp3-jplayer-widget";
				$widgetoptions = get_option($name);
				foreach ( $activeplayerwidgets as $i => $playerwidget ) {
					$widgetID = strrchr( $playerwidget, "-" );
					$widgetID = str_replace( "-", "", $widgetID );
					foreach ( $widgetoptions as $j => $arr ) {
						if ( $j == $widgetID ) {
							if ( $arr['widget_mode'] == "2" || $arr['widget_mode'] == "3" ) {
								$widgetneedsScripts = true;
								break 2;
							}
						}	
					}
				}
			}
			return $widgetneedsScripts;
		}

	
   /**
	* 	GETS custom field META from post/page.
	* 	Takes optional post id, creates indexed arrays.
	* 	Returns number of tracks
	*/
		function TT_grab_Custom_Meta( $id = "" ) {
			
			if ( $id == "feed" ) {
				return 1;
			}
			if ( !empty($this->postMetaValues) ) {
				unset( $this->postMetaKeys, $this->postMetaValues );
				$this->postMetaKeys = array();
				$this->postMetaValues = array();
				$this->customFieldsGrabbed = "false";
			}
			$this->IDflag_inMeta == "false";
			
			global $wpdb;
			global $post;
			if ( $id == "" ) { $id = $post->ID;	}
			$pagesmeta = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id =" .$id. "  ORDER BY meta_key ASC");
			$i = 0;
			$metacount = 0;
			foreach ( $pagesmeta as $obj ) { 
				$flag = 0;
				foreach ( $obj as $k => $value ) {
					if ( $k == "meta_key" ){
						if ( preg_match('/^([0-9]+(\s)?)?mp3(\..*)?$/', $value) == 1 ) { // Grab the meta //
							$this->postMetaKeys[$i] = $value;
							$metacount++;
							$flag = 1;
						}
					}
					if ( $k == "meta_value" ){
						if ( $flag == 1 ) { $this->postMetaValues[$i++] = $value; }
					}
				}
			}
			
			foreach ( $this->postMetaValues as $i => $val ) { // Store any 'FEED' values/keys and delete them //
				if ( preg_match( "!^FEED:(DF|ID|LIB|/.*)$!i", $val ) == 1 ) {
					$sources[$i] = strstr( $val, ":" );
					$sources[$i] = str_replace( ":", "", $sources[$i] );
					$sourcekeys[$i] = $this->postMetaKeys[$i];
					unset( $this->postMetaValues[$i], $this->postMetaKeys[$i] );
					$metacount--;
				}	
			}		
			if ( !empty($sources) ) { // Add the feeds to postMeta arrays //
				$this->extend_custom_meta( $sources, $sourcekeys );
				$metacount = count($this->postMetaKeys);
				if ( $this->IDflag_inMeta == "true" ) {	$metacount++; } // Add a confusing 'false' count for any ID type feeds to be picked up later // 
			}
			$this->postMetaValues = array_values( $this->postMetaValues );
			$this->postMetaKeys = array_values( $this->postMetaKeys );	
			if ( $metacount > 0 ) { $this->customFieldsGrabbed = "true"; } // it has become confusing since FEED:ID added, to sort! // 
			return $metacount;
		}
	
   
   /**
	*	Creates ALTERNATIVE META ARRAYS.
	*	Called via mp3j_set_meta.
	*
	*	$startnum is the track number offset to use when labeling the metakeys 
	*/			
		function feed_metadata( $tracks, $captions = "", $startnum = 1 ) {
			
			if ( empty($tracks) || !is_array($tracks) ) { 
				return; 
			}
			unset( $this->feedKeys );
			unset( $this->feedValues );
			$this->feedKeys = array();
			$this->feedValues = array();
			
			$j = 1;
			if ( empty($captions) ) {
				foreach ( $tracks as $i => $file ) {
					$this->feedKeys[$i] = $startnum++ . " mp3.";
					$this->feedValues[$i] = $file;
				}
			}
			else {
				foreach ( $tracks as $i => $file ) {
					if ( !empty($captions[$i]) ) {
						if ( preg_match('/^([0-9]+(\s)?)?mp3(\..*)?$/', $captions[$i]) == 1 ) {	
							$this->feedKeys[$i] = $captions[$i];
						}
						else {
							$this->feedKeys[$i] = $startnum++ . " mp3." . $captions[$i];
						}
					}
					else {
						$this->feedKeys[$i] = $startnum++ . " mp3.";
					}
					$this->feedValues[$i] = $file;
				}
			}
			return;
		}
		
   
   /**
	* 	PUSHES new tracks onto POSTMETA arrays according to Library and local folder feed types,
	*	and flags for an ID feed to be set by shortcode
	*/
   		function extend_custom_meta( $feeds, $keys ) {
			
			foreach ( $feeds as $i => $val )
			{
				if ( $val == "ID" ) {
					$this->IDflag_inMeta = "true";
				}
				elseif ( $val == "LIB" ) {
					if ( empty($this->mp3LibraryI) ) { $library = $this->grab_library_info(); }
					else { $library = $this->mp3LibraryI; }
					if ( $library['count'] >= 1 ) {
						$counter = count($this->postMetaValues);
						foreach ( $library['filenames'] as $k => $fn ) {
							$captions[$k] = $keys[$i];
						} 
						$this->feed_metadata( $library['filenames'], $captions, ++$counter );
						foreach ( $this->feedKeys as $j => $x ) {
							array_push( $this->postMetaValues, $this->feedValues[$j] );
							array_push( $this->postMetaKeys, $x );
						}
					}
				}
				else {
					if ( $val == "DF" ) { $val = $this->theSettings['mp3_dir'];	}
					$tracks = $this->grab_local_folder_mp3s( $val ); 
					if ( $tracks !== true && $tracks !== false && count($tracks) > 0 ) {
						$counter = count($this->postMetaValues);
						foreach ( $tracks as $k => $fn ) {
							$captions[$k] = $keys[$i];
						}
						$this->feed_metadata( $tracks, $captions, ++$counter );
						foreach ( $this->feedKeys as $j => $x ) {
							array_push( $this->postMetaValues, $this->feedValues[$j] );
							array_push( $this->postMetaKeys, $x );
						}
					}
				}
			}
			return;
		}
   
   
   /**
	* 	Returns LIBRARY mp3 filenames, titles, excerpts, content, uri's 
	*	in indexed arrays.
	*/
		function grab_library_info() {		
		
			global $wpdb;
			$audioInLibrary = $wpdb->get_results("SELECT DISTINCT guid, post_title, post_excerpt, post_content, ID FROM $wpdb->posts WHERE post_mime_type = 'audio/mpeg'"); 
			$j=0;
			$Lcount = count($audioInLibrary);
			$this->mp3LibraryWP = $audioInLibrary;
			
			foreach ( $audioInLibrary as $libkey => $libvalue ) {
				foreach ( $libvalue as $itemkey => $itemvalue ) {
					if ( $itemkey == "guid" ) {
						$libraryURLs[$j] = $itemvalue;
						$libraryFilenames[$j] = strrchr( $libraryURLs[$j], "/");
						$libraryFilenames[$j] = str_replace( "/", "", $libraryFilenames[$j]); 
					}
					if ( $itemkey == "post_title" ) {
						$libraryTitles[$j] = $itemvalue;
					}
					if ( $itemkey == "post_excerpt" ) {
						$libraryExcerpts[$j] = $itemvalue;
					}
					if ( $itemkey == "post_content" ) {
						$libraryDescriptions[$j] = $itemvalue;
					}
					if ( $itemkey == "ID" ) {
						$libraryPostIDs[$j] = $itemvalue;
					}
				}
				$j++;
			}
			if ( $libraryFilenames ) { natcasesort($libraryFilenames); }
			$theLibrary = array(	'filenames' => $libraryFilenames,
									'titles' => $libraryTitles,
									'urls' => $libraryURLs,
									'excerpts' => $libraryExcerpts,
									'descriptions' => $libraryDescriptions,
									'postIDs' => $libraryPostIDs,
									'count' => $Lcount );
			$this->mp3LibraryI = $theLibrary;
			return $theLibrary;
		}
		
		
   /**	
	* 	SPLITS up the custom keys/values into artist/title/file indexed arrays. if there's 
	*	no title then uses the filename, if there's no artist then checks whether to use the previous artist.
	*
	* 	Return arrays: artists, titles, filenames. 
	*/
		function splitup_meta($customkeys, $customvalues) {		
			
			// Captions //
			$prevArtist = "";
			foreach ( $customkeys as $i => $ckvalue ) {
				$splitkey = explode('.', $ckvalue, 2);
				if ( empty($splitkey[1]) ) {
					if ( preg_match('/^([0-9]+(\s)?)?mp3\.$/', $ckvalue) == 1 ) {
						$customArtists[$i] = "";
					}
					else {
						$customArtists[$i] = $prevArtist;
					}
				}
				else {
					$customArtists[$i] = $splitkey[1];
				}
				$prevArtist = $customArtists[$i];
			}
				
			// Titles & Filenames //
			foreach ( $customvalues as $i => $cvvalue ) {	
				$checkfortitle = strpos($cvvalue, '@');
				if ( $checkfortitle === false ) {
					$customTitles[$i] = str_replace(".mp3", "", $cvvalue);
					$customFilenames[$i] = $cvvalue;
					if ( $this->theSettings['hide_mp3extension'] == "false" ) {
						$customTitles[$i] .= ".mp3";
					}
				}
				else {
					$reversevalue = strrev($cvvalue);
					$splitvalue = explode('@', $reversevalue, 2);
					$customTitles[$i] = strrev($splitvalue[1]);
					$customFilenames[$i] = strrev($splitvalue[0]);
				}
				if ( preg_match('/\.mp3$/', $customFilenames[$i]) == 0 ) {
					$customFilenames[$i] .= ".mp3";
				}
				if ( strpos($customFilenames[$i], "www.") !== false ) {
					$customFilenames[$i] = str_replace("www.", "", $customFilenames[$i]);
					if ( strpos($customFilenames[$i], "http://") === false ) {
						$customFilenames[$i] = "http://" .$customFilenames[$i];
					}
				}
			}
			$theSplitMeta = array(	'artists' => $customArtists, 
									'titles' => $customTitles,
									'files' => $customFilenames );
			return $theSplitMeta;
		}
	
			
   /**	
	*	Returns PREPARED ARRAYS that are ready for playlist.
	*	Looks for $customFilenames that exist in the library and grabs their full uri's, otherwise 
	*	adds default path or makes sure has an http when remote. Cleans up titles that are uri's, swaps 
	*	titles and/or artists for the library ones when required. 
	*
	*	Return: artists, titles, urls.
	*/
		function compare_swap($theSplitMeta, $customkeys, $customvalues) {
			
			if ( empty($this->mp3LibraryI) ) { 
				$library = $this->grab_library_info(); 
			}
			else { 
				$library = $this->mp3LibraryI;
			}
			foreach ( $theSplitMeta['files'] as $i => $cfvalue ) 
			{
				if ( $library['count'] == 0 ) { 
					$inLibraryID = false;
				}
				else {
					$inLibraryID = array_search( $cfvalue, $library['filenames'] );
				}
				$mp3haswww = strpos($cfvalue, 'http://');
				if ( $mp3haswww === false && $inLibraryID === false ) { // File is local but not in library // 
					if ( $this->theSettings['mp3_dir'] == "/" ) {
						$theSplitMeta['files'][$i] = $this->theSettings['mp3_dir'] . $theSplitMeta['files'][$i];
					}
					else {
						$theSplitMeta['files'][$i] = $this->theSettings['mp3_dir']. "/" . $theSplitMeta['files'][$i];
					}
				}
				if ( $inLibraryID !== false ) { // File is in library //
					$theSplitMeta['files'][$i] = $library['urls'][$inLibraryID];
					if ( $this->theSettings['playlist_UseLibrary'] == "true" ) {
						$theSplitMeta['titles'][$i] = $library['titles'][$inLibraryID];
						$theSplitMeta['artists'][$i] = $library['excerpts'][$inLibraryID];
					}
					else {
						if ( preg_match('/^([0-9]+(\s)?)?mp3$/', $customkeys[$i]) == 1 ) {
							$theSplitMeta['artists'][$i] = $library['excerpts'][$inLibraryID];
						}
						if ( preg_match('/^([0-9]+(\s)?)?mp3\.$/', $customkeys[$i]) == 1 ) {
							$theSplitMeta['artists'][$i] = "";
						}
						if ( strpos($customvalues[$i], '@') === false ) {
							$theSplitMeta['titles'][$i] = $library['titles'][$inLibraryID];
						}
					}
				}
				if ( $mp3haswww !== false && $inLibraryID === false ) { // File is remote or user is over-riding default path //
					if ( strpos($theSplitMeta['titles'][$i], 'http://') !== false || strpos($theSplitMeta['titles'][$i], 'www.') !== false ) {
						$theSplitMeta['titles'][$i] = strrchr($theSplitMeta['titles'][$i], "/");
						$theSplitMeta['titles'][$i] = str_replace( "/", "", $theSplitMeta['titles'][$i]);
					}
				}
			}
			
			$theAssembledMeta = array(	'artists' => $theSplitMeta['artists'], 
										'titles' => $theSplitMeta['titles'],
										'files' => $theSplitMeta['files'] );
			return $theAssembledMeta;
		}
		
		
   /**	
	*	SORTS TRACKS by either the titles(if a-z ticked) or by the keys (only if there's
	*	any numbering in them) and adds an ordering array
	*
	*	Return: artists, titles, files, order.
	*/
		function sort_tracks($theAssembledMeta, $customkeys) {		
			
			$x = 0;
			if ( $this->theSettings['playlist_AtoZ'] == "true" ) {
				natcasesort($theAssembledMeta['titles']);
				foreach ($theAssembledMeta['titles'] as $kt => $vt) {
					$indexorder[$x++] = $kt;
				} 
			}
			else {
				$numberingexists = 0;
				foreach ( $customkeys as $ki => $val ) {
					if ( preg_match('/^[0-9]/', $val) ) {
						$numberingexists++;
						break;
					}
				}
				if ( $numberingexists > 0 ) {
					natcasesort($customkeys);
					foreach ( $customkeys as $kf => $vf ) {
						$indexorder[$x++] = $kf;
					}
				}
				else {
					foreach ( $theAssembledMeta['titles'] as $kt => $vt ) {
						$indexorder[$x++] = $kt;
					}
				} 
			}
			
			$theTrackLists = array(	'artists' => $theAssembledMeta['artists'], 
									'titles' => $theAssembledMeta['titles'],
									'files' => $theAssembledMeta['files'],
									'order' => $indexorder );
			return $theTrackLists;
		}
			
	
   /**
	*	REMOVES any REMOTE tracks from the playlist arrays if allow_remoteMp3 is unticked. 
	*	current logic requires this filter be run after filenames have been sanitized/replaced by compare_swap() which
	*	is maybe not ideal.
	*
	*	return: artists, titles, filenames, order, count
	*
	*/
		function remove_mp3remote( $theTrackLists ) {	
	
			if ( $this->theSettings['allow_remoteMp3'] == "false" ) {
				$localurl = get_bloginfo('url');
				foreach ( $theTrackLists['order'] as $ik => $i ) {
					if ( strpos($theTrackLists['files'][$i], $localurl) !== false || strpos($theTrackLists['files'][$i], "http://") === false || (strpos($this->theSettings['mp3_dir'], "http://") !== false && strpos($theTrackLists['files'][$i], $this->theSettings['mp3_dir']) !== false) ) {
						$playlistFilenames[$i] = $theTrackLists['files'][$i];
						$playlistTitles[$i] = $theTrackLists['titles'][$i];
						$playlistArtists[$i] = $theTrackLists['artists'][$i];
						$indexorderAllowed[$x++] = $i;
					}
				}
			}
			else {
				$playlistFilenames = $theTrackLists['files'];
				$playlistTitles = $theTrackLists['titles'];
				$playlistArtists = $theTrackLists['artists'];
				$indexorderAllowed = $theTrackLists['order'];
			}
			$playlistTitles = str_replace('"', '\"', $playlistTitles); // Escapes quotes for the js array //
			$nAllowed = count($playlistFilenames);
			
			$thePlayList = array(	'artists' => $playlistArtists, 
									'titles' => $playlistTitles,
									'files' => $playlistFilenames,
									'order' => $indexorderAllowed,
									'count' => $nAllowed );
			return $thePlayList;
		}
	
   
   /**
	* 	ENQUEUES the js and css scripts.
	*/
		function add_Scripts( $theme ) {
			
			wp_enqueue_script( 'jquery', '/wp-content/plugins/mp3-jplayer/js/jquery.js' );
			wp_enqueue_script( 'ui.core', '/wp-content/plugins/mp3-jplayer/js/ui.core.js', array( 'jquery' ) );
			wp_enqueue_script( 'ui.progressbar.min', '/wp-content/plugins/mp3-jplayer/js/ui.progressbar.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'ui.slider.min', '/wp-content/plugins/mp3-jplayer/js/ui.slider.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'jquery.jplayer.min', '/wp-content/plugins/mp3-jplayer/js/jquery.jplayer.min.js', array( 'jquery' ) );	
			wp_enqueue_script( 'mp3-jplayer', '/wp-content/plugins/mp3-jplayer/js/mp3-jplayer.js', array( 'jquery' ) );
			
			// Set the style sheet either from admin (A-E) or template tag //
			$size = "";
			if ( $this->theSettings['use_small_player'] == "true" ) { $size = "-sidebar"; }
			if ( $theme == "styleA" ) { $themepath = "/wp-content/plugins/mp3-jplayer/css/mp3jplayer-grey" . $size . ".css"; }
			if ( $theme == "styleB" ) { $themepath = "/wp-content/plugins/mp3-jplayer/css/mp3jplayer-green" . $size . ".css"; }
			if ( $theme == "styleC" ) { $themepath = "/wp-content/plugins/mp3-jplayer/css/mp3jplayer-blu" . $size . ".css"; }
			if ( $theme == "styleD" ) { $themepath = str_replace(".css", "", $this->theSettings['custom_stylesheet']) . $size . ".css"; }
			if ( $theme == "styleE" ) { $themepath = "/wp-content/plugins/mp3-jplayer/css/mp3jplayer-text" . $size . ".css"; }
			$name = strrchr( $themepath, "/");
			$name = str_replace( "/", "", $name);
			$name = str_replace( ".css", "", $name);
			wp_enqueue_style( $name, $themepath );
			return;
		}
	
	
   /**
	*	WRITES player START-UP JS vars  
	*/
		function write_startup_vars( $count, $autoplay = "", $showlist = "" ) {
			
			if ( $autoplay != "true" && $autoplay != "false" ) { $autoplay = $this->theSettings['auto_play']; }
			if ( $showlist != "true" && $showlist != "false" ) { $showlist = $this->theSettings['playlist_show']; }
			
			$wpinstallpath = get_bloginfo('wpurl');
			echo "\n\n<script type=\"text/javascript\">\n<!--\n";
			echo "var foxpathtoswf = \"" .$wpinstallpath. "/wp-content/plugins/mp3-jplayer/js\";\n";
			echo "var foxAutoPlay =" . $autoplay . ";\n";
			echo "var foxInitialVolume =" . $this->theSettings['initial_vol'] . ";\n";
			echo "var foxpathtoimages = \"" .$wpinstallpath. "/wp-content/plugins/mp3-jplayer/css/images/\";\n";
			echo "var foxPlaylistRepeat = \"" . $this->theSettings['playlist_repeat'] . "\";\n";
			if ( $count < 2 ) {
				echo "var foxShowPlaylist = \"false\";\n";
			}
			else {
				echo "var foxShowPlaylist = \"" .$showlist. "\";\n";
			}
			echo "//-->\n</script>\n\n";
			return;
		}
   	
	   	
   /**
	* 	WRITES the FINAL PLAYLIST array.
	*/
		function write_playlist( $thePlayList ) {
			
			echo "\n\n<script type=\"text/javascript\">\n<!--\n";
			echo "var foxPlayList = [\n";
			$tracknumber = 1;
			$addNo = $this->theSettings['add_track_numbering'];
			foreach ( $thePlayList['order'] as $ik => $i ) {
				echo "{name: \"";
				if ( $addNo == "true" ) {
					echo $tracknumber . ". ";
				}
				echo $thePlayList['titles'][$i]. "\", mp3: \"" .$thePlayList['files'][$i]. "\", artist: \"" .$thePlayList['artists'][$i]. "\"}";
				if ( $tracknumber != $thePlayList['count'] ) {
					echo ",";
				}
				echo "\n";
				$tracknumber++;
			}
			echo "];\n";
			echo "//-->\n</script>\n\n";
			return;
		}
   

   /**
	* 	WRITES PLAYER HTML
	*/
		function write_player_html( $count, $position, $download ) {			
						
			if ( $position == "left" ) { $floater = "float: left; padding: 5px 50px 50px 0px;"; }
			else if ( $position == "right" ) { $floater = "float: right; padding: 5px 0px 50px 50px;"; }
			else if ( $position == "absolute" ) { $floater = "position: absolute;"; }
			else if ( $position == "rel-C" ) { $floater = "position:relative; padding:5px 0px 50px 0px; margin:0px auto 0px auto;"; }
			else if ( $position == "rel-R" ) { $floater = "position:relative; padding:5px 0px 50px 0px; margin:0px 0px 0px auto;"; }
			else { $floater = "position: relative; padding: 5px 0px 50px 0px;"; }
			
			if ( $download == "true" ) { $showMp3Link = "visibility: visible;"; }
			else { $showMp3Link = "visibility: hidden;"; }
			
			if ( $count < 2 ) { 
				$showlistcontrolsP = "visibility: hidden;";
				$showlistcontrolsN = "visibility: hidden;";
				$showlisttoggle = "visibility: hidden;";
			 }
			else if ( $count >= 2 && $this->listDisplayMode == "radio" ) {
				$showlistcontrolsP = "visibility: hidden;";
				$showlistcontrolsN = "visibility: visible;";
				$showlisttoggle = "visibility: hidden;";
			}
			else if ( $count >= 2 && $this->listDisplayMode == "hidden" ) {
				$showlistcontrolsP = "visibility: visible;";
				$showlistcontrolsN = "visibility: visible;";
				$showlisttoggle = "visibility: hidden;";
			}
			else { 
				$showlistcontrolsP = "visibility: visible;";
				$showlistcontrolsN = "visibility: visible;";
				$showlisttoggle = "visibility: visible;";
			}
						
			$player = "<div id=\"jquery_jplayer\"></div>
			<div class=\"jp-playlist-player\" style=\"" .$floater. "\">
				<div class=\"jp-innerwrap\">
					<div id=\"innerx\"></div>
					<div id=\"innerleft\"></div>
					<div id=\"innerright\"></div>
					<div id=\"innertab\"></div>\n
					<div class=\"jp-interface\">
						<div id=\"player-track-title\"></div>
						<div id=\"player-artist\"></div>
						<ul class=\"jp-controls\">
							<li><a href=\"#\" id=\"jplayer_play\" class=\"jp-play\" tabindex=\"1\">Play</a></li>
							<li><a href=\"#\" id=\"jplayer_pause\" class=\"jp-pause\" tabindex=\"1\">Pause</a></li>
							<li><a href=\"#\" id=\"jplayer_stop\" class=\"jp-stop\" tabindex=\"1\">Stop</a></li>
							<li><a href=\"#\" id=\"jplayer_previous\" class=\"jp-previous\" tabindex=\"1\" style=\"" .$showlistcontrolsP. "\">&laquo;prev</a></li>
							<li><a href=\"#\" id=\"jplayer_next\" class=\"jp-next\" tabindex=\"1\" style=\"" .$showlistcontrolsN. "\">next&raquo;</a></li>
						</ul>
						<div id=\"sliderVolume\"></div>
						<div id=\"bars_holder\">
							<div id=\"loaderBar\"></div>
							<div id=\"sliderPlayback\"></div>
						</div>
						<div id=\"jplayer_play_time\" class=\"jp-play-time\"></div>
						<div id=\"jplayer_total_time\" class=\"jp-total-time\"></div>
						<div id=\"status\"></div>
						<div id=\"downloadmp3-button\" style=\"" .$showMp3Link. "\"></div>
						<div id=\"playlist-toggle\" style=\"" .$showlisttoggle. "\" onclick=\"javascript:toggleplaylist();\">HIDE PLAYLIST</div>
					</div>
				</div>\n
				<div id=\"playlist-wrap\">	
					<div id=\"jplayer_playlist\" class=\"jp-playlist\"><ul><li></li></ul></div>
				</div>
			</div>\n";
			return $player;
		}


   /**
	*	Diagnostic print handler.
	*	Called by wp_footer().
	*/	
		function debug_print_handler() {
			if ( $this->theSettings['echo_debug'] == "true" ) {
				$this->debug_info('all');
			}
			return;	
		}

			
   /**
	*	DIAGNOSTIC HELP, prints vars/arrays to browser source view.
	*	Called via mp3j_debug() template tag, or admin settings.
	*	needs improvement.
	*/	
		function debug_info( $display = "" ) {	
			
			$this->make_compatible();
			$this->debugCount++;
			echo "\n\n<!-- *** DIAGNOSTIC " . $this->debugCount;
			if ( $display == "" ) { echo " (Summary)"; }
			else { echo " (Long)"; }
			echo " * MP3-jPlayer (" . $this->version_of_plugin . ") ***\n\n*** Template:\nPage type: ";
			if ( is_singular() ) { echo "Singular "; }
			if ( is_home() ) { echo "Posts index"; }
			else if ( is_single() ) { echo "post"; }
			else if ( is_page() ) { echo "page"; }
			else if ( is_archive() ) { echo "Archive"; }
			else { echo "other"; }
			echo "\nAllow tags: ";
			if ( $this->theSettings['disable_template_tag'] == "false" ) { echo "Yes"; }
			else { echo "NO"; }
			echo "\nScripts forced: " . $this->scriptsForced . "\nmp3j_put flagged: " . $this->tagflag;
			echo "\n\n*** Things encountered:\ncontent: " . $this->defaultAdd_runCount . "\nshortcodes: " . $this->shortcode_runCount . "\nwidgets: " . $this->widget_runcount . "\nmp3j_put tags: " . $this->putTag_runCount;
			echo "\n\nAttempted to add player via: " . $this->playerSetMethod;
			if ( $this->playerAddedOnRun > 0 ) { echo " on encounter no. " . $this->playerAddedOnRun; }
			echo "\nplaylist count: " . $this->countPlaylist;
			echo "\n\nADMIN SETTINGS:\n";
			print_r($this->theSettings);
			echo "\n\nACTIVE PLAYER WIDGETS:\n";
			if ( empty($this->activeWidgets) ) {
				$this->widget_needs_scripts();
			}
			print_r( $this->activeWidgets );
			
			if ( $display == "" || $display == "vars" ) { 
				echo " \n\n-->\n\n";
				return;
			} 
			echo "\n\nTHE CURRENT META KEYS:\n";
			print_r($this->postMetaKeys);
			echo "\n\nTHE CURRENT META VALUES:\n";
			print_r($this->postMetaValues);
			echo "\n\nTHE CURRENT FEED KEYS:\n";
			print_r($this->feedKeys);
			echo "\n\nTHE CURRENT FEED VALUES:\n";
			print_r($this->feedValues);
			echo "\n\nTHE CURRENT PLAYLIST:\n";
			print_r($this->PlayerPlaylist);
			if ( empty($this->mp3LibraryI) ) { $this->grab_library_info(); } 
			echo "\n\n* MP3's IN THE LIBRARY:\n";
			print_r($this->mp3LibraryI);
			echo "\n\nWIDGET SETTINGS (including inactive widgets):\n";
			$get = "widget_mp3-jplayer-widget";
			$widgetoptions = get_option($get);
			print_r( $widgetoptions );
			echo " \n\n-->\n\n";
			return;	
		}
	
   
   /**
	*	called when PLUGIN is ACTIVATED to create options if none exist.
	*/
		function initFox() { 
			$this->getAdminOptions();
		}
		
				
   /**
	*	called when PLUGIN DEactivated, keeps the admin settings if option was ticked.
	*/
		function uninitFox() { 
			
			$theOptions = get_option($this->adminOptionsName);
			if ( $theOptions['remember_settings'] == "false" ) {
				delete_option($this->adminOptionsName);
			}
		}
		
			
   /**
	*	Makes sure options array is up to date with current plugin.
	*/
		function make_compatible() {
			
			if ( $this->iscompat == true ) {
				return;
			}
			$options = get_option($this->adminOptionsName);			
			if ( count($options) == $this->option_count ) {
				$this->theSettings = $options;
			}
			else {
				$this->theSettings = $this->getAdminOptions();
			}
			$this->iscompat = true;
			return;
		}


   /**
	*	RETURNS updated set of ADMIN SETTINGS with any new options and default values 
	*	Added to the db.  
	*/
		function getAdminOptions() {
			
			$mp3FoxAdminOptions = array( // default settings //
							'initial_vol' => '100',
							'auto_play' => 'true',
							'mp3_dir' => '/',
							'player_theme' => 'styleA',
							'allow_remoteMp3' => 'true',
							'playlist_AtoZ' => 'false',
							'player_float' => 'none',
							'player_onblog' => 'true',
							'playlist_UseLibrary' => 'false',
							'playlist_show' => 'true',
							'remember_settings' => 'true',
							'hide_mp3extension' => 'false',
							'show_downloadmp3' => 'false',
							'disable_template_tag' => 'false',
							'db_plugin_version' => $this->version_of_plugin,
							'use_small_player' => 'false',
							'force_scripts_from_admin' => 'false',
							'custom_stylesheet' => '/wp-content/plugins/mp3-jplayer/css/mp3jplayer-cyanALT.css',
							'give_shortcode_priority' => 'true',
							'echo_debug' => 'false',
							'add_track_numbering' => 'true',
							'playlist_repeat' => 'true' );
			
			$theOptions = get_option($this->adminOptionsName);
			if ( !empty($theOptions) ) {
				foreach ( $theOptions as $key => $option ){
					$mp3FoxAdminOptions[$key] = $option;
				}
			}
			update_option($this->adminOptionsName, $mp3FoxAdminOptions);
			return $mp3FoxAdminOptions;
		}
		
			
   /**
	* 	DISPLAYS ADMIN page.
	*/
		function printAdminPage() { 
			
			$theOptions = $this->getAdminOptions();
			if (isset($_POST['update_mp3foxSettings']))
			{
				if (isset($_POST['mp3foxAutoplay'])) { $theOptions['auto_play'] = $_POST['mp3foxAutoplay']; } 
				else { $theOptions['auto_play'] = "false"; }
				
				if (isset($_POST['mp3foxVol'])) {
					$theOptions['initial_vol'] = preg_replace("/[^0-9]/","", $_POST['mp3foxVol']); 
					if ($theOptions['initial_vol'] < 0 || $theOptions['initial_vol']=="") {
						$theOptions['initial_vol'] = "0";
					}
					if ($theOptions['initial_vol'] > 100) {
						$theOptions['initial_vol'] = "100";
					}
				}
				
				if (isset($_POST['mp3foxfolder'])) {
					$theOptions['mp3_dir'] = preg_replace("!^.*www*\.!", "http://www.", $_POST['mp3foxfolder']);
					if (strpos($theOptions['mp3_dir'], "http://") === false) {
						if (preg_match("!^/!", $theOptions['mp3_dir']) == 0) {
							$theOptions['mp3_dir'] = "/" .$theOptions['mp3_dir'];
						} 
						else {
							$theOptions['mp3_dir'] = preg_replace("!^/+!", "/", $theOptions['mp3_dir']);
						} 
						
					}
					if (preg_match("!.+/+$!", $theOptions['mp3_dir']) == 1) {
						$theOptions['mp3_dir'] = preg_replace("!/+$!", "", $theOptions['mp3_dir']);
					}	
					if ($theOptions['mp3_dir'] == "") {
						$theOptions['mp3_dir'] = "/";
					}
				}
				
				if (isset($_POST['mp3foxTheme'])) { $theOptions['player_theme'] = $_POST['mp3foxTheme']; }
				
				if (isset($_POST['mp3foxAllowRemote'])) { $theOptions['allow_remoteMp3'] = $_POST['mp3foxAllowRemote']; }
				else { $theOptions['allow_remoteMp3'] = "false"; }
				
				if (isset($_POST['mp3foxAtoZ'])) { $theOptions['playlist_AtoZ'] = $_POST['mp3foxAtoZ']; }
				else { $theOptions['playlist_AtoZ'] = "false"; }
				
				if (isset($_POST['mp3foxFloat'])) { $theOptions['player_float'] = $_POST['mp3foxFloat']; }
				
				if (isset($_POST['mp3foxOnBlog'])) { $theOptions['player_onblog'] = $_POST['mp3foxOnBlog']; } 
				else { $theOptions['player_onblog'] = "false"; }
				
				if (isset($_POST['mp3foxUseLibrary'])) { $theOptions['playlist_UseLibrary'] = $_POST['mp3foxUseLibrary']; }
				else { $theOptions['playlist_UseLibrary'] = "false"; }
					
				if (isset($_POST['mp3foxShowPlaylist'])) { $theOptions['playlist_show'] = $_POST['mp3foxShowPlaylist']; }
				else { $theOptions['playlist_show'] = "false"; }
				
				if (isset($_POST['mp3foxRemember'])) { $theOptions['remember_settings'] = $_POST['mp3foxRemember']; }
				else { $theOptions['remember_settings'] = "false"; }
				
				if (isset($_POST['mp3foxHideExtension'])) { $theOptions['hide_mp3extension'] = $_POST['mp3foxHideExtension']; }
				else { $theOptions['hide_mp3extension'] = "false"; }
				
				if (isset($_POST['mp3foxDownloadMp3'])) { $theOptions['show_downloadmp3'] = $_POST['mp3foxDownloadMp3']; }
				else { $theOptions['show_downloadmp3'] = "false"; }
				
				if (isset($_POST['disableTemplateTag'])) { $theOptions['disable_template_tag'] = $_POST['disableTemplateTag']; }
				else { $theOptions['disable_template_tag'] = "false"; }
				
				if (isset($_POST['mp3foxSmallPlayer'])) { $theOptions['use_small_player'] = $_POST['mp3foxSmallPlayer']; } 
				else { $theOptions['use_small_player'] = "false"; }
				
				if (isset($_POST['mp3foxForceScripts'])) { $theOptions['force_scripts_from_admin'] = $_POST['mp3foxForceScripts']; } 
				else { $theOptions['force_scripts_from_admin'] = "false"; }
				
				if (isset($_POST['mp3foxCustomStylesheet'])) { 
					$theOptions['custom_stylesheet'] = preg_replace("!^.*www*\.!", "http://www.", $_POST['mp3foxCustomStylesheet']);
					if (strpos($theOptions['custom_stylesheet'], "http://") === false) {
						if (preg_match("!^/!", $theOptions['custom_stylesheet']) == 0) {
							$theOptions['custom_stylesheet'] = "/" .$theOptions['custom_stylesheet'];
						} 
						else {
							$theOptions['custom_stylesheet'] = preg_replace("!^/+!", "/", $theOptions['custom_stylesheet']);
						} 
					}
					if (preg_match("!.+/+$!", $theOptions['custom_stylesheet']) == 1) {
						$theOptions['custom_stylesheet'] = preg_replace("!/+$!", "", $theOptions['custom_stylesheet']);
					}	
					if ($theOptions['custom_stylesheet'] == "") {
						$theOptions['custom_stylesheet'] = "/";
					}
				}
				
				if (isset($_POST['giveShortcodePriority'])) { $theOptions['give_shortcode_priority'] = $_POST['giveShortcodePriority']; }
				else { $theOptions['give_shortcode_priority'] = "false"; }
				
				if (isset($_POST['mp3foxEchoDebug'])) { $theOptions['echo_debug'] = $_POST['mp3foxEchoDebug']; } 
				else { $theOptions['echo_debug'] = "false"; }
				
				if (isset($_POST['mp3foxPluginVersion'])) { $theOptions['db_plugin_version'] = $_POST['mp3foxPluginVersion']; }
				
				if (isset($_POST['mp3foxAddTrackNumbers'])) { $theOptions['add_track_numbering'] = $_POST['mp3foxAddTrackNumbers']; } 
				else { $theOptions['add_track_numbering'] = "false"; }
				
				if (isset($_POST['mp3foxPlaylistRepeat'])) { $theOptions['playlist_repeat'] = $_POST['mp3foxPlaylistRepeat']; } 
				else { $theOptions['playlist_repeat'] = "false"; }
				
				update_option($this->adminOptionsName, $theOptions);
				
			?>
				<!-- Settings saved message -->
				<div class="updated"><p><strong><?php _e("Settings Updated.", "mp3Fox");?></strong></p></div>
			
			<?php 
			} 
			?>
			
			<div class="wrap">
				<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
					<div style="padding: 0px; margin: 0px 120px 0px 0px; border-bottom: 1px solid #ddd;">
						<h2 style="margin-top: 4px; margin-bottom: -6px;">Mp3<span style="font-size: 15px;"> - </span>jPlayer<span class="description" style="font-size: 10px;">&nbsp; (<?php echo $this->version_of_plugin; ?>)</span></h2>
					</div> 
					<p class="description" style="margin: 12px 120px 0px 0px;">Below are the global settings for the player, it 
						will automatically appear in any posts and pages that have a playlist or widget assigned. You can use the shortcode to over-ride some of these options.</p>
					<h4 class="description" style="margin-top: 5px; margin-bottom: 30px; font-weight:500"><a href="#howto">Help</a> | <a href="widgets.php">Widget settings</a></h4>
					 
					 <!-- Player -->
					<h3 style="margin-bottom: 0px;">Player</h3>
					<p style="margin-top: 10px; margin-bottom: 10px;">&nbsp; Initial volume &nbsp; <input type="text" style="text-align:right;" size="2" name="mp3foxVol" value="<?php echo $theOptions['initial_vol']; ?>" /> &nbsp; <span class="description">(0 - 100)</span></p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxAutoplay" value="true" <?php if ($theOptions['auto_play'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Autoplay</p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxPlaylistRepeat" value="true" <?php if ($theOptions['playlist_repeat'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Repeat</p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxAddTrackNumbers" value="true" <?php if ($theOptions['add_track_numbering'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Number the tracks</p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxShowPlaylist" value="true" <?php if ($theOptions['playlist_show'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Start with the playlist showing</p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxDownloadMp3" value="true" <?php if ($theOptions['show_downloadmp3'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Display a 'Download mp3' link</p>
					<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxAtoZ" value="true" <?php if ($theOptions['playlist_AtoZ'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Playlist the tracks in alphabetical order</p>
					<p style="margin-top: 0px; margin-bottom: 15px;">&nbsp; <input type="checkbox" name="mp3foxOnBlog" value="true" <?php if ($theOptions['player_onblog'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Show the player on the posts index page
						<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="description">(the player is added into the first post with a playlist, or may be set via widget)</span></p>
					
					<!-- Library -->
					<div style="margin: 0px 120px 0px 0px; border-bottom: 1px solid #eee; height: 15px;"></div>
					<h3 style="margin-top: 0px; margin-bottom: 4px;"><br />Library mp3's</h3>
					<p style="margin-bottom: 15px;">&nbsp; <input type="checkbox" name="mp3foxUseLibrary" value="true" <?php if ($theOptions['playlist_UseLibrary'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Always use Media Library titles and excerpts when they exist</p>
					
			<?php
			// create library file list //
			$library = $this->grab_library_info();
			echo "<p class=\"description\" style=\"margin: 0px 120px 6px 35px;\">Library contains <strong>" . $library['count'] . "</strong> mp3";
			if ( $library['count'] != 1 ) { echo "'s&nbsp;"; }
			else { echo "&nbsp;"; }
			
			if ( $library['count'] > 0 ) {
				echo "<a href=\"javascript:mp3jp_listtoggle('fox_library','files');\" id=\"fox_library-toggle\">Show files</a> | <a href=\"media-new.php\">Upload new</a>";
				echo "</p>";
				
				echo "<div id=\"fox_library-list\" style=\"display:none;\">\n";
				$liblist = '<p style="margin-left:35px;">';
				$br = '<br />';
				$tagclose = '</p>';
				$n = 1;
				foreach ( $library['filenames'] as $i => $file ) {
					$liblist .= "<a href=\"media.php?attachment_id=" . $library['postIDs'][$i] . "&amp;action=edit\" style=\"font-size:11px;\">[Edit]</a>&nbsp;&nbsp;" . $file . $br;
				}
				$liblist .= $tagclose;
				echo $liblist;
				echo '</div>';
			}
			else {
				echo "</p>";
			}
				
			// media settings page has moved in WP 3 //
			if ( substr(get_bloginfo('version'), 0, 1) > 2 ) { // if WP 3.x //
				$mediapagelink = get_bloginfo('wpurl') . "/wp-admin/options-media.php"; 
			}
			else {
				$mediapagelink = get_bloginfo('wpurl') . "/wp-admin/options-misc.php";
			}
			$upload_dir = wp_upload_dir();
			$localurl = get_bloginfo('url');
			$uploadsfolder = str_replace($localurl, "", $upload_dir['baseurl']); // is empty string only if library is empty //
			if ( $uploadsfolder != "" ) { 
				echo "<p class=\"description\" style=\"margin: 0px 120px 15px 33px;\">You only need to write filenames in your playlists to play mp3's from the library.
					<br />The Media Library uploads folder is currently set to <code>" .$uploadsfolder. "</code> , you can always <a href=\"" . $mediapagelink . "\">change it</a> without affecting any playlists.</p>";
			}
			?>
					<!-- Non-library -->
					<div style="margin: 0px 120px 0px 0px; border-bottom: 1px solid #eee; height: 15px;"></div>
					<h3 style="margin-top: 0px; margin-bottom: 15px;"><br />Non-Library mp3's</h3>
					<p class="description" style="margin: 0px 120px 0px 7px;">Set a folder for playing non-library mp3's from in the box 
						below, eg. <code>/music</code> or <code>www.anothersite.com/music</code><br />You 
						only need to write filenames in your playlists to play tracks from here.</p>
					<p style="margin-left:0px; margin-bottom:5px;">&nbsp; Default folder: &nbsp; <input type="text" style="width:385px;" name="mp3foxfolder" value="<?php echo $theOptions['mp3_dir']; ?>" /></p>
			
			<?php
			// create a file-list if directory is local (this still needs tidying, and should use grab_local_folder_mp3s!) //
			$rooturl = $_SERVER['HTTP_HOST'];
			$rooturl = str_replace("www.", "", $rooturl);
			//if ( preg_match("!^/!", $theOptions['mp3_dir']) || ($lp = strpos($theOptions['mp3_dir'], $rooturl)) ) {
			if ( ($lp = strpos($theOptions['mp3_dir'], $rooturl)) || preg_match("!^/!", $theOptions['mp3_dir']) ) {
				if ( $lp !== false ) {
					$folderpath = str_replace($rooturl, "", $theOptions['mp3_dir']);
					$folderpath =  str_replace("www.", "", $folderpath);
					$folderpath =  str_replace("http://", "", $folderpath);
				}
				else {
					$folderpath = $theOptions['mp3_dir'];
				}
				$path = $_SERVER['DOCUMENT_ROOT'] . $folderpath;
				if ($handle = @opendir($path)) {
					$j=0;
					while (false !== ($file = readdir($handle))) {
						if ( $file != '.' && $file != '..' && filetype($path.'/'.$file) == 'file' && preg_match("!\.mp3$!i", $file) ) {
							$items[$j++] = $file;
						}
					}
					$c = count($items);
					echo "<p class=\"description\" style=\"margin: 0px 0px 4px 112px;\">This folder contains <strong>" . $c . "</strong> mp3";
					if ( $c != 1 ) { echo "'s&nbsp;"; }
					else { echo "&nbsp;"; }
					
					if ( $c > 0 ) {
						echo "<a href=\"javascript:mp3jp_listtoggle('fox_folder','');\" id=\"fox_folder-toggle\">Show files</a></p>";
						echo "<div id=\"fox_folder-list\" style=\"display:none;\">\n<p style=\"margin-left:114px;\">";
						natcasesort($items);
						foreach ( $items as $i => $val ) {
							echo $val . "<br />";
						}
						echo "</p>\n</div>\n";
					}
					else {
						echo "</p>";
					}
					closedir($handle);
				}
				else {
					echo "<p class=\"description\" style=\"margin: 0px 0px 4px 112px;\">Unable to read or locate the folder <code>" . $folderpath . "</code> check the path and folder permissions</p>";
				}
			}
			else {
				echo "<p class=\"description\" style=\"margin: 0px 0px 4px 112px;\">No info is available on remote folders but you can play from here if you know the filenames</p>";
			}
			?>	
					<p style="margin-top: 20px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxAllowRemote" value="true" <?php if ($theOptions['allow_remoteMp3'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Allow mp3's from other domains on
						the player's playlists<br /><span class="description" style="margin-left:34px;">(unchecking this option doesn't affect mp3's playing from a remote default folder if one is set above)</span></p>
					<p style="margin-top: 0px; margin-bottom: 14px;">&nbsp; <input type="checkbox" name="mp3foxHideExtension" value="true" <?php if ($theOptions['hide_mp3extension'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Hide '.mp3' extension if a filename is displayed
						<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="description">(filenames are displayed when there's no available titles)</span></p>
					
					<!-- Style -->
					<div style="margin: 0px 120px 0px 0px; border-bottom: 1px solid #eee; height: 15px;"></div>
					<h3 style="margin-top: 0px; margin-bottom: 6px;"><br />Style</h3>
					<p style="margin-bottom: 0px; line-height:19px;">&nbsp; <input type="radio" name="mp3foxTheme" value="styleA" <?php if ($theOptions['player_theme'] == "styleA") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;&nbsp;Neutral colours<br />
							&nbsp; <input type="radio" name="mp3foxTheme" value="styleB" <?php if ($theOptions['player_theme'] == "styleB") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;&nbsp;Green<br />
							&nbsp; <input type="radio" name="mp3foxTheme" value="styleC" <?php if ($theOptions['player_theme'] == "styleC") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;&nbsp;Blue<br />
							&nbsp; <input type="radio" name="mp3foxTheme" value="styleE" <?php if ($theOptions['player_theme'] == "styleE") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;&nbsp;Text-based<br />
							&nbsp; <input type="radio" name="mp3foxTheme" value="styleD" <?php if ($theOptions['player_theme'] == "styleD") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;&nbsp;A custom CSS file:<br />
							<span style="margin-left:32px;"><input type="text"  style="width:465px;" name="mp3foxCustomStylesheet" value="<?php echo $theOptions['custom_stylesheet']; ?>" /></span></p>
					<p style="margin-top:10px; margin-bottom: 10px;">&nbsp; <input type="checkbox" name="mp3foxSmallPlayer" value="true" <?php if ($theOptions['use_small_player'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp; Use a small player</p>
					<p class="description" style="margin:0px 0px 14px 10px">(to enable a small player option with your custom css create a second stylesheet and append <code>-sidebar</code> to the filename eg. <code>mystyle.css</code> and <code>mystyle-sidebar.css</code>)</p>  
					
					<!-- Position -->
					<div style="margin: 0px 120px 0px 0px; border-bottom: 1px solid #eee; height: 15px;"></div>
					<h3 style="margin-top: 0px; margin-bottom: 6px;"><br />Position</h3>
					<p>&nbsp; Left &nbsp;<input type="radio" name="mp3foxFloat" value="left" <?php if ($theOptions['player_float'] == "left") { _e('checked="checked"', "mp3Fox"); }?> />&nbsp;&nbsp; 
						| &nbsp;&nbsp;<input type="radio" name="mp3foxFloat" value="right" <?php if ($theOptions['player_float'] == "right") { _e('checked="checked"', "mp3Fox"); }?> />&nbsp; Right
						<br /><span class="description">&nbsp; <strong>floated</strong>, content wraps around the player</span></p>
					<p>&nbsp; Left &nbsp;<input type="radio" name="mp3foxFloat" value="none" <?php if ($theOptions['player_float'] == "none") { _e('checked="checked"', "mp3Fox"); }?> />&nbsp;&nbsp;
						| &nbsp;&nbsp;<input type="radio" name="mp3foxFloat" value="rel-C" <?php if ($theOptions['player_float'] == "rel-C") { _e('checked="checked"', "mp3Fox"); }?> />&nbsp; Centre &nbsp;
						| &nbsp;&nbsp;<input type="radio" name="mp3foxFloat" value="rel-R" <?php if ($theOptions['player_float'] == "rel-R") { _e('checked="checked"', "mp3Fox"); }?> />&nbsp; Right
						<br /><span class="description">&nbsp; <strong>relative</strong>, content appears above/below the player</span></p>
					<p style="margin-top: 20px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="giveShortcodePriority" value="true" <?php if ($theOptions['give_shortcode_priority'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;Give shortcodes priority over widget</p>
					
					<!-- Template tools -->
					<div style="margin: 0px 120px 0px 0px; border-bottom: 1px solid #eee; height: 15px;"></div>
					<h3 style="margin-top: 0px; margin-bottom: 6px;"><br />Template tools
						<span style="font-size:11px;">&nbsp;<a href="javascript:mp3jp_listtoggle('fox_tools','');" id="fox_tools-toggle">Show</a></span></h3>
					<div id="fox_tools-list" style="display:none;">	
						<p class="description" style="margin: 0px 120px 15px 7px;">If you're developing a theme using the player's template-tags
							then these options can help out.</p>
						<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxEchoDebug" value="true" <?php if ($theOptions['echo_debug'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;Add debug output to the browser's page source view
							<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="description">(info appears in the page source view (CTRL+U on most browsers), and is not visible on the site)</span></p>
						<p style="margin-top: 0px; margin-bottom: 8px;">&nbsp; <input type="checkbox" name="mp3foxForceScripts" value="true" <?php if ($theOptions['force_scripts_from_admin'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;Enqueue player scripts on all site pages
							<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="description">(normally scripts are only requested when they're needed by a page or widget)</span></p>
						<p style="margin-bottom: 8px;">&nbsp; <input type="checkbox" name="disableTemplateTag" value="true" <?php if ($theOptions['disable_template_tag'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /> &nbsp;Ignore player template-tags in theme files
							<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span class="description">(this ignores the mp3j_addscripts(), mp3j_flag(), and mp3j_put() tag functions)</span></p>
					</div>	
					<input type="hidden" name="mp3foxPluginVersion" value="1.4.0" />
					<br /><br /><br />
					<p style="margin-top: 4px;"><input type="submit" name="update_mp3foxSettings" class="button-primary" value="<?php _e('Update Settings', 'mp3Fox') ?>" />
						&nbsp; Remember settings if plugin is deactivated &nbsp;<input type="checkbox" name="mp3foxRemember" value="true" <?php if ($theOptions['remember_settings'] == "true") { _e('checked="checked"', "mp3Fox"); }?> /></p>
				</form>
				
				<a name="howto"></a>
				<div style="margin: 20px 120px 0px 0px; border-top: 1px solid #aaa; height: 10px;"></div>
				<p style="margin: 0px 120px 0px 0px;">&nbsp;</p>
				<h3 style="margin: 0px 120px 0px 0px; color:#888;">Help</h3>
				<p class="description" style="margin: 10px 120px 12px 10px;">The plugin plays your mp3's by looking in the page/post custom fields
					for any playlist you have written. The player is added automatically when it picks up a playlist to play. You can also
					write a playlist straight into the widget, and use multiple widgets to set different playlists for different pages.</p>

				<h3 class="description" style="margin:0px 0px 2px 10px; color:#888;">Custom fields
					<span style="font-size:11px;font-weight:500;">&nbsp;<a href="javascript:mp3jp_listtoggle('fox_help1','');" id="fox_help1-toggle">Show help</a></span></h3>
				<div id="fox_help1-list" style="display:none;margin:10px 0px 0px 15px;">
					<p class="description" style="margin: 0px 120px 6px 10px;">You can use the custom fields  
						to enter a single mp3 per line with track number, title, and caption, or they can be used to play
						an entire local folder, the library, or in combination with the shortcode, to pick up the playlist from another post or page.</p>
					<p class="description" style="margin: 0px 120px 6px 10px;">If you use your Wordpress library or ftp your tracks
						to a main folder then you can play these tracks by writing just the filename in the playlist (the file extension
						can be ommited). You can set your default folder to a directory on a different domain if
						that's where you want to play from (you won't see a list of the filenames for remote folders so you'll need to know them).</p>
					<p class="description" style="margin: 0px 120px 6px 10px;">Enter full URI's for any other tracks you want to play.</p>
					<p class="description" style="margin: 0px 120px 6px 10px;"><br /><strong>Making a playlist</strong></p>
					<p class="description" style="margin: 10px 120px 10px 10px;">Add tracks on page/post edit screens using the custom fields (below the content box), as follows:</p> 
					<p class="description" style="margin: 0px 120px 10px 10px;">1. Enter <code>mp3</code> into the left hand box, this is the 'key' that the plugin looks for when reading the custom fields and you must always add it.
						<br />2. Write the filename/URI into the right hand box and hit 'add custom field'</p>
					<p class="description" style="margin: 0px 120px 10px 10px;">Repeat the above to add more mp3's and hit 'Update page' when you're done</p>
					<p class="description" style="margin: 20px 120px 5px 10px;"><strong>Adding a title and caption</strong></p>
					<p class="description" style="margin: 10px 120px 5px 10px;">1. Add a dot, then a caption in the left hand box, eg: <code>mp3.Caption</code><br />2. Add the title, then an '@' before the filename, eg: <code>Title@filename</code></p>
					<p class="description" style="margin: 10px 120px 5px 10px;">Captions get carried over to the next track automatically in some cases, to blank out a caption just add the dot like so <code>mp3.</code></p>
					
					<p class="description" style="margin: 20px 120px 5px 10px;"><strong>Ordering the tracks</strong></p>
					<p class="description" style="margin: 10px 120px 5px 10px;">Number the keys (the left boxes), eg:<code>1 mp3</code> will be first on the playlist. Un-numbered tracks appear below any numbered tracks.</p>
					<p class="description" style="margin: 20px 120px 5px 10px;"><strong>Playing a folder, the library, or another page's playlist</strong></p>
					<p class="description" style="margin: 10px 120px 10px 10px;">Use these special entries in the 'value' (right hand) box:</p>
					<p class="description" style="margin: 10px 120px 10px 10px;"><code>FEED:LIB</code> - Play entire library 
						<br /><code>FEED:DF</code> - Play the default folder 
						<br /><code>FEED:/mymusic</code> - Play the local folder 'mymusic' (folder paths must be local and are relative to the root of your site, NOT the Wordpress install)
						<br /><code>FEED:ID</code> - Play a list from a different page (used in conjunction with the shortcode which sets the id to pick up)</p>
					<br />
					
				</div>
				
				<h3 class="description" style="margin:0px 0px 2px 10px; color:#888;">Shortcode
					<span style="font-size:11px;font-weight:500;">&nbsp;<a href="javascript:mp3jp_listtoggle('fox_help2','');" id="fox_help2-toggle">Show help</a></span></h3>
				<div id="fox_help2-list" style="display:none;margin:15px 0px 0px 15px;">
					<p class="description" style="margin: 10px 120px 5px 10px;"><code>[mp3-jplayer]</code></p>
					<p class="description" style="margin: 10px 120px 5px 10px;">Use the shortcode to position the player in your content and to control
						various playback settings. It accepts the following parameters for individual control of player position/float, download link, autoplay, playlist mode, shuffle, page id, and random slice:</p>
					<p class="description" style="margin: 10px 120px 5px 10px;">
						<code>pos</code> - left, right, rel, rel-C, rel-R, absolute)<br />
						<code>dload</code> - true, false<br />
						<code>play</code> - true, false<br />
						<code>list</code> - open, closed, hidden, radio<br />
						<code>shuffle</code> - true<br />
						<code>slice</code> - (number of tracks to pick)<br />
						<code>id</code> - (a page ID) this is needed when using <code>FEED:ID</code> written in a custom field, the shortcode contains the ID to pick up a playlist from.</p>
					<p class="description" style="margin: 10px 120px 5px 10px;">eg. <code>[mp3-jplayer id=&quot;7&quot; dload=&quot;true&quot; shuffle=&quot;true&quot;]</code></p>
					<p class="description" style="margin: 10px 120px 5px 10px;">NOTE: If there's no playlist on the page the shortcode will not add the player</p>
					<br />
				</div>
				
				<h3 class="description" style="margin:0px 0px 2px 10px; color:#888;">Widget
					<span style="font-size:11px;font-weight:500;">&nbsp;<a href="javascript:mp3jp_listtoggle('fox_help3','');" id="fox_help3-toggle">Show help</a></span></h3>
				<div id="fox_help3-list" style="display:none;margin:0px 0px 0px 15px;">
					<p class="description" style="margin: 10px 120px 5px 10px;">Drag the player widget into one of your sidebars and set
						it's playback mode or write a playlist. Use the page filter to include-only or exclude any pages and posts. Once a widget is active
						then player addition into the content is bypassed, if you want a player in the content on some of your pages then tick
						the box 'Give shortcodes priority over widget' above in the Position settings, then you can use the shortcode to over-ride the widget.</p>
					<p class="description" style="margin: 10px 120px 5px 10px;">Note that the folder setting under mode 3 must be local and is a path from the root of the domain
						and not the Wordpress install. Leave it blank to play the default folder (if it's local).</p>
					<br />
				</div>
				
				<h3 class="description" style="margin:0px 0px 2px 10px; color:#888;">Tags
					<span style="font-size:11px;font-weight:500;">&nbsp;<a href="javascript:mp3jp_listtoggle('fox_help4','');" id="fox_help4-toggle">Show help</a></span></h3>
				<div id="fox_help4-list" style="display:none;margin:15px 0px 0px 15px;">
					<p class="description" style="margin: 10px 120px 5px 10px;">The following template tag functions can be used in your theme files:</p>
					<p class="description" style="margin: 10px 120px 3px 10px;"><code>mp3j_addscripts( $style )</code></p>
					<p class="description" style="margin: 0px 120px 3px 10px;"><code>mp3j_flag( $set )</code></p>
					<p class="description" style="margin: 0px 120px 3px 10px;"><code>mp3j_grab_library( $format )</code></p>
					<p class="description" style="margin: 0px 120px 3px 10px;"><code>mp3j_set_meta( $tracks, $captions )</code></p>
					<p class="description" style="margin: 0px 120px 3px 10px;"><code>mp3j_put( $id, $pos, $dload, $autoplay, $showplaylist )</code></p>
					<p class="description" style="margin: 0px 120px 14px 10px;"><code>mp3j_debug( $output )</code></p>
					<p class="description" style="margin: 0px 120px 5px 10px;">eg: <code>&lt;?php if ( function_exists( 'mp3j_put' ) ) { mp3j_put( 3, 'absolute', '', 'true' ); } ?&gt;</code></p>
					<?php
					echo '<p class="description" style="margin: 15px 120px 5px 10px;">Please see the <a href="' . get_bloginfo('wpurl') . '/wp-content/plugins/mp3-jplayer/template-tag-help.htm">Template tag help</a> for a detailed explaination of the tags.</p>';
					?>
					<br />
				</div>
				
				<div style="margin: 40px 120px 0px 0px; border-top: 1px solid #999; height: 30px;">
					<p class="description" style="margin: 0px 120px px 0px;"><a href="http://sjward.org/jplayer-for-wordpress">Plugin home page</a></p>
				</div>
				<br /><br /><br /><br />
			</div>
			
			<script type="text/javascript">
			<!--
			var fox_tog1 = false;
			var fox_tog2 = false;
			var fox_tog3 = false;
			var fox_tog4 = false;
			var fox_tog5 = false;
			var fox_tog6 = false;
			var fox_tog7 = false;
			var fox_tog8 = false;
			var fox_tognewstate;
			function mp3jp_listtoggle( id_base, label ) {
				if ( id_base == 'fox_tools' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog1, label );
					fox_tog1 = fox_tognewstate; 
				}
				if ( id_base == 'fox_library' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog2, label );
					fox_tog2 = fox_tognewstate; 
				}
				if ( id_base == 'fox_folder' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog3, label );
					fox_tog3 = fox_tognewstate; 
				}
				if ( id_base == 'fox_help1' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog4, label );
					fox_tog4 = fox_tognewstate; 
				}
				if ( id_base == 'fox_help2' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog5, label );
					fox_tog5 = fox_tognewstate; 
				}
				if ( id_base == 'fox_help3' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog6, label );
					fox_tog6 = fox_tognewstate; 
				}
				if ( id_base == 'fox_help4' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog7, label );
					fox_tog7 = fox_tognewstate; 
				}
				if ( id_base == 'fox_help5' ) { 
					fox_tognewstate = fox_runtoggle( id_base, fox_tog8, label );
					fox_tog8 = fox_tognewstate; 
				}
				return;
			}
			function fox_runtoggle( id_base, state, label ) {
				if (state == true) {
					jQuery("#"+id_base+"-list").fadeOut(300);
					jQuery("#"+id_base+"-toggle").empty();
					jQuery("#"+id_base+"-toggle").append('Show '+label);
					return false;
				}
				if (state == false) {
					jQuery("#"+id_base+"-list").fadeIn(300);
					jQuery("#"+id_base+"-toggle").empty();
					jQuery("#"+id_base+"-toggle").append('Hide '+label);
					return true;
				}			
			}
			//-->
			</script> 
		
		<?php
		}
	} //end class mp3Fox //
}


/**
 *	Extend the WP_Widget class available since WP2.8
 */
if ( class_exists("WP_Widget") )
{
	if ( !class_exists("MP3_jPlayer") )
	{
		class MP3_jPlayer extends WP_Widget
		{
	  
	   /**
		*	Set up widgets interface with admin.
		*	(function required by widgets API)
		*/
			function MP3_jPlayer() {
				
				$widget_ops = array( 'classname' => 'mp3jplayerwidget', 'description' => __('Drag the player into a widget area and set it\'s playback mode.', 'mp3jplayerwidget') );
				$control_ops = array( 'id_base' => 'mp3-jplayer-widget' );
				$this->WP_Widget( 'mp3-jplayer-widget', __('MP3-jPlayer', 'mp3jplayerwidget'), $widget_ops, $control_ops );
			}
		
		
	   /**
		*	Handles widget addition to the page, and builds the playlist depending on mode and settings.
		*	needs breaking out to smaller functions. 
		*
		*	(function required by widgets API)
		*/
			function widget( $args, $instance ) {
				
				global $mp3_fox;
				$mp3_fox->widget_runcount++;
				//if ( $mp3_fox->playerHasBeenSet == "true" || ($mp3_fox->tagflag == "true" && $mp3_fox->theSettings['disable_template_tag'] == "false") ) {
				if ( $mp3_fox->playerHasBeenSet == "true" ) {
					return;
				}
				if ( is_singular() ) { //run page filter on singulars //
					if ( $this->page_filter( $instance['restrict_list'], $instance['restrict_mode'] ) ) {
						return;
					}
				}
				if ( ((is_home() || is_archive()) && $mp3_fox->theSettings['player_onblog'] == "true") || is_singular() )
				{
					// MODE 1 - Auto-add, playing custom fields //
					// *******************************************
					if ( $instance['widget_mode'] == "1" ) {  
						if ( is_singular() && $mp3_fox->customFieldsGrabbed == "true" ) {
							$customvalues = $mp3_fox->postMetaValues;
							$customkeys = $mp3_fox->postMetaKeys;
						}
						elseif ( !is_singular() && !empty($mp3_fox->idfirstFound) ) {
							$mp3_fox->TT_grab_Custom_Meta($mp3_fox->idfirstFound);
							$customvalues = $mp3_fox->postMetaValues;
							$customkeys = $mp3_fox->postMetaKeys;
						}
						else {
							return;
						}
					}
					
					// MODE 2 - Play the arbitrary playlist //
					// ***************************************
					if ( $instance['widget_mode'] == "2" ) { 
						$playlist = trim( $instance['arb_playlist'] );
						$playlist = trim( $playlist, "," );
						if ( empty($playlist) ) {
							return;
						}				
						$tracks = explode( ",", $playlist );
						foreach ( $tracks as $i => $file ) {
							$tracks[$i] = trim($file);
						}
						$mp3_fox->feed_metadata( $tracks );
						$customvalues = $mp3_fox->feedValues;
						$customkeys = $mp3_fox->feedKeys;
					}
					
					// MODE 3 - Play ID and/or Library slice //
					// ****************************************
					if ( $instance['widget_mode'] == "3" ) { 
						$customvalues = array();
						$customkeys = array();
						// Create 1st array from id //
						if ( !empty($instance['id_to_play']) && $instance['play_page'] == "true" ) { 
							$id = trim($instance['id_to_play']);
							if ( $mp3_fox->TT_grab_Custom_Meta($id) > 0 ) {
								$customvalues = $mp3_fox->postMetaValues;
								$customkeys = $mp3_fox->postMetaKeys;
							}
						}
						// Create 2nd array from library //
						$customvaluesB = array();
						$customkeysB = array();
						if ( $instance['play_library'] == "true" ) { 
							if ( empty($mp3_fox->mp3LibraryI) ) { 
								$library = $mp3_fox->grab_library_info(); 
							}
							else { 
								$library = $mp3_fox->mp3LibraryI;
							}
							if ( $library['count'] >= 1 ) {
								$counter = count($customvalues);
								$mp3_fox->feed_metadata( $library['filenames'], '', ++$counter );
								$customvaluesB = $mp3_fox->feedValues;
								$customkeysB = $mp3_fox->feedKeys;
							}
						}
						foreach ( $customkeysB as $i => $v ) {
							array_push( $customvalues, $customvaluesB[$i] );
							array_push( $customkeys, $v );
						}
						// Create 3rd array from a local folder //
						$customvaluesC = array();
						$customkeysC = array();
						if ( $instance['play_folder'] == "true" ) { 
							if ( $instance['folder_to_play'] == "" ) {
								$folder = $mp3_fox->theSettings['mp3_dir'];
							}
							else {
								$folder = $instance['folder_to_play'];
							}
							$tracks = $mp3_fox->grab_local_folder_mp3s( $folder );
							if ( $tracks !== true && $tracks !== false && count($tracks) > 0 ) {
								$counter = count($customvalues);
								$mp3_fox->feed_metadata( $tracks, '', ++$counter );
								$customvaluesC = $mp3_fox->feedValues;
								$customkeysC = $mp3_fox->feedKeys;
								foreach ( $customkeysC as $i => $v ) {
									array_push( $customvalues, $customvaluesC[$i] );
									array_push( $customkeys, $v );
								}
							}
						}
						if ( ($n = count($customvalues)) < 1 ) {
							return;
						}
						
						// Take the random slice //
						$slicesize = trim($instance['slice_size']);
						if ( !empty($slicesize) && $slicesize > 0 ) {
							if ( $n > 1 ) {
								if ( $slicesize > $n ) {
									$slicesize = $n;
								}
								$picklist = array();
								for ( $i = 0; $i < $n; $i++ ) { // make a numbers array //
									$picklist[$i] = $i;
								} 
								shuffle( $picklist );
								$picklist = array_slice( $picklist, 0, $slicesize ); // take a shuffled slice //
								natsort( $picklist ); // reorder it //
								$j=0;
								foreach ( $picklist as $i => $num ) { // use it to pick the random tracks in order //
									$cv[$j] = $customvalues[$num];
									$ck[$j++] = $customkeys[$num];
								}
								unset($customvalues);
								unset($customkeys);
								$customvalues = $cv;	
								$customkeys = $ck;
							}
						}
					}
				}
				else {
					return;
				}
				
				// Build the playlist //
				$thePlayList = $mp3_fox->generate_playlist( $customkeys, $customvalues, 1 );
				if ( ($mp3_fox->countPlaylist = $thePlayList['count']) == 0 ) {
					return;
				}
				// Write js and html //
				if ( $instance['shuffle'] == "true" ) {
					if ( $thePlayList['count'] > 1 ) { shuffle( $thePlayList['order'] ); }
				}
				$pos = $mp3_fox->theSettings['player_float'];
				$dload = $instance['download_link'];
				$play = $mp3_fox->theSettings['auto_play'];
				
				$list = $instance['playlist_mode'];
				if ( $list == "radio" || $list == "hidden" || $list == "closed" ) {
					$mp3_fox->listDisplayMode = $list;
					$list = "false";
				}
				if ( $list == "open" ) { $list = "true"; }
				
				$mp3_fox->write_startup_vars( $thePlayList['count'], $play, $list );
				$mp3_fox->write_playlist( $thePlayList );
				$theplayer = $mp3_fox->write_player_html( $thePlayList['count'], $pos, $dload );
				
				extract( $args ); // wp supplied theme vars //
				echo $before_widget;
				if ( $instance['widget_title'] ) { echo $before_title . $instance['widget_title'] . $after_title; }
				echo $theplayer;
				echo $after_widget;
				$mp3_fox->playerHasBeenSet = "true";
				// Debug info //
				$mp3_fox->countPlaylist = $thePlayList['count'];
				$mp3_fox->PlayerPlaylist = $thePlayList;
				$mp3_fox->playerSetMethod = "Widget";
				$mp3_fox->playerAddedOnRun = $mp3_fox->widget_runcount;
			}
	   
	   
	   /**
		*	Update admin settings of the instance of the widget.
		*	(function required by widgets API)
		*/			
			function update( $new_instance, $old_instance ) {
				
				$instance = $old_instance;
				//$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
				$instance['widget_title'] = $new_instance['widget_title'];
				$instance['id_to_play'] = strip_tags( $new_instance['id_to_play'] );
				$instance['widget_mode'] = $new_instance['widget_mode'];
				$instance['shuffle'] = $new_instance['shuffle'];
				$instance['restrict_list'] = strip_tags( $new_instance['restrict_list'] );
				$instance['restrict_mode'] = $new_instance['restrict_mode'];
				$instance['play_library'] = $new_instance['play_library'];
				$instance['arb_playlist'] = strip_tags( $new_instance['arb_playlist'] );
				$instance['play_page'] = $new_instance['play_page'];
				$instance['slice_size'] = strip_tags( $new_instance['slice_size'] );
				$instance['play_folder'] = $new_instance['play_folder'];
				$instance['folder_to_play'] = strip_tags( $new_instance['folder_to_play'] );
				if ( strpos($instance['folder_to_play'], "http://") === false && strpos($instance['folder_to_play'], "www.") === false ) {
					if ( !empty($instance['folder_to_play']) ) {
						$instance['folder_to_play'] = trim($instance['folder_to_play']);
						if ( $instance['folder_to_play'] != "/" ) {
							$instance['folder_to_play'] = trim($instance['folder_to_play'], "/");
							$instance['folder_to_play'] = "/" . $instance['folder_to_play'];
						}
					}
				}
				$instance['download_link'] = $new_instance['download_link'];
				$instance['playlist_mode'] = $new_instance['playlist_mode'];
				return $instance;
			}

	   /**
		*	Create widget default settings and admin ui.
		*	(function required by widgets API)
		*/						
			function form( $instance ) {
				
				$defaultvalues = array(
									'widget_title' => '',
									'id_to_play' => '',
									'widget_mode' => '1',
									'shuffle' => 'false',
									'restrict_list' => '',
									'restrict_mode' => 'exclude',
									'play_library' => 'false',
									'arb_playlist' => '',
									'play_page' => 'false',
									'slice_size' => '',
									'play_folder' => 'false',
									'folder_to_play' => '',
									'download_link' => 'false',
									'playlist_mode' => 'open' );
				$instance = wp_parse_args( (array) $instance, $defaultvalues );
				?>
				
					<p style="text-align:right; font-size: 11px; margin-bottom:0px;"><a href="options-general.php?page=mp3jplayer.php">Plugin options</a> | <a href="options-general.php?page=mp3jplayer.php#howto">Help</a></p>
					
					<!-- Play Mode -->
					<p style="margin-top:-3px; margin-bottom:10px;">Play Mode</p>
					
					<!-- mode 1 -->
					<p style="margin-bottom: 2px;"><input type="radio" id="<?php echo $this->get_field_id( 'widget_mode' ); ?>" name="<?php echo $this->get_field_name( 'widget_mode' ); ?>" value="1" <?php if ($instance['widget_mode'] == "1") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;&nbsp;Mode 1 &nbsp;<span class="description" style="margin-left: 0px;">Play my custom fields</span></p>
					<p class="description" style="margin: 0px 0px 14px 25px; font-size: 11px;">Auto adds the player when there are tracks to play.</p>
					
					<!-- mode 2 -->	
					<div style="margin:0px 0px 0px 25px; border-top: 1px solid #eee; height: 10px;"></div>
					<p style="margin-top:2px; margin-bottom:2px;"><input type="radio" id="<?php echo $this->get_field_id( 'widget_mode' ); ?>" name="<?php echo $this->get_field_name( 'widget_mode' ); ?>" value="2" <?php if ($instance['widget_mode'] == "2") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;&nbsp;Mode 2 &nbsp;<span class="description" style="margin-left: 0px;">Play a fixed playlist</span></p>
					<p class="description" style="margin: 0px 0px 14px 25px; font-size: 11px;">Any filenames from the
						library and default folder, or full URI's:</p>
					<p style="margin-left:25px; margin-bottom:0px; font-size: 11px;"><textarea class="widefat" style="font-size:11px;" rows="5" cols="80" id="<?php echo $this->get_field_id( 'arb_playlist' ); ?>" name="<?php echo $this->get_field_name( 'arb_playlist' ); ?>"><?php echo $instance['arb_playlist']; ?></textarea></p>
					<p class="description" style="text-align:right; font-size:11px; margin-bottom: 10px;">(a comma separated list)</p>
					
					<!-- mode 3 -->
					<div style="margin: 0px 0px 0px 25px; border-top: 1px solid #eee; height: 10px;"></div>
					<p style="margin-top: 3px;margin-bottom: 10px;"><input type="radio" id="<?php echo $this->get_field_id( 'widget_mode' ); ?>" name="<?php echo $this->get_field_name( 'widget_mode' ); ?>" value="3" <?php if ($instance['widget_mode'] == "3") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;&nbsp;Mode 3 &nbsp;<span class="description" style="margin-left: 0px;">Generate a playlist</span></p>
					<p style="margin: 0px 0px 2px 25px; font-size: 11px;">
						<input type="checkbox" id="<?php echo $this->get_field_id( 'play_page' ); ?>" name="<?php echo $this->get_field_name( 'play_page' ); ?>" value="true" <?php if ($instance['play_page'] == "true") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;From page ID &nbsp;<input class="widefat" style="width:55px;" type="text" id="<?php echo $this->get_field_id( 'id_to_play' ); ?>" name="<?php echo $this->get_field_name( 'id_to_play' ); ?>" value="<?php echo $instance['id_to_play']; ?>" /></p>
					<p style="margin:0px 0px 1px 25px; font-size:11px;">
						<input type="checkbox" id="<?php echo $this->get_field_id( 'play_library' ); ?>" name="<?php echo $this->get_field_name( 'play_library' ); ?>" value="true" <?php if ($instance['play_library'] == "true") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;My library</p>
					
					<?php
					global $mp3_fox;
					$mp3_fox->theSettings = get_option('mp3FoxAdminOptions');
					if ( $instance['folder_to_play'] == "" ) { 
						$folder = $mp3_fox->theSettings['mp3_dir']; 
					}
					else { 
						$folder = $instance['folder_to_play']; 
					}
					$foldertracks = $mp3_fox->grab_local_folder_mp3s( $folder );
					if ( $foldertracks !== true && $foldertracks !== false ) {
						if ( ($c = count($foldertracks)) > 0 ) { 
							$style = "color:#282;";
							$txt = $c . "&nbsp;mp3";
							if ( $c != 1 ) { $txt .= "'s"; }
							$txt .= "&nbsp;in this folder";
						}
						else {
							$style = "color:#aaa;";
							$txt = "No mp3's here";
						}
					}
					elseif ( $foldertracks === true ) {
						$txt = "Check this path!";
						$style = "color:#e5c70f;";
					}
					else {
						$txt = "x Invalid or remote";
						$style = "color:#f56b0f;";
					}
					?>
					
					<p style="margin:0px 0px 0px 25px; font-size: 11px;">
						<input type="checkbox" id="<?php echo $this->get_field_id( 'play_folder' ); ?>" name="<?php echo $this->get_field_name( 'play_folder' ); ?>" value="true" <?php if ($instance['play_folder'] == "true") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						&nbsp;A folder: &nbsp;<input class="widefat" type="text" style="width:120px; margin-right:0px; font-size:11px;" id="<?php echo $this->get_field_id( 'folder_to_play' ); ?>" name="<?php echo $this->get_field_name( 'folder_to_play' ); ?>" value="<?php echo $instance['folder_to_play']; ?>" /></p>
					<p class="description" style="text-align:right; margin:0px 0px 4px 0px; font-size:10px; <?php echo $style; ?>"><?php echo $txt; ?></p>
					
					
					<p style="margin:0px 0px 15px 25px; font-size:11px;">
						Pick &nbsp;<input class="widefat" style="width:35px; text-align:right;" type="text" id="<?php echo $this->get_field_id( 'slice_size' ); ?>" name="<?php echo $this->get_field_name( 'slice_size' ); ?>" value="<?php echo $instance['slice_size']; ?>" />&nbsp; track(s)</p>				
					
					<!-- Other Settings -->
					<div style="margin: 0px 0px 12px 0px; border-top: 1px solid #eee; border-bottom: 1px solid #eee;">
						<p style="font-size: 11px;margin: 10px 0px 2px 0px;">
							<input type="checkbox" id="<?php echo $this->get_field_id( 'shuffle' ); ?>" name="<?php echo $this->get_field_name( 'shuffle' ); ?>" value="true" <?php if ($instance['shuffle'] == "true") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
							&nbsp;Shuffle</p>
						<p style="font-size: 11px;margin: 0px 0px 6px 0px;">
							<input type="checkbox" id="<?php echo $this->get_field_id( 'download_link' ); ?>" name="<?php echo $this->get_field_name( 'download_link' ); ?>" value="true" <?php if ($instance['download_link'] == "true") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
							&nbsp;Download link</p>
						
						
						<p style="margin:0px 0px 12px 0px; font-size:11px;">Playlist&nbsp;
							<select id="<?php echo $this->get_field_id( 'playlist_mode' ); ?>" name="<?php echo $this->get_field_name( 'playlist_mode' ); ?>" class="widefat" style="width:90px; font-size:11px;">
								<option value="open" <?php if ( 'open' == $instance['playlist_mode'] ) { echo 'selected="selected"'; } ?>>Open</option>
								<option value="closed" <?php if ( 'closed' == $instance['playlist_mode'] ) { echo 'selected="selected"'; } ?>>Closed</option>
								<option value="hidden" <?php if ( 'hidden' == $instance['playlist_mode'] ) { echo 'selected="selected"'; } ?>>Hidden</option>
								<option value="radio" <?php if ( 'radio' == $instance['playlist_mode'] ) { echo 'selected="selected"'; } ?>>Radio</option>
							</select>
						</p>
					</div>
					
					<!-- Page Filter -->
					<p style="margin-top:0px; margin-bottom: 0px;">Page Filter</p>
					<p style="font-size: 11px; margin:12px 0px 8px 0px;">
						Include <input type="radio" id="<?php echo $this->get_field_id( 'restrict_mode' ); ?>" name="<?php echo $this->get_field_name( 'restrict_mode' ); ?>" value="include" <?php if ($instance['restrict_mode'] == "include") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						or <input type="radio" id="<?php echo $this->get_field_id( 'restrict_mode' ); ?>" name="<?php echo $this->get_field_name( 'restrict_mode' ); ?>" value="exclude" <?php if ($instance['restrict_mode'] == "exclude") { _e('checked="checked"', "mp3jplayerwidget"); }?> />
						Exclude</p>
					<p style="font-size: 11px; margin-bottom: 0px;"><input class="widefat" style="font-size:11px;" type="text" id="<?php echo $this->get_field_id( 'restrict_list' ); ?>" name="<?php echo $this->get_field_name( 'restrict_list' ); ?>" value="<?php echo $instance['restrict_list']; ?>" /></p>
					<p class="description" style="text-align:right; font-size:11px; margin-bottom: 0px;">(a comma separated list of post ID's)</p>
					<p class="description" style="font-size:11px; margin-top:8px; margin-bottom:1px;">Set to Include and write 'index' for a posts index only player.</p> 
					<div style="margin: 0px 0px 0px 0px; border-bottom: 1px solid #eee; height: 10px;"></div>
					
					<!-- Widget Heading -->
					<p style="margin: 10px 0px 7px 0px;">Widget Heading:</p>
					<p style="margin: 0px 0px 10px 0px;"><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>" /></p>
					
				<?php	
			}
			
			
	   /**
		*	Checks current page id against widget page-filter settings.
		*	returns true if page should be filtered.
		*/	
			function page_filter( $list, $mode ) {
				
				if ( !empty($list) ) {
					$pagelist = explode( ",", $list );
					if ( !empty($pagelist) ) {
						foreach ( $pagelist as $i => $id ) {
							$pagelist[$i] = str_replace( " ", "", $id );
						}
					}
					global $post;
					$thisID = $post->ID;
					if ( $mode == "include" ) {
						foreach ( $pagelist as $i => $id ) {
							if ( $id != $thisID ) {
								return true;
							}
						}
					}
					if ( $mode == "exclude" ) {
						foreach ( $pagelist as $i => $id ) {
							if ( $id == $thisID ) {
								return true;
							}
						}
					}
				}
				return false;
			}
		} //end class MP3_jPlayer //
	}
}


// Create plugin class instance //
if ( class_exists("mp3Fox") ) {
	$mp3_fox = new mp3Fox();
}

if ( isset($mp3_fox) ) {

	// Initialize main admin page //
	if ( !function_exists("mp3Fox_ap") ) {
		
		function mp3Fox_ap() {
			global $mp3_fox;
			if ( !isset($mp3_fox) ) {
				return;
			}
			if ( function_exists('add_options_page') ) {
				add_options_page('MP3 jPlayer', 'MP3 jPlayer', 9, basename(__FILE__), array(&$mp3_fox, 'printAdminPage'));
			}
		}
	}
	
	// Initialize mp3j template tags //
	function mp3j_put( $id = "", $pos = "", $dload = "", $play = "", $list = "" ) {
		do_action( 'mp3j_put', $id, $pos, $dload, $play, $list );
	}
	
	function mp3j_flag( $set = 1 ) {
		do_action('mp3j_flag', $set);
	}
	
	function mp3j_addscripts( $style = "" ) {
		do_action('mp3j_addscripts', $style);
	}
	
	function mp3j_debug( $display = "" ) {
		do_action('mp3j_debug', $display);
	}
	
	function mp3j_grab_library( $format = 1 ) { 
		$thereturn = array();
		if ( $format == 1 ) {
			$library = apply_filters('mp3j_grab_library', $thereturn );
			return $library;
		}
		if ( $format == 0 ) {
			$library = apply_filters('mp3j_grab_library_wp', $thereturn );
			return $library;
		}
		else {
			return;
		}
	}
	
	function mp3j_set_meta( $tracks, $captions = "", $startnum = 1 ) {
		if ( empty($tracks) || !is_array($tracks) ) {
			return;
		}  
		do_action('mp3j_set_meta', $tracks, $captions, $startnum);
	}
	
	// Initialize widget //
	function mp3jplayer_widget_init() {
		register_widget( 'MP3_jPlayer' );
	}
	
	// add hook calls //
	// admin // 
	add_action('activate_mp3-jplayer/mp3jplayer.php',  array(&$mp3_fox, 'initFox'));
	add_action('deactivate_mp3-jplayer/mp3jplayer.php',  array(&$mp3_fox, 'uninitFox'));
	add_action('admin_menu', 'mp3Fox_ap');
	// template //
	add_action('wp_head', array(&$mp3_fox, 'check_if_scripts_needed'), 2);
	add_filter('the_content', array(&$mp3_fox, 'add_player'));
	add_action('wp_footer', array(&$mp3_fox, 'debug_print_handler'));
	add_shortcode('mp3-jplayer', array(&$mp3_fox, 'shortcode_handler'));
	add_action('mp3j_put', array(&$mp3_fox, 'template_tag_handler'), 10, 5 );
	add_action('mp3j_flag', array(&$mp3_fox, 'flag_tag_handler'), 10, 1 );
	add_action('mp3j_addscripts', array(&$mp3_fox, 'scripts_tag_handler'), 1, 1 );
	add_action('mp3j_debug', array(&$mp3_fox, 'debug_info'), 10, 1 );	
	add_filter('mp3j_grab_library', array(&$mp3_fox, 'grablibrary_handler'), 10, 1 );
	add_filter('mp3j_grab_library_wp', array(&$mp3_fox, 'grablibraryWP_handler'), 10, 1 );
	add_action('mp3j_set_meta', array(&$mp3_fox, 'feed_metadata'), 10, 3 );
	// widget //	
	add_action( 'widgets_init', 'mp3jplayer_widget_init' );
}
?>