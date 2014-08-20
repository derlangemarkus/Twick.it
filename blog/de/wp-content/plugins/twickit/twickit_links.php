<?php
/*
Plugin Name: Twick.it Links
Plugin URI: http://twick.it/interfaces/blogs/wordpress/twickit_links/
Description: Insert Twick.it links into wordpress posts and comments.
Version: 1.4.2
Author: Markus Möller
Author URI: http://twick.it/user/derlangemarkus
*/
if (!class_exists('TwickitLinksAdmin')) {

	class TwickitLinksAdmin {

		var $twickit_links_db_version = "1.3.1";

		function activate() {
			global $wpdb;
		   	$table_name = TwickitLinksAdmin::_getCacheTable();
		   	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		      	$sql = "CREATE TABLE " . $table_name . " (
			  				url text NOT NULL,
							xml text NOT NULL,
							time bigint(11) DEFAULT '0' NOT NULL
					    );";

		      	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		      	dbDelta($sql);

		      	//add_option("twickit_link_db_version", $this->twickit_links_db_version);
		   	}
		}


		function wpHead() {
            ?>
            <!-- Twick.it - Start -->
            <script type="text/javascript" src="http://static.twick.it/interfaces/js/bubble.js" id="twickit_bubble_js"></script>
            <script type="text/javascript" src="http://static.twick.it/interfaces/js/autolink/twickit.js" id="twickit_bubble_js"></script>
            <script type="text/javascript">
                function wpTwickitLinkInit(inId, inBubble) {
                    TwickitAutolink.observe(
                        document.getElementById(inId),
                        "mouseover",
                        function(inEvent) {
                            var target = inEvent.relatedTarget || inEvent.toElement;
                            if(target.id.indexOf("twicktip") != -1) {
                                return;
                            }
                            var pos = TwickitAutolink.getRect(document.getElementById(inId));
                            tempX = pos.left;
                            tempY = pos.top + pos.height/2;
                            if(document.getElementById("wpadminbar")) {
								tempY += 30;
							}
                            document.getElementById(inId).title = "";
                            TwickitBubble.open(tempX, tempY, "twickit");
                            TwickitBubble.fill(inBubble);
                            TwickitAutolink.observe(
                                document.getElementById("twicktip"),
                                "mouseout",
                                function(inEvent) {
                                    var target = inEvent.relatedTarget || inEvent.toElement;
                                    if(!target || target.id.indexOf("twicktip") == -1 && target.parentNode.id.indexOf("twicktip") == -1 && target.parentNode.parentNode.id.indexOf("twicktip") == -1) {
                                        document.getElementById("twicktip").style.display = "none";
                                    }
                                }
                            );
                        }
                    );

                    TwickitAutolink.observe(
                        document.getElementById(inId),
                        "mouseout",
                        function(inEvent) {
                            var target = inEvent.relatedTarget || inEvent.toElement;
                            if(target.id.indexOf("twicktip") == -1) {
                                document.getElementById("twicktip").style.display = "none";
                            }
                        }
                    );
                }
            </script>
            <?php
            $options = get_option('TwickitLinks');
			if ($options["markerpopup"]) {
                $style = $options["markerpopupcustom"] ? "?theme=custom" :"";
                ?><script type="text/javascript" src="http://twick.it/interfaces/js/popup/twickit.js<?php echo($style) ?>"></script><?php
            }
            ?>
			<!-- Twick.it - End -->
			<?php
		}


		function addConfigPage() {
			global $wpdb;
			if (function_exists('add_submenu_page') ) {
				add_options_page('TwickitLinks Config', 'Twick.it Links', 10, basename(__FILE__),array('TwickitLinksAdmin','showConfigPage'));
				add_filter('plugin_action_links', array('TwickitLinksAdmin', 'getConfigLinkForPlugin'), 10, 2);
				add_filter('ozh_adminmenu_icon', array('TwickitLinksAdmin', 'getOzhIcon'));
			}
		}


		function getOzhIcon($inHook) {
			static $twickitIcon;
			if (!$twickitIcon) {
				$twickitIcon = WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)). '/icon.png';
			}
			if ($inHook == 'twickit_links.php') return $twickitIcon;
			return $inHook;
		}


		function getConfigLinkForPlugin($inLinks, $inFile){
			//Static so we don't call plugin_basename on every plugin row.
			static $this_plugin;
			if (!$this_plugin ) {
				$this_plugin = plugin_basename(__FILE__);
			}

			if ($inFile == $this_plugin ){
				$settings_link = '<a href="options-general.php?page=twickit_links.php">' . __('Settings') . '</a>';
				array_unshift($inLinks, $settings_link); // before other links
			}
			return $inLinks;
		}


		function showConfigPage() {
			global $wpdb;
			if (isset($_POST['submit'])) {
				if (!current_user_can('manage_options')) die(__('You cannot edit the Twick.it options.'));
				check_admin_referer('twickitlinks-updatesettings');

				if (isset($_POST['twickitlinkstarget'])) {
					$options['target'] = $_POST['twickitlinkstarget'];
				}
				if (isset($_POST['twickitlinkscommenttarget'])) {
					$options['target_comments'] = $_POST['twickitlinkscommenttarget'];
				}
				$options['comments'] = isset($_POST['twickitlinkscomment']);
				$options['markerpopup'] = isset($_POST['twickitlinksmarkerpopup']);
				$options['markerpopupcustom'] = isset($_POST['twickitlinksmarkerpopupcustom']);
				if (isset($_POST['twickitlinkslanguage'])) {
					$options['language'] = $_POST['twickitlinkslanguage'];
				}
				if (isset($_POST['twickitlinksseparator'])) {
					$options['separator'] = $_POST['twickitlinksseparator'];
				}

				update_option('TwickitLinks', $options);
			} else if (isset($_POST['clearcache'])) {
				$wpdb->query($wpdb->prepare("TRUNCATE " . TwickitLinksAdmin::_getCacheTable()));
			}


			$options  = get_option('TwickitLinks');
			?>
			<div class="wrap">
				<h2><?php echo __('Twick.it Links Configuration', 'twickit') ?></h2>
				<form action="" method="post" id="twickitlinks-conf">
					<?php if (function_exists('wp_nonce_field')) { wp_nonce_field('twickitlinks-updatesettings'); } ?>

					<table class="form-table">
						<tr>
							<td colspan="2"><h3><?php echo __('[twickit]-Links', 'twickit') ?></h3></td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinkstarget"><?php echo __('Default target in posts', 'twickit') ?>:</label>
							</td>
							<td>
								<input size="10" type="text" id="twickitlinkstarget" name="twickitlinkstarget" value="<?php echo $options['target'];?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinkscommenttarget"><?php echo __('Default target in comments', 'twickit') ?>:</label>
							</td>
							<td>
								<input size="10" type="text" id="twickitlinkscommenttarget" name="twickitlinkscommenttarget" value="<?php echo $options['target_comments'];?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinkscomment"><?php echo __('Allow Twick.it Links in comments', 'twickit') ?>:</label>
							</td>
							<td>
								<input type="checkbox" id="twickitlinkscomment" name="twickitlinkscomment" <?php if($options['comments']) echo("checked='checked'"); ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinkslanguage"><?php echo __('Language code', 'twickit') ?>:</label>
							</td>
							<td>
								<input size="10" type="text" id="twickitlinkslanguage" name="twickitlinkslanguage" value="<?php echo $options['language'];?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinksseparator"><?php echo __('Separator between Twicks', 'twickit') ?>:</label>
							</td>
							<td>
								<input size="10" type="text" id="twickitlinksseparator" name="twickitlinksseparator" value="<?php echo isset($options['separator']) ? $options['separator'] : " | ";?>"/>
							</td>
						</tr>
						<tr>
							<td colspan="2"><br /><h3><?php echo __('Twick.it-Marker-Popup', 'twickit') ?></h3></td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinksmarkerpopup"><?php echo __('Enable Twick.it-Marker-Popup', 'twickit') ?>:</label>
							</td>
							<td>
								<input type="checkbox" id="twickitlinksmarkerpopup" name="twickitlinksmarkerpopup" <?php if($options['markerpopup']) echo("checked='checked'"); ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								<label for="twickitlinksmarkerpopup"><?php echo __('Use custom style sheet', 'twickit') ?>:</label>
							</td>
							<td>
								<input type="checkbox" id="twickitlinksmarkerpopupcustom" name="twickitlinksmarkerpopupcustom" <?php if($options['markerpopupcustom']) echo("checked='checked'"); ?>"/>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<span class="submit"><input type="submit" name="submit" value="<?php echo __('Update Settings', 'twickit') ?> &raquo;" /></span>
							</td>
						</tr>
						<tr>
							<td colspan="2"><br /><h3><?php echo __('Cache') ?></h3></td>
						</tr>
						<tr>
							<td colspan="2"><?php echo($wpdb->get_var("SELECT COUNT(*) FROM " . TwickitLinksAdmin::_getCacheTable())) ?> <?php echo __('items in cache', 'twickit') ?>.</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<span class="submit"><input type="submit" name="clearcache" value="<?php echo __('Clear cache', 'twickit') ?> &raquo;" /></span>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<?php
		}


		function link($inAtts, $inContent=null) {
			$exactly = $inAtts["word"];
			$atts = shortcode_atts(array("target"=>"", "word"=>$inContent, "language"=>$options["language"]), $inAtts);
			$options = get_option('TwickitLinks');
			return TwickitLinksAdmin::_addLink($inContent, $atts["word"], $atts["target"], $atts["language"], $exactly);
		}


		function linkAll($inAtts, $inContent=null) {
			$result = "";
			$atts = shortcode_atts(array("target"=>""), $inAtts);
			$options = get_option('TwickitLinks');

			foreach(preg_split('/\b/', $inContent, -1, PREG_SPLIT_DELIM_CAPTURE) as $word) {
				$result .= TwickitLinksAdmin::_addLink($word, $word, $atts["target"], $options["language"], false);
			}
			return $result;
		}


		function linkComment($inText="") {
			$text = $inText;
			$options = get_option('TwickitLinks');
			if ($options["comments"]) {

				preg_match_all('/\[twickit.*\](.+)\[\/twickit\]/', $text, $matches);
				if($matches) {
					for($i=0; $i<sizeof($matches); $i++) {
						$text =
							str_replace(
								$matches[0][$i],
								TwickitLinksAdmin::_addLink(
									$matches[1][$i],
									$matches[1][$i],
									$options["target_comments"],
									$options["language"]
								),
								$text
							);
					}
				}
			}
			return $text;
		}


		function _addLink($inContent, $inTerm, $inTarget="", $inLanguage="", $inExactly=false) {
			$options = get_option('TwickitLinks');

			$target = $inTarget ? $inTarget : $options["target"];
			$language = $inLanguage=="" ? "" : "&lng=$inLanguage";
			$pipe = isset($options["separator"]) ? $options["separator"] : " | ";

			if (trim($inTerm) != "") {
				try {
					$url = "http://twick.it/interfaces/api/explain.xml?search=" . urlencode(strip_tags($inTerm)) . $language;
					if ($inExactly) {
						$url .= "&skipHomonyms=1";
					}

					global $wpdb;
					$xml = $wpdb->get_var("SELECT xml FROM " . TwickitLinksAdmin::_getCacheTable() . " WHERE url='$url' AND time>=" . (time()-60*60*12));
					if (!$xml) {
						$xml = TwickitLinksAdmin::_getTwickitContent($url);
						$wpdb->query("INSERT INTO " . TwickitLinksAdmin::_getCacheTable() . " (url, xml, time) VALUES ('$url', '" . mysql_real_escape_string($xml) ."', '" . time() . "')");
					}
	//				echo($url);
					$xml = @simplexml_load_string($xml);
					if ($xml && $xml->topics->children()) {
						$topics = $xml->topics->children();
						$multiple = sizeof($topics) > 1;

						$firstTopic = $topics[0];
						$url = str_replace("'", "%27", $firstTopic->url);

						$bubble = "";
                        $tooltip = "";
						$separator = "";
						foreach($topics as $topic) {
							$text = str_replace("'", "&#27;", $topic->twicks->twick->text);
							if ($url) {
                                $title = $topic->title;
                                $geo = $topic->geo;
								$tooltip .= $separator;
								if ($multiple) {
									$tooltip .= $title . ": ";
								}
								$tooltip .= $text;
								$separator = $pipe;

                                $bubble .= "<a href='$url' target='$target' class='twick'>" . htmlspecialchars($title) . "</a>";
                                if($geo->latitude != "") {
                                    $bubble .= "&nbsp;<a href='http://maps.google.de/maps?z=12&q=" . $geo->latitude . "," . $geo->longitude . "' target='_blank'><img src='http://static.twick.it/html/img/world.png' class='twicktip_geo'/></a>";
                                }
                                $bubble .= "<br />" . htmlspecialchars($text) . "<br />";
							}
						}


                        $id = "dummy" . microtime() . rand(0, 1000);
						$output = "<a href='$url' target='$target' rel='glossary' title='$tooltip' class='wp_twickit_link' id='$id'>$inContent</a>";
                        $output .= '
                            <script type="text/javascript">
                            wpTwickitLinkInit("' . $id . '", "' . $bubble . '");
                            </script>
                        ';
                        return $output;
					}
				} catch (Exception $ignored) {}
			}
			return $inContent;
		}


		function _getCacheTable() {
			global $wpdb;
		   	return $wpdb->prefix . "twickit_link_cache";
		}


		function _getTwickitContent($inUrl) {
			$host = "twick.it";
		    $fp = fsockopen($host, 80, $errno, $errstr, 10);
		    if (!$fp) {
		        return "";
		    } else {
		    	$content = "";
		        fputs ($fp, "GET $inUrl HTTP/1.0\r\nHost: $host\r\n\r\n");
		        while (!feof($fp)) {
		        	$content .= fgets ($fp, 1024);
		        }
		        fclose ($fp);

		        return trim(array_pop(preg_split("/^\\s*$/m", $content, 2)));
		    }
		}
	}
}


// load language file
$locale = get_locale();
$mofile = trailingslashit(WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__))).'language/twickit-'.$locale.'.mo';
load_textdomain('twickit', $mofile);

register_activation_hook(__FILE__, array('TwickitLinksAdmin', 'activate'));
add_action('wp_head', array('TwickitLinksAdmin', 'wpHead'));
add_action('admin_menu', array('TwickitLinksAdmin', 'addConfigPage'));
add_shortcode('twickit', array('TwickitLinksAdmin', 'link'));
add_shortcode('twickitall', array('TwickitLinksAdmin', 'linkAll'));
add_shortcode('twickit_all', array('TwickitLinksAdmin', 'linkAll'));
add_filter('comment_text', array('TwickitLinksAdmin', 'linkComment'));
?>