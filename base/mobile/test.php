<?php
require_once("inc.php");

echo("<h1>REQUEST</h1>");
print_rr($_REQUEST);

echo("<h1>Navigator</h1>");
?>
<script type="text/javascript">
    document.write(navigator.userAgent);
</script>
