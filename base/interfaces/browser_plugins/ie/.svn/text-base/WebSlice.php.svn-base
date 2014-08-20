<?php
require_once("../../../util/inc.php");

$twicks = Twick::fetchNewest(50);

?>
<html>
<head>
<title>Twick.it Web Slice</title>
</head>
<body>
   <div class="hslice" id="it.twick.webslice">
      <span class="entry-title">Twick.it</span>
      <a rel="entry-content" href="http://twick.it/latest_twicks.php" style="display:none;">
          <?php 
          foreach($twicks as $twick) {
            echo($twick->getTitle() . "<br />");
          } 
          ?>
      </a>
      <p>Updates occur every <span class="ttl">15</span> minutes.</p>
      <a rel="bookmark" href="http://twick.it/latest_twicks.php" style="display:none;">Twick.it</a>
   </div>
</body>
</html>