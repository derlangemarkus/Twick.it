<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php"); 

if (!isAdmin()) {
	setDBCacheTimeout(3600); // 1 Std
}

$activeTab = "user";
$LIMIT = 7*13;
$users = User::fetchAll(false, false, array("LIMIT"=>$LIMIT+1));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('users.title') ?> | <?php loc('core.titleClaim') ?></title>
	<meta property="og:title" content="<?php loc('users.title') ?>" />
    <meta name="description" content="<?php loc('users.title') ?> | <?php loc('core.titleClaim') ?>" />   
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS - <?php loc('rss.latestUsers') ?>" href="interfaces/rss/latest_users.php?lng=<?php echo(getLanguage()) ?>" />
	<?php include("inc/inc_global_header.php"); ?>
	<script type="text/javascript">
	<!--
	var suggestUserTimeouts;
	var prevUserSearch;
    var userSuggestRequest = null;
    var userSuggestIndex = -1;
    var userSuggestLength = -1;
    
	function updateUserSuggest() {
		if(suggestUserTimeouts != null) {
			clearTimeout(suggestUserTimeouts); 
			suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 250);
		} else {
			suggestUserTimeouts=window.setTimeout("_updateUserSuggest()", 0);
		}
	}
	
	
	function _updateUserSuggest() {
		var search = document.userSearchForm.username.value;
		if (search != prevUserSearch) {
            userSuggestIndex = -1;
			if (search.length > 0) {
				var url = "<?php echo(HTTP_ROOT) ?>/interfaces/api/find_user.php?type=json&limit=13&search=" + search;
			
				if (userSuggestRequest != null) {
                    userSuggestRequest.abort();
                }
                userSuggestRequest = new Ajax.Request(url, {
					method: 'get',
				  	onSuccess: function(transport) {
				    	var suggests = transport.responseText.evalJSON(true);
                        userSuggestLength = suggests.users.length;
                        var query = suggests.query.toQueryParams().search;
				    	if (suggests.users.length == 0) {
				    		$('userSearchSuggest').update("<i><?php loc('users.search.noUserFound') ?></i>");
							$('userSearchSuggestBox').fade({duration: 3});
						} else {
							var suggestText = "";
					    	for (var i=0; i<suggests.users.length; i++) {
					    		if(i>=12) {
						    		suggestText += "<li style='color:#FFFFFF;'>...</li>";
                                    break;
						    	} else {
                                    var title = suggests.users[i].display_name;
                                    var regex = eval("/(" + query + ")/gi");
                                    title = title.replace(regex, "<span>$1</span>");

					    			suggestText += "<li><a href='" + suggests.users[i].url + "' id='userSearchSuggest" + i + "'>" + title + "</a></li>";
					    		}
					    	}
					    	$('userSearchSuggest').update(suggestText);
					    	$('userSearchSuggestBox').show();
					    }
				  	}	
				});
			} else {
				$('userSearchSuggestBox').hide();
			}
			prevUserSearch = search;			
		}
	}

    function userSearchUpDown(inEvent) {
        var code; //variable to save keystroke
        if (!inEvent) var inEvent = window.event;
        if (inEvent.keyCode) code = inEvent.keyCode;

        if (code == 38) {
            if (userSuggestIndex > 0) {
                updateUserSuggestIndex(false);
                userSuggestIndex--;
                title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
                $("user-search").value = title.replace(/ \(.+\)/g, "");
                prevUserSearch = title;
            }
        } else if (code == 40) {
            if (userSuggestIndex < userSuggestLength-1) {
                updateUserSuggestIndex(true);
                userSuggestIndex++;
                title = $("userSearchSuggest" + userSuggestIndex).innerHTML.replace(/<span>(.+?)<\/span>/gi, "$1");
                $("user-search").value = title.replace(/ \(.+\)/g, "");
                prevUserSearch = title;
            }
        } else {
            updateUserSuggest();
        }
    }

    function updateUserSuggestIndex(inDown) {
        var nextIndex = inDown ? userSuggestIndex+1 : userSuggestIndex-1;
        if (userSuggestIndex >= 0) {
            $("userSearchSuggest" + userSuggestIndex).style.fontWeight="normal";
            $("userSearchSuggest" + userSuggestIndex).style.fontSize="12px";
        }
        $("userSearchSuggest" + nextIndex).style.fontWeight="bold";
        $("userSearchSuggest" + nextIndex).style.fontSize="14px";
    }
	//-->
	</script>
</head>
<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
    		<h1><?php loc('users.headline') ?></h1>
   		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<!-- Kasten | START -->
				<div class="blog-kasten">
					<div class="blog-head"><h1><?php loc('users.count', UserInfo::findNumberOfUsers(true)) ?></h1></div>
					<div class="blog-body" id="users" style="width:500px;padding-right:0px;">
						<div class="dummy-container">
						<?php 
						$counter = 0;
						foreach($users as $aUser) {
							$counter++;
							if ($counter <= $LIMIT) { 
							?><a href="<?php echo($aUser->getUrl()) ?>"><img src='<?php echo($aUser->getAvatarUrl(38)) ?>' alt='<?php echo htmlspecialchars($aUser->getDisplayName()) ?>' title='<?php echo htmlspecialchars($aUser->getDisplayName()) ?>: <?php echo($aUser->getRatingSumCached()) ?>' style='width:38px;height:38px;float:left;' /></a><?php
							}
							flush();
						} 
						?>
						</div>
					</div>
					<div class="blog-footer">
					<br />
                    <a id="usersMoreLink" style="margin-right:77px;margin-top:-7px;" href="javascript:;" onclick="showMore('users', '', <?php echo($LIMIT) ?>);"><img alt="" src="html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('core.more') ?></a>
                        <img alt="..."  src="<?php echo(STATIC_ROOT) ?>/html/img/ajax-loader.gif" id="usersMoreLinkWait" style="display:none;float:right;margin-right:77px;margin-top:-7px" width="16" height="11"/>
					</div>
					<script type="text/javascript">
						showMore('users', '', <?php echo($LIMIT) ?>);
					</script>
				</div>
				<!-- Kasten | ENDE -->
				
				<?php if (false && $counter > $LIMIT) { ?>
				<div class="haupt-buttonfeld">
                    <a id="usersMoreLink" href="javascript:;" onclick="showMore('users', '', <?php echo($LIMIT) ?>);">Mehr</a>
                    <img alt="..." src="html/img/ajax-loader.gif" id="usersMoreLinkWait" style="display:none"/>
                </div>
				<?php } ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<?php 
				resetDBCacheTimeout();
				if($user = User::fetchById(getUserId())) { 
				?>
				<!-- Eigener User | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('users.you.title') ?></h2></div>
			        <div class="teaser-body">
			        	<p>
                            <div class="bilderrahmen-klein"><a href="<?php echo($user->getUrl()) ?>"><img alt="" src="<?php echo($user->getAvatarUrl(40)) ?>" border="0" width="40" height="40" style="width:40px; height: 40px;" id="randomTwickGravatar"/></a></div>
			        		<?php loc('users.you.info', array($user->getRatingSumCached(), $user->findRatingPosition())) ?>
			        	</p>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Eigener User | ENDE -->
			    <?php 
			    } 
			    setDBCacheTimeout(43200); // 12 Std
			    ?>  
			
			    <!-- Suche | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('users.search.title') ?></h2></div>
			        <div class="teaser-body">
			        	<form action="action/find_user.php" method="get" name="userSearchForm" id="userSearchForm">
							<label><?php loc('users.search.username') ?>:</label>
							<input type="text" name="username" onblur="$('userSearchSuggestBox').fade({duration: 2});" autocomplete="off" id="user-search" onfocus="this.select();"/><br />
							<div id="userSearchSuggestBox" style="display:none;">
								<ul id="userSearchSuggest"></ul>
							</div>
							<?php
							if($notFound = getArrayElement($_GET, "notFound")) { 
								drillDown(_loc('users.search.noUser', $notFound));
							?>
							<br /><b style="color:#F00"><?php loc('users.search.noUser', $notFound) ?></b>
							<?php 
							} 
							?>
							<br />
                            <a href="javascript:;" onclick="$('userSearchForm').submit();" class="teaser-link"><img alt="" src="html/img/pfeil_weiss.gif" width="15" height="9"/><?php loc('users.search.button') ?></a><br />
                            <script type="text/javascript">
                            $("user-search").onkeyup = userSearchUpDown;
                            </script>
						</form>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Suche | ENDE -->  
			    
			    
			    <!-- Aktiv | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('users.active.title') ?></h2></div>
			        <div class="teaser-body nopadding">
			        	<ul>
			                <?php 
			                foreach(UserInfo::fetchMostActiveUsers(6) as $userInfo) {
                                if(in_array($userInfo->getId(), array(1,2,705))) {
                                    continue;
                                }
								?><li><img alt="" src="<?php echo($userInfo->getAvatarUrl(40)) ?>" class="userfoto" style="width:40px;height:40px;"/><a href="<?php echo($userInfo->getUrl()) ?>"><?php loc('users.active.info', array(htmlspecialchars($userInfo->getDisplayName()), $userInfo->getTwickCount())) ?></a></li><?php
			                } 
							?>
			            </ul>
			            <div class="clearbox"></div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Aktiv | ENDE -->  
			    
				<?php include(DOCUMENT_ROOT . "/inc/inc_bookmarks.php") ?>        
			
			<br />
		</div>
		<!-- Rechte Haelfte | ENDE -->
		
		<div class="clearbox"></div>
	</div>
	<!-- Content-Bereich | ENDE -->
</div>
<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

<!--[if IE]>
<script type="text/javascript" src="html/js/png.js"></script>
<![endif]-->
</body>
</html>