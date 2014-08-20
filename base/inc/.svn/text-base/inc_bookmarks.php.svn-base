<?php 
if(!$url) {
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; 
}
?>
<div class="bookmark-leiste" style="margin-left:25px;">
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo($url) ?>" data-count="horizontal" data-via="TwickIt" data-related="twickit_<?php echo(getLanguage()) ?>" data-lang="<?php echo(getLanguage()) ?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<div style="padding-top:2px;margin-left:-15px;width:65px;display:inline-block;float:left;"><g:plusone size="small"></g:plusone></div>
	<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode($url); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=400&amp;font=arial" scrolling="no" frameborder="0" style="border:none;overflow:hidden;width:80px;height:20px;" allowTransparency="true"></iframe>
</div>        