<style type="text/css">
.user_menu {
    padding:10px;
}

.user_menu a, .user_menu #user_tagcloud{
    background-color: #FFF;
    float:left;
    display:block;
    width:265px;
    height:220px;
    margin:11px;
    text-align: center;
    font-size:28px;
	padding-top:40px;
	border:1px solid #CCC;
}

.user_menu #user_tagcloud{
	padding-top:20px;
	height:240px;
}

.user_menu #user_tagcloud a {
    display:inline;
	width:auto;
	height:auto;
	padding:0px;
	text-align:left;
	margin:0px;
	box-shadow:none;
	-moz-box-shadow:none;
	-webkit-box-shadow:none;
}

.user_menu a:hover {
	box-shadow:0 0 10px #7B9F10;
	-moz-box-shadow:0 0 10px #7B9F10;
	-webkit-box-shadow:0 0 10px #7B9F10;
}

.user_menu a img{
    width:100px;
    height:100px;
    padding:15px;
}

.user_menu img.profile {
    border-radius:50px;
    -moz-border-radius:50px;
    -webkit-border-radius:50px;
}

</style>
<div class="user_menu">
    <?php if(getUserId() == $user->getId()) { ?>
    <a href="<?php echo(HTTP_ROOT) ?>/user_data.php">
        <img src="html/img/user/profil.png" /><br />
        <?php loc('user.overview.profile') ?>
    </a>

    <a href="<?php echo($user->getUrl()) ?>/alerts">
        <img src="html/img/user/radar.png" /><br />
        <?php loc('user.overview.alerts') ?>
    </a>
    <?php } ?>
    <?php if(getUserId() == $user->getId()) { ?>
    <a href="<?php echo(HTTP_ROOT) ?>/show_messages.php">
        <img src="html/img/user/nachrichten.png" /><br />
        <?php loc('user.overview.messages') ?>
    </a>
    <?php } else { ?>
    <a href="<?php echo(HTTP_ROOT) ?>/write_message.php?receiver=<?php echo($user->getLogin()) ?>">
        <img src="html/img/user/nachrichten.png" /><br />
        <?php loc('user.overview.message') ?>
    </a>
    <?php } ?>

    <a href="<?php echo($user->getUrl()) ?>/wall">
        <img src="html/img/user/quasselecke.png" /><br />
        <?php loc('user.overview.wall') ?>
    </a>

    <a href="<?php echo($user->getUrl()) ?>/twicks">
        <img src="html/img/user/twicks.png" /><br />
        <?php loc('user.overview.twicks') ?>
    </a>

    <a href="<?php echo($user->getUrl()) ?>/favorites">
        <img src="html/img/user/favoriten.png" /><br />
        <?php loc('user.overview.favs') ?>
    </a>
</div>
	<br style="clear:both;"/>
	<br />
