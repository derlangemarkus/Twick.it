<?php 
$user = getUser(true);
?>
<!-- EINGABE-Sprechblase | START -->
<a name="yourText"></a>
<div class="sprechblase unimportant">
    <h2><?php loc('yourTwick.headline')?></h2>

    <div class="sprechblase-main">
        <div class="sprechblase-links">
        	<i>&nbsp;</i>
            <div class="bilderrahmen">
				<?php 
				if($user->isAnonymous()) { 
					?><img src="html/img/avatar/anonymous64.jpg" alt="" /><?php
				} else { 
					?><a href="<?php echo($user->getUrl()) ?>" title="<?php echo htmlspecialchars($user->getDisplayName()) ?>"><?php echo($user->getAvatar(64)) ?></a><?php 
				} 
				?>
			</div>
        </div>
        <div class="sprechblase-rechts">
            
            <div class="blase-header" id="eingabeblase-head">&nbsp;</div>
            <div class="blase-body">
				
                <form class="eingabeblase" id="twickit-blase" action="confirm_twick.php" method="get" name="twickForm">
                    <?php echo(SpamBlocker::printHiddenTags()) ?>
                    <?php if($isNew && getArrayElement($_GET, "tag")) { ?>
                    <label for="title"><?php loc('yourTwick.topic') ?> <span>(<?php loc('yourTwick.required') ?>)</span>:</label>
  					<input type="text" name="title" value="<?php echo($title) ?>"/>
  					<input type="hidden" name="old_title" value="<?php echo($title) ?>" />
					<?php } else { ?>
					<input type="hidden" name="title" value="<?php echo($title) ?>" />
					<?php } ?>
					
					<div id="acronymQuestion"><?php loc('yourTwick.acronym.question', $title) ?> <a href="javascript:;" onclick="$('acronymField').show();$('acronymQuestion').hide();$('acronym').focus();"><?php loc('yourTwick.acronym.answer') ?></a></div>
					<div id="acronymField" style="display:none;">
						<label for="acronym"><?php loc('yourTwick.acronym') ?> <span>(<?php loc('yourTwick.optional') ?>)</span>:</label>
						<input name="acronym" id="acronym" type="text" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "new_acronym", ""))) ?>"/>
					</div>
                    <label for="text"><?php loc('yourTwick.text') ?> <span>(<?php loc('yourTwick.required') ?>)</span>:</label>
					<div id="charCounter" class="charCounterOK"><?php echo(140 - mb_strlen(getArrayElement($_GET, "new_text", ""), "utf8")) ?></div>
                    <textarea name="text" id="textfield" onkeyup="updateCharCounter()" onkeypress="updateCharCounter()"><?php echo(getArrayElement($_GET, "new_text", "")) ?></textarea>
                    <label for="link"><?php loc('yourTwick.url') ?> <span>(<?php loc('yourTwick.optional') ?>)</span>:</label>
                    <input name="link" type="text" value="<?php echo(htmlspecialchars(getArrayElement($_GET, "new_link", ""))) ?>" />
                </form>    
				
				<?php if (!isLoggedIn()) { ?>
				<p style="padding:10px 0 0 20px;width:330px;"><?php loc('yourTwick.anonymous') ?></p>
				<?php } ?>
            </div>
            <div class="blase-footer" id="eingabeblase-footer">
            	<?php if(mb_strlen(getArrayElement($_GET, "new_text", ""), "utf8") == 0 || mb_strlen(getArrayElement($_GET, "new_text", ""), "utf8") > 140) { ?>
                <a href="javascript:;" id="twickit" class="twickitpreview-off"><?php loc('yourTwick.preview') ?></a>
                <?php } else { ?>
                <a href="javascript:;" onclick="$('twickit-blase').submit();" id="twickit" class="twickitpreview"><?php loc('yourTwick.preview') ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="clearbox">&nbsp;</div>
    </div>
</div>
<!-- EINGABE-Sprechblase | ENDE -->