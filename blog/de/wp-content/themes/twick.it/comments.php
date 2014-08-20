<?php
/**
 * @package WordPress
 * @subpackage Classic_Theme
 */
?>
<div class="textcontent">
	<h2 id="comments"><a name="comments"></a><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></h2>
</div>

<?php if ($comments) { ?>
	<?php foreach ($comments as $comment) { ?>
		<a name="comment<?php comment_ID() ?>"></a>
		<!-- EINGABE-Sprechblase | START -->
		<div class="sprechblase" id="comment-<?php comment_ID() ?>">
	    	<br />
			<div class="sprechblase-main">
				<div class="sprechblase-links"><i><?php comment_type(_c('Comment'), __('Trackback'), __('Pingback')); ?></i>
		            <div class="bilderrahmen"><?php 
		            	if ($comment->comment_type == "pingback" || $comment->comment_type == "trackback") {
		            		echo("<img src='" . User::getDefaultAvatarUrl() . "' />");
		            	} else {
		            		echo get_avatar($comment, 64); 
		            	}
		            ?></div>
		            <i><?php comment_author_link() ?></i>
		      	</div>
		        <div class="sprechblase-rechts">
		        	<div class="blase-header" id="eingabeblase-head" style="height:36px;"></div>
		            <div class="blase-body" style="padding-left:20px;width:330px;">
		            	<?php comment_text() ?>
	  				</div>
		            <div class="blase-footer" id="eingabeblase-footer"><?php comment_date() ?><?php edit_comment_link(__("Edit This"), ' | '); ?></div>
		        </div>
		        <div class="clearbox">&nbsp;</div>
		    </div>
		</div>
		<!-- EINGABE-Sprechblase | ENDE -->
		
	
	<?php } ?>
<?php } ?>

<?php if (comments_open()) { ?>
	<br />
	<div class="textcontent">
		<h2><?php _e('Leave a comment'); ?></h2>
	</div>
	
	<?php if ($user = getUser()) { ?>
	<div class="sprechblase">
	    <div class="sprechblase-main">
	        <div class="sprechblase-links">
	            <div class="bilderrahmen" ><a href="<?php echo $user->getUrl() ?>"><?php echo $user->getAvatar(64) ?></a></div>
	            <i><?php echo $user->getLogin() ?></i>
	        </div>
	        <div class="sprechblase-rechts">
	            <div class="blase-header" id="eingabeblase-head">&nbsp;</div>
	            <div class="blase-body">
	                <form class="eingabeblase" id="twickit-blase" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" name="twickForm">
                    	<input type="hidden" name="author" id="author" value="<?php echo $user->getLogin() ?>"  />
						<input type="hidden" name="email" id="email" value="<?php echo $user->getMail() ?>" />
						<input type="hidden" name="url" id="url" value="<?php echo $user->getLink() ?>" />
						
						<label for="comment"><?php _e('Comment'); ?> <?php if ($req) _e('(required)'); ?></label>
						<textarea name="comment" id="comment" cols="70" rows="15"></textarea>
						
						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
						
						<?php do_action('comment_form', $post->ID); ?>
	                </form>    
	            </div>
	            <div class="blase-footer" id="eingabeblase-footer">
	            	<a href="javascript:;" onclick="$('twickit-blase').submit();" id="twickit"><?php _e('Submit Comment')?></a>
	            </div>
	        </div>
	        <div class="clearbox">&nbsp;</div>
	    </div>
	</div>
	<?php } else { ?>
	<div class="sprechblase">
	    <div class="sprechblase-main">
	        <div class="sprechblase-links">
	        	<i>&nbsp;</i>
	            <div class="bilderrahmen" ><img src="html/img/avatar.jpg" alt="" /></div>
	        </div>
	        <div class="sprechblase-rechts">
	            <div class="blase-header" id="eingabeblase-head">&nbsp;</div>
	            <div class="blase-body">
	                <form class="eingabeblase" id="twickit-blase" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" name="twickForm">
	                    <label for="author"><?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></label>
						<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" />
						
						<label for="email"><?php _e('Mail (will not be published)');?> <?php if ($req) _e('(required)'); ?></label>
						<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
						
						<label for="url"><?php _e('Website'); ?></label>
						<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
						
						<label for="comment"><?php _e('Comment'); ?></label>
						<textarea name="comment" id="comment" cols="70" rows="15" tabindex="4"></textarea>
						
						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
						
						<?php do_action('comment_form', $post->ID); ?>
	                </form>    
	            </div>
	            <div class="blase-footer" id="eingabeblase-footer">
	            	<a href="javascript:;" onclick="$('twickit-blase').submit();" id="twickit"><?php _e('Submit Comment')?></a>
	            </div>
	        </div>
	        <div class="clearbox">&nbsp;</div>
	    </div>
	</div>
	<?php } ?>

<?php } else { // Comments are closed ?>
<div class="textcontent"><?php _e('Sorry, the comment form is closed at this time.'); ?></div>
<?php } ; ?>
