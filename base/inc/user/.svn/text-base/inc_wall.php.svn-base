<style type="text/css">
#wall_message{width:490px;height:64px;vertical-align:top;margin:0px 0px 10px 0px;overflow:auto;}
#wall_table{padding:20px;width:600px;}
#wall_table th{width:64px;background-color:#EEE;}
#wall_table td{background-color:#FFF;padding:3px 5px 3px 5px;}
#wall_table td b{font-size:13px;}
#wall_table td small a{float:right;font-size:9px;color:#888;}
#wall_table td small a:hover{text-decoration:underline;}
#wall_table td input{width:471px;color:#CCC;margin:6px 0px 10px 0px;height:16px;}
#wall_table td textarea{width:435px;height:100px;vertical-align:top;margin:0px 0px 7px 10px;overflow:auto;}
#wall_table td div.comment{width:444px;float:left;margin-left:4px;}
#wall_table td div.spacer{clear:both;display:block;width:477px;height:1px;background-color:#CCC;margin-bottom:10px;}
#wall_table a.post_link{float:right;margin:0px 2px 0px 2px;display:none;}
#wall_table td:hover a.post_link{display:block;}
td.post{display:block;min-height:58px;}
</style>

<?php if($user->getEnableWall()) { ?>
	<?php if($me) { ?>
	<form action="#" style="padding:20px;" onsubmit="return false">
		<a href="<?php echo($me->getUrl()) ?>"><?php echo($me->getAvatar(64)) ?></a>
		<textarea name="message" id="wall_message" onfocus="enlargeWallMessageField(true)" onblur="enlargeWallMessageField(false)"></textarea>
		<a href="javascript:;" onclick="sendPost()" class="teaser-link" id="sendPostLink"><img width="15" height="9" src="html/img/pfeil_weiss.gif"><?php loc('wall.post.send') ?></a>
		<img src='html/img/ajax-loader.gif' style="display:none;width:16px;height:11px;float:right;" id="sendPostLinkWait"/>  
	</form>
	<div class="clearbox">&nbsp;</div>
	<?php } ?>
	<div id="wall_posts"><img src='html/img/ajax-loader.gif' style="margin:20px 0px 0px 250px;width:16px;height:11px;" /> <?php loc('core.pleaseWait') ?>...</div>
<?php } else { ?>
	<div style="margin:20px;font-size:22px;line-height:34px;">
    <?php loc('wall.post.disabled', $user->getLogin()); ?><br />
	<br />
	<a href='write_message.php?receiver=<?php echo($user->getLogin()) ?>'class="teaser-link"><img width="15" height="9" src="html/img/pfeil_weiss.gif"><?php loc('wall.post.writeMessage') ?></a>
	</div>
<?php } ?>
	
<script type="text/javascript">
function updateWall(inNewId) {
	new Ajax.Updater(
		'wall_posts', 
		'inc/ajax/show_wall.php?user=<?php echo($user->getId()) ?>&new=' + inNewId,
		{
            evalScripts: true,
            onComplete: function() {
				
				if(inNewId != 0) {
					window.setTimeout("scrollToPost(" + inNewId + ", false)", 600);
				} else if(window.location.hash != "") {
                    var hash = window.location.hash.substr(1);
                    window.setTimeout("scrollToPost(" + hash + ", true)", 600);
				}
            }
        }
	);
}
updateWall(0);

function scrollToPost(inId, inColor) {
	if(inColor) {
		$('post' + inId).style.color='#FFFFFF';
		$('post' + inId).style.backgroundColor='#6B8F00';
		$('postdate' + inId).style.color='#FFFFFF';

        new Effect.Morph($('post' + inId), {style:'background-color:#fff; color:#666;', duration:5});
        new Effect.Morph($('postdate' + inId), {style:'color:#666;', duration:5});
	}
	Effect.ScrollTo('post' + inId, { duration:'1.5', offset:-20});
}

function postPermalink(inId) {
	doPopup('<?php loc('wall.permalink.text1') ?>: <br /><input style="width:100%" type="text" value="<?php echo($user->getUrl()) ?>/wall#' + inId + '" onfocus="this.select()" /><br /><br /><?php loc('wall.permalink.text2') ?><br /><br />', "<?php loc('wall.permalink.title') ?>");
}

<?php 
if($twickId = getArrayElement($_GET, "twick")) { 
	$twick = Twick::fetchById($twickId);
?>
$("wall_message").update("<?php loc('message.write.twick', '&quot;' . $twick->getTitle() . '&quot; (' . $twick->getUrl() . ')') ?> ");
$("wall_message").focus();
<?php 
} 

if($me) { 
?>
function enlargeWallMessageField(inLarge) {
	if(inLarge) {
		new Effect.Morph($("wall_message"), {style:'height:120px;', duration:0.3});
	} else if($("wall_message").value.trim() == "") {
		new Effect.Morph($("wall_message"), {style:'height:64px;', duration:0.2});
	}
}

function sendPost() {
	var post = $("wall_message").value.trim();
	if(post != "") {
		$("sendPostLink").hide();
		$("sendPostLinkWait").show();
		new Ajax.Request("action/save_wall_post.php", {
			method: 'post',
			parameters: 'user=<?php echo($user->getId()) ?>&post=' + encodeURIComponent(post) + "&secret=<?php echo(urlencode($me->getSecret())) ?>",
			onSuccess: function(transport) {
				updateWall(transport.responseText);
				$("sendPostLinkWait").hide();
				$("sendPostLink").show();
			}
		});
	}
	$("wall_message").value = "";
	enlargeWallMessageField(false);
}

function sendComment(inId) {
	var post = $("comment" + inId).value.trim();
	if(post != "") {
		$("sendCommentLink").hide();
		$("sendCommentLinkWait").show();
		new Ajax.Request("action/save_wall_post.php", {
			method: 'post',
			parameters: 'user=<?php echo($user->getId()) ?>&post=' + encodeURIComponent(post) + "&secret=<?php echo(urlencode($me->getSecret())) ?>&parent=" + inId,
			onSuccess: function(transport) {
				updateWall(transport.responseText);
			}
		});
	}
}

function deletePost(inId) {
	var ok = confirm("<?php loc("core.areYouSure") ?>");
	if(ok) {
		new Ajax.Request("action/delete_wall_post.php", {
			method: 'post',
			parameters: 'id=' + inId + "&secret=<?php echo(urlencode($me->getSecret())) ?>",
			onSuccess: function() {
				updateWall(0);
			}
		});
	}
}

function showComment(inId) {
	$('dummy' + inId).hide();
	$('commentbox' + inId).show();
	$('comment' + inId).focus();
}
function hideComment(inId) {
	if($('comment' + inId).value.trim() == "") {
		$('commentbox' + inId).hide();
		$('dummy' + inId).show();
	}
}
<?php } ?>
</script>