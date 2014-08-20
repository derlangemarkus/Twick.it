<?php 
require_once("../../util/inc.php");

$id = getArrayElement($_GET, "id");
$login = getArrayElement($_GET, "user");
?>
<div class="messageswitch">
<a href="write_message.php?twick=<?php echo($id) ?>"><img src="../html/img/pfeil_weiss_klein.gif" /> <?php loc('twick.message.message', $login) ?></a><br />
<br />
<a href="user/<?php echo($login) ?>?inc=wall&twick=<?php echo($id) ?>"><img src="../html/img/pfeil_weiss_klein.gif" /> <?php loc('twick.message.wall', $login) ?></a>
</div>