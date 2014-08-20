<?php echo $subscriber_name; ?>,<br /><br />

<?php echo sprintf( __( 'A comment by %2$s (%3$s) on <a href="%5$s">"%4$s"</a> has been published on %1$s.', 'email-alerts' ), 
	$blog_name, $comment_author_name, $comment_author_email, $post->post_title, get_permalink($comment->comment_post_ID) ); ?><br /><br />
	
<?php echo sprintf( __( '<a href="%1$s">View the comment</a>.', 'email-alerts' ), $comment_url ); ?><br /><br />

<?php if ( isset( $acting_admin_name ) ) echo sprintf( __( 'Approved by: %1$s (%2$s)', 'email-alerts' ), $acting_admin_name, $acting_admin_email ); ?>

<p><small><?php _e( '(Email Alerts plugin)', 'email-alerts' ); ?></small></p>