<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("util/inc.php");
checkLogin();

$user = getUser();

$orderBy = getArrayElement($_GET, "order", "send_date");
$orderDir = getArrayElement($_GET, "dir", "DESC");

$messages = Message::fetchSent($user->getId(), array("ORDER BY"=>$orderBy . " " . $orderDir));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php loc('messages.sent.title', array($user->getLogin(), sizeof($messages))) ?> | <?php loc('core.titleClaim') ?></title>
    <meta name="description" content="<?php loc('messages.sent.title', array($user->getLogin(), sizeof($messages))) ?> | <?php loc('core.titleClaim') ?>" />
    <meta name="keywords" content="<?php loc('core.keywords') ?>" />
    <?php include("inc/inc_global_header.php"); ?>
	<style type="text/css">
		#messages input{padding:4px;}
	</style>
</head>

<body>
	<?php include("inc/inc_header.php"); ?>
	
    <div id="contentFrame">

		<!-- Ergebnis-Feld -->
		<div class="header-ergebnisfeld" id="header-ergebnisfeld">
			<h1><?php loc('messages.sent.headline', $user->getLogin()) ?></h1>
		</div>
		
		<!-- Content-Bereich | START -->
		<div class="content">
			
			<!-- Linke Haelfte | START -->
			<div class="inhalte-links">
				<?php if(getArrayElement($_GET, "msg") && isset($TEXT[getArrayElement($_GET, "msg")])) { ?>
				<div class="message_infos"><?php loc(getArrayElement($_GET, "msg")) ?></div>
				<?php } ?>

                <?php if(sizeof($messages)) { ?>
				<form action="action/messagebulk.php" method="post" id="messagebulk">
					<input type="hidden" name="secret" value="<?php echo($user->getSecret()) ?>" />
					<input type="hidden" name="sent" value="1" />
					<table id="messages" cellpadding="0" cellspacing="0">
						<tr>
							<th colspan="2"></th>
							<th><?php loc("messages.header.date") ?></th>
							<th><?php loc("messages.header.subject") ?></th>
							<th><?php loc("messages.header.receiver") ?></th>                        
							<th></th>
						</tr>
						<?php 
						foreach($messages as $counter=>$message) {
							$receiver = $message->getReceiver();
							if(!$receiver) {
								continue;
							}
							$click = 'onclick="window.location.href=\'show_message.php?id=' . $message->getId() . "'\"";
						?>
						<tr class="<?php echo($counter%2 ? "odd" : "even") ?>" id="message<?php echo($message->getId()) ?>">
							<td valign="top" style="width:17px"><input type="checkbox" name='mark_<?php echo($message->getId()) ?>' style="margin:4px;"/></td>
							<td valign="top" style="width:20px" <?php echo($click) ?>><img src="<?php echo($message->getImage()) ?>" alt="" style="padding-top:3px"/></td>
							<td <?php echo($click) ?> valign="top"><?php echo convertDate($message->getSendDate(), "d.m.Y, H:i") ?></td>
							<td <?php echo($click) ?> valign="top"><?php echo($message->getSubject()) ?></td>
							<td <?php echo($click) ?> valign="top"><a href="<?php echo($receiver->getUrl()) ?>" id="userlink" title='<?php loc('messages.tooltip.userlink') ?>'><?php echo($receiver->getAvatar(20)) ?></a><?php echo htmlspecialchars($receiver->getDisplayName()) ?></td>
							<td><a href="javascript:;" onclick="confirmPopup('<?php loc('core.areYouSure') ?>', 'javascript:deleteMessage(<?php echo($message->getId()) ?>)');" class="delete_message"></a></td>
						</tr>
						<?php } ?>
						<tr>
							<td valign="top"><img src="html/img/select_arrow.gif" alt="" style="width:18px;height:18px;padding-top:7px;"/></td>
							<td colspan="5" style="padding:14px 0px 14px 0px;">
								<?php loc('messages.bulk.intro') ?> <select name="bulkaction" style="width:200px">
									<option value=""></option>
									<option value="delete"><?php loc('messages.bulk.delete') ?></option>
								</select>
								<a href="javascript:;" onclick="$('messagebulk').submit()" class="teaser-link" style="float:none;display:inline;margin-left:10px;"><?php loc('messages.bulk.go') ?></a>
							</td>
						</tr>
					</table>
				</form>
                <?php } else { ?>
                <div class="message_infos"><?php loc('messages.sent.marginal.text.0'); ?></div>
                <?php } ?>
			</div>
			<!-- Linke Haelfte | ENDE -->
			
			
			<!-- Rechte Haelfte | START -->
			<div class="inhalte-rechts">
			
				<!-- Info | START -->
			    <div class="teaser">
			    	<div class="teaser-head"><h2><?php loc('messages.sent.marginal.title') ?></h2></div>
			        <div class="teaser-body">
			        	<div>
			        		<?php
                            if(sizeof($messages) == 0) {
                                loc('messages.sent.marginal.text.0');
                            } else if(sizeof($messages) == 1) {
                                loc('messages.sent.marginal.text.1');
                            } else {
                                loc('messages.sent.marginal.text.n', sizeof($messages));
                            }
                            ?>
                            <br />
							<ul class="message_icons">
								<li><a href="messages"><img src="html/img/folder.png"><?php loc('messages.sent.marginal.switch') ?></a></li>
								<li><a href="write_message.php"><img src="html/img/email_edit.png"><?php loc('messages.marginal.write') ?></a></li>
								<?php if(isAdmin()) { ?>
								<li><a href="write_bulk_message.php"><img src="html/img/rss.gif">Megamail</a></li>
								<?php } ?>
							</ul>
			            </div>
			        </div>
			        <div class="teaser-footer"></div>                        
			    </div>
			    <!-- Info | ENDE -->  
		
			
			<br /></div>
			<!-- Rechte Haelfte | ENDE -->
			
			<div class="clearbox"></div>
		</div>
		<!-- Content-Bereich | ENDE -->
	
	</div>
	
	<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>

    <script type="text/javascript">
        function deleteMessage(inId) {
            $('curtain').remove();
            $('popup-kasten').remove();
            new Ajax.Request(
                "<?php echo(HTTP_ROOT) ?>/inc/ajax/delete_message.php", {
                    method: 'post',
                    parameters: 'id=' + inId + "&secret=<?php echo($user->getSecret()) ?>"
                }
            );
            Effect.Puff("message" + inId);
        }
    </script>
</body>
</html>
