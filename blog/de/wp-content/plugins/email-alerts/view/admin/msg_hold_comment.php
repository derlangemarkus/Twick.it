<?php echo $subscriber_name; ?>,<br /><br />

<?php 
	// ===== COMMENT =====
	if ('comment' == $comment_type) { ?>
<?php echo sprintf( __( 'There is a comment on <a href="%2$s">"%1$s"</a> awaiting approval.', 'email-alerts' ), $post->post_title, get_permalink($comment->comment_post_ID) ); ?><br /><br />
<?php echo sprintf( __( 'Author: %1$s (%2$s , %3$s)', 'email-alerts' ), $comment->comment_author, $comment->comment_author_email, $comment_author_domain ); ?><br />
<?php echo sprintf( __( 'URL: <a href="%1$s">%1$s</a>', 'email-alerts' ), $comment->comment_author_url ); ?><br />
<?php _e('Comment: '); ?><br /><br />
<?php echo $comment_as_html; ?><br /><br />
<?php
	// ===== TRACKBACK =====
	} elseif ('trackback' == $comment_type) {	
?>
<?php echo sprintf( __( 'There is a new trackback pending approval <a href="%2$s">"%1$s"</a>', 'email-alerts' ), $post->post_title, get_permalink($comment->comment_post_ID)  ); ?><br />
<?php echo sprintf( __( 'Website: %1$s (IP: %2$s , %3$s)', 'email-alerts' ), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ); ?><br />
<?php echo sprintf( __( 'URL: <a href="%1$s">%1$s</a>', 'email-alerts' ), $comment->comment_author_url ); ?><br />
<?php _e( 'Excerpt: ', 'email-alerts' ); ?><br /><br />
<?php echo $comment_as_html; ?><br /><br />
<?php echo sprintf( __( '[%1$s] Trackback: "%2$s"', 'email-alerts' ), 
	$blogname, $post->post_title ); ?>

<?php
	// ===== PINGBACK =====
	} elseif ('pingback' == $comment_type) {
?>
<?php echo sprintf( __( 'There is a new pingback pending approval. The pingback is on <a href="%2$s">"%1$s"</a>', 'email-alerts' ), $post->post_title, get_permalink($comment->comment_post_ID)  ); ?><br />
<?php echo sprintf( __( 'Website: %1$s (IP: %2$s , %3$s)', 'email-alerts' ), $comment->comment_author, $comment->comment_author_IP, $comment_author_domain ); ?><br />
<?php echo sprintf( __( 'URL: <a href="%1$s">%1$s</a>', 'email-alerts' ), $comment->comment_author_url ); ?><br />
<?php _e( 'Excerpt: ', 'email-alerts' ); ?><br /><br />
<?php echo sprintf( __( '[...] %s [...]', 'email-alerts' ), $comment_as_html ); ?><br /><br />
<?php echo sprintf( __( '[%1$s] Pingback: "%2$s"', 'email-alerts'), $blogname, $post->post_title ); ?>
<?php
	}
?>

<?php echo sprintf( __( '<a href="http://ws.arin.net/cgi-bin/whois.pl?queryinput=%1$s">Lookup IP</a>', 'email-alerts'), $comment->comment_author_IP ); ?><br /><br />
<?php echo sprintf( __( '<a href="%s">Delete</a>', 'email-alerts' ), get_option('siteurl')."/wp-admin/comment.php?action=cdc&c=".$comment->comment_ID ) . " | "; ?>
<?php echo sprintf( __( '<a href="%s">Spam</a>', 'email-alerts' ), get_option('siteurl')."/wp-admin/comment.php?action=cdc&dt=spam&c=".$comment->comment_ID ) . " | "; ?>
<?php echo sprintf( __( '<a href="%s">Edit</a>', 'email-alerts' ), get_option('siteurl')."/wp-admin/comment.php?action=editcomment&c=".$comment->comment_ID ) ; ?><br />

<?php if ( isset( $acting_admin_name ) ) echo sprintf( __( 'Unapproved by: %1$s (%2$s)', 'email-alerts'  ), $acting_admin_name, $acting_admin_email ); ?>

<p><small><?php _e( '(Email Alerts plugin)', 'email-alerts' ); ?></small></p>