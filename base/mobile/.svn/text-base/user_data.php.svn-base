<?php
require_once("inc.php");
checkLogin();

$error = getArrayElement($_GET, "error");
$title = _loc("mobile.user_data.title");

$user = getUser();


include("inc/header.php");
?>
<div class="class_content">
    <h1><?php loc("mobile.user_data.title") ?></h1>
    <?php if ($error) { ?>
        <div style="background-color:#F00;color:#FFF;font-weight:bold;padding:10px;"><?php loc($error) ?></div>
    <?php } ?>
    <form action="action/save_user_data.php" method="post" id="loginform">
        <label for="login"><?php loc('userdata.username') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
        <input type="text" name="login" value="<?php echo($user->getLogin()) ?>"/>
        <div id="checkLogin"></div>

        <label for="mail"><?php loc('userdata.email') ?> <span> (<?php loc('userdata.required') ?>) - <?php loc('userdata.email.noSpam') ?></span></label>
        <input type="text" name="mail" value="<?php echo($user->getMail()) ?>"/>
        <div id="checkMail"></div>

        <label for="password"><?php loc('userdata.password') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
        <input type="password" name="password" value=""/>
        <div id="checkPassword"></div>

        <label for="password2"><?php loc('userdata.password2') ?> <span>(<?php loc('userdata.required') ?>)</span>:</label>
        <input type="password" name="password2" value=""/>
        <div id="checkPassword2"></div>

        <label for="name"><?php loc('userdata.name') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="name" value="<?php echo($user->getName()) ?>"/>

        <label for="link"><?php loc('userdata.url') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="link" value="<?php echo($user->getLink()) ?>"/>

        <label for="twitter"><?php loc('userdata.twitter') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="twitter" value="<?php echo($user->getTwitter()) ?>"/>

        <label for="country"><?php loc('userdata.country') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="country" value="<?php echo($user->getCountry()) ?>"/>

        <label for="location"><?php loc('userdata.location') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="location" value="<?php echo($user->getLocation()) ?>"/>

        <label for="bio"><?php loc('userdata.bio') ?> <span>(<?php loc('userdata.optional') ?>)</span>:</label>
        <input type="text" name="bio" value="<?php echo($user->getBio()) ?>" size="250"/>
        <br />
        <br />
        <input type="checkbox" name="newsletter" style="width:auto;float:left;" <?php if($user->getNewsletter()) { ?>checked="checked"<? } ?>/><label for="newsletter" style="width:auto;float:left;padding-top:0px;">&nbsp;<?php loc("userdata.newsletter") ?></label><br /><br />
        <input type="checkbox" name="enableMessages" style="width:auto;float:left;" <?php if($user->getEnableMessages()) { ?>checked="checked"<? } ?>/><label for="newsletter" style="width:auto;float:left;padding-top:0px;">&nbsp;<?php loc("userdata.message") ?></label><br /><br />
        <br />
        <?php loc('userdata.changeText') ?><br />
        <br />
        <input type="submit" value="<?php loc("mobile.user_data.button") ?>" class="class_button class_longbutton" />
    </form>
    <br />
</div> 
<?php include("inc/footer.php"); ?>
</body>
</html>