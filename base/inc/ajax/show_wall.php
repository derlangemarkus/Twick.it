<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

$userId = getArrayElement($_GET, "user");
$newId = getArrayElement($_GET, "new");
$me = getUser();

$posts = WallPost::fetchByUserId($userId);
if($posts) {
	?><table id="wall_table"><?php
	foreach($posts as $post) {
		if($post->isDeleted() || $post->getParentId()) {
			continue;
		}
		$author = $post->findAuthor();
		$children = $post->findChildren();
		?>
		<tr id="post<?php echo($post->getId()) ?>" <?php if($post->getId() == $newId) { ?>style="display:none;"<?php } ?>>
			<th valign="top" <?php if($me || sizeof($children)) { ?>rowspan="2"<?php } ?>><a href="<?php echo($author->getUrl()) ?>"><?php echo($author->getAvatar(64)) ?></a></th>
			<td valign="top" class="post">
				<a name="<?php echo($post->getId()) ?>"></a>
				<b><?php echo htmlspecialchars($author->getDisplayName()) ?>:</b>
                <?php if($post->isDeletable()) { ?><a href="javascript:;" onclick="deletePost(<?php echo($post->getId()) ?>)" class="post_link" title="<?php loc('wall.post.delete') ?>"><img src="html/img/icon_DeleteObject_on.gif" width="10" height="10" alt="x"></a><?php } ?>
				<a href="interfaces/rss/wall_post.php?id=<?php echo($post->getId()) ?>" class="post_link"><img src="html/img/rss.gif" width="10" height="10" title="RSS" alt="RSS"></a><br />
				<?php echo(nl2br(insertAutoLinks(htmlspecialchars($post->getMessage())))) ?>
				<small><a id="postdate<?php echo($post->getId()) ?>" href="javascript:;" onclick="postPermalink(<?php echo($post->getId()) ?>)"><?php echo(convertRelativeDate($post->getCreationDate(), "d.m.Y - H:i")) ?></a></small><br />
			</td>
		</tr>
        <?php if($me || sizeof($children)) { ?>
		<tr id="follow<?php echo($post->getId()) ?>" <?php if($post->getId() == $newId) { ?>style="display:none;"<?php } ?>>
			<td valign="top">
				<?php 
				foreach($children as $child) {
                    if($child->isDeleted()) {
                        continue;
                    }
					$author = $child->findAuthor();
				?>
					<a href="<?php echo($author->getUrl()) ?>"><?php echo($author->getAvatar(32, 'float:left;')) ?></a>
					<div class="comment" id="post<?php echo($child->getId()) ?>">
						<a name="<?php echo($child->getId()) ?>"></a>
						<b><?php echo htmlspecialchars($author->getDisplayName()) ?>:</b>
                        <?php if($child->isDeletable()) { ?><a href="javascript:;" onclick="deletePost(<?php echo($child->getId()) ?>)" class="post_link" title="<?php loc('wall.post.delete') ?>"><img src="html/img/icon_DeleteObject_on.gif" width="10" height="10" alt="x"></a><?php } ?><br />
						<?php echo(nl2br(insertAutoLinks(htmlspecialchars($child->getMessage())))) ?>
						<small><a id="postdate<?php echo($child->getId()) ?>" href="javascript:;" onclick="postPermalink(<?php echo($child->getId()) ?>)"><?php echo(convertRelativeDate($child->getCreationDate(), "d.m.Y - H:i")) ?></a></small><br />
					</div>
					<div class="spacer"></div>
				<?php 
				} 
				
				if($me) { 
				?>
				<form action="">
					<input type="text" id="dummy<?php echo($post->getId()) ?>" value="<?php loc('wall.post.writeComment') ?>" onfocus="showComment(<?php echo($post->getId()) ?>)"/>
					<div id="commentbox<?php echo($post->getId()) ?>" style="display:none;">
						<?php echo($me->getAvatar(32, 'float:left;')) ?><textarea id="comment<?php echo($post->getId()) ?>" onblur="hideComment(<?php echo($post->getId()) ?>)"></textarea><br style="clear:both;"/>
						<a href="javascript:;" onclick="sendComment(<?php echo($post->getId()) ?>)" class="teaser-link" id="sendCommentLink"><img width="15" height="9" src="html/img/pfeil_weiss.gif"><?php loc('wall.post.send') ?></a>
						<img src='html/img/ajax-loader.gif' style="display:none;width:16px;height:11px;float:right;" id="sendCommentLinkWait"/>  
					</div>
				</form>
				<?php 
				}
				?>
			</td>
		</tr>
		<?php
        }
        ?>
        <tr>
            <td colspan="2" style="background-color:transparent;height:10px;"></td>
        </tr>
        <?php
	}
	echo("</table>");
	
	if($newId) { 
		?>
		<script type="text/javascript">
		$("post<?php echo($newId) ?>").appear();
		if($("follow<?php echo($newId) ?>") != null) {
			$("follow<?php echo($newId) ?>").appear();
		}
		</script>
		<?php
	}
} else {
	
    ?><div style="margin:20px;font-size:22px;line-height:34px;">
    <?php loc('wall.post.empty'); ?><br />
	<?php 
	if(!$me) { 
		$user = User::fetchById($userId);
	?>
		<br />
		<?php loc('wall.post.empty.login', $user->getLogin()); ?><br />
	<?php 
	}
	?>
    </div><?php
}
?>