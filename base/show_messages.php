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

$messages = Message::fetchReceived($user->getId(), array("ORDER BY" => $orderBy . " " . $orderDir));
$unread = sizeof(Message::fetchReceived($user->getId(), array(), true));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo(getLanguage()) ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php loc('messages.title', array($user->getLogin(), $unread . "/" . sizeof($messages))) ?> | <?php loc('core.titleClaim') ?></title>
        <meta name="description" content="<?php loc('messages.title', array($user->getLogin(), sizeof($messages))) ?> | <?php loc('core.titleClaim') ?>" />
        <meta name="keywords" content="<?php loc('core.keywords') ?>" />
        <?php include("inc/inc_global_header.php"); ?>
        <style type="text/css">
            div#legend {margin:0 0 20px 20px;width:540px;padding:10px;background-color:#FFFFFF;}
			#messages input{padding:4px;}
        </style>
    </head>

    <body>
        <?php include("inc/inc_header.php"); ?>

        <div id="contentFrame">

            <!-- Ergebnis-Feld -->
            <div class="header-ergebnisfeld" id="header-ergebnisfeld">
                <h1><?php loc('messages.headline', $user->getLogin()) ?></h1>
            </div>

            <!-- Content-Bereich | START -->
            <div class="content">

                <!-- Linke Haelfte | START -->
                <div class="inhalte-links">
                    <?php if (getArrayElement($_GET, "msg") && isset($TEXT[getArrayElement($_GET, "msg")])) { ?>
                        <div class="message_infos"><?php loc(getArrayElement($_GET, "msg")) ?></div>
					<?php } ?>

					<?php if (sizeof($messages)) { ?>
						<form action="action/messagebulk.php" method="post" id="messagebulk">
							<input type="hidden" name="secret" value="<?php echo($user->getSecret()) ?>" />
							<table id="messages" cellpadding="0" cellspacing="0">
								<tr>
									<th colspan="2"></th>
									<th><?php loc("messages.header.date") ?></th>
									<th><?php loc("messages.header.subject") ?></th>
									<th><?php loc("messages.header.sender") ?></th>
									<th></th>
								</tr>
							<?php
							foreach ($messages as $counter => $message) {
								$sender = $message->getSender();
								if (!$sender) {
									continue;
								}
								$style = $message->getReadDate() ? "" : "font-weight:bold;font-style:italic;font-size:13px;color:#000";
								$click = 'onclick="window.location.href=\'message/' . $message->getId() . "'\"";
							?>
								<tr style="<?php echo($style) ?>" class="<?php echo($counter % 2 ? "odd" : "even") ?>" id="message<?php echo($message->getId()) ?>">
									<td valign="top" style="width:17px"><input type="checkbox" name='mark_<?php echo($message->getId()) ?>' style="margin:4px;"/></td>
									<td valign="top" style="width:20px" <?php echo($click) ?>><img src="<?php echo($message->getImage()) ?>" alt="" style="padding-top:2px"/></td>
									<td <?php echo($click) ?> valign="top" style="<?php echo($style) ?>"><?php echo convertDate($message->getSendDate(), "d.m.Y, H:i") ?></td>
									<td <?php echo($click) ?> valign="top" style="<?php echo($style) ?>"><?php echo($message->getSubject()) ?></td>
									<td <?php echo($click) ?> valign="top" style="<?php echo($style) ?>"><a href="<?php echo($sender->getUrl()) ?>" id="userlink" title='<?php loc('messages.tooltip.userlink') ?>'><?php echo($sender->getAvatar(20)) ?></a><?php echo htmlspecialchars($sender->getDisplayName()) ?></td>
									<td width="24"><a href="javascript:;" onclick="confirmPopup('<?php loc('core.areYouSure') ?>', 'javascript:deleteMessage(<?php echo($message->getId()) ?>)')" class="delete_message"></a></td>
								</tr>
							<?php } ?>
							<tr>
								<td valign="top"><img src="html/img/select_arrow.gif" alt="" style="width:18px;height:18px;padding-top:7px;"/></td>
								<td colspan="5" style="padding:14px 0px 14px 0px;">
									<?php loc('messages.bulk.intro') ?> <select name="bulkaction" style="width:200px">
										<option value="read"><?php loc('messages.bulk.read') ?></option>
										<option value="delete"><?php loc('messages.bulk.delete') ?></option>
									</select>
									<a href="javascript:;" onclick="$('messagebulk').submit()" class="teaser-link" style="float:none;display:inline;margin-left:10px;"><?php loc('messages.bulk.go') ?></a>
								</td>
							</tr>
						</table>
						
					</form>

                    <div id="legend">
                        <img src="html/img/message_user_message.jpg" alt="" />&nbsp;<?php loc('mesages.legend.user_message') ?><br />
                        <img src="html/img/message_notification.jpg" alt="" />&nbsp;<?php loc('mesages.legend.notification', $user->getUrl() . "/wall") ?><br />
                        <img src="html/img/message_wall.jpg" alt="" />&nbsp;<?php loc('mesages.legend.wall', $user->getUrl() . "/wall") ?><br />
                        <img src="html/img/message_twickit.jpg" alt="" />&nbsp;<?php loc('mesages.legend.twickit') ?><br />
                        <img src="html/img/message_badge.jpg" alt="" />&nbsp;<?php loc('mesages.legend.badge', "badges.php?username=" . $user->getLogin()) ?><br />
                        <img src="html/img/message_newsletter.jpg" alt="" />&nbsp;<?php loc('mesages.legend.newsletter') ?><br />
                    </div>



<?php } else { ?>
                        <div class="message_infos"><?php loc('messages.marginal.text.0'); ?></div>
<?php } ?>
                </div>
                <!-- Linke Haelfte | ENDE -->


                <!-- Rechte Haelfte | START -->
                <div class="inhalte-rechts">

                    <!-- Info | START -->
                    <div class="teaser">
                        <div class="teaser-head"><h2><?php loc('messages.marginal.title') ?></h2></div>
                        <div class="teaser-body">
                            <div>
                                <?php
                                if (sizeof($messages) == 0) {
                                    loc('messages.marginal.text.0');
                                } else if (sizeof($messages) == 1) {
                                    if (sizeof($unread)) {
                                        loc('messages.marginal.text.1.1');
                                    } else {
                                        loc('messages.marginal.text.1.0');
                                    }
                                } else {
                                    loc('messages.marginal.text.n', array(sizeof($messages), $unread));
                                }
                                ?>
                                <br />
                                <ul class="message_icons">
                                    <li><a href="show_sent_messages.php"><img src="html/img/folder_go.png"/><?php loc('messages.marginal.switch') ?></a></li>
                                    <li><a href="write_message.php"><img src="html/img/email_edit.png"/><?php loc('messages.marginal.write') ?></a></li>
								<?php if(sizeof($unread)) { ?>
                                    <li><a href="javascript:;" onclick="confirmPopup('<?php loc('core.areYouSure') ?>', 'action/read_all_messages.php?secret=<?php echo($user->getSecret()) ?>');"><img src="html/img/email_mark_as_read.png"/><?php loc('messages.marginal.markAllAsRead') ?></a></li>
                                    <?php } ?>
								<?php if(isAdmin()) { ?>
                                    <li><a href="write_bulk_message.php" style="color:#F00"><img src="html/img/rss.gif">Megamail</a></li>
<?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="teaser-footer"></div>
                    </div>
                    <!-- Info | ENDE -->

                    <!-- E-Mail | START -->
                    <div class="teaser">
                        <div class="teaser-head"><h2><?php loc('messages.marginal.mail.title') ?></h2></div>
                        <div class="teaser-body">
                            <div>
<?php loc('messages.marginal.mail.text') ?><br />
                                <br />
                                <form action="#">
                                    <table>
                                        <tr>
                                            <td valign="top" style="padding-right:8px;"><input type="checkbox" id="notify" <?php if ($user->getEnableMessages()) { ?>checked<?php } ?> onchange="enableMessages()"/></td>
                                            <td><?php loc('messages.marginal.mail.checkbox') ?></td>
                                        </tr>
                                    </table>
                                </form>
                                <div id="notify_saved" style='display:none;padding:5px;font-weight:bold;background-color:#6E9018;color:#FFF'><?php loc('userdata.success.saved') ?></div>
                            </div>
                        </div>
                        <div class="teaser-footer"></div>
                    </div>
                    <!-- E-Mail | ENDE -->


                    <br /></div>
                <!-- Rechte Haelfte | ENDE -->

                <div class="clearbox"></div>
            </div>
            <!-- Content-Bereich | ENDE -->

        </div>

<?php include(DOCUMENT_ROOT . "/inc/inc_footer.php"); ?>
        <script type="text/javascript">
        function enableMessages() {
            new Ajax.Request(
                "<?php echo(HTTP_ROOT) ?>/inc/ajax/enable_messages.php", {
                    method: 'post',
                    parameters: 'notify=' + ($('notify').checked ? "1" : "0") + "&secret=<?php echo($user->getSecret()) ?>",
                    onSuccess: function() {
                        $("notify_saved").appear();
                        $("notify_saved").pulsate({"from":0.9, "pulses":2});
                        window.setTimeout('$("notify_saved").fade()', 2000);
                    }
                }
            );
        }

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
