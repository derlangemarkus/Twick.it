<?php 
require_once("../../../util/inc.php");

header("Content-Type: text/xml; charset=utf-8");
printXMLHeader();
?>
<os:openServiceDescription
    xmlns:os="http://www.microsoft.com/schemas/openservicedescription/1.0">
    <os:homepageUrl>http://twick.it</os:homepageUrl>
    <os:display>
        <os:name><?php loc('interfaces.browser.ieAccelerator.name') ?></os:name>
        <os:icon>http://twick.it/favicon.ico</os:icon>
        <os:description><?php loc('interfaces.browser.ieAccelerator.description') ?></os:description>
    </os:display>
    <os:activity category="Search">
        <os:activityAction context="selection">
            <os:preview action="http://m.twick.it/topic.php?plain=1&amp;search={selection}" />
            <os:execute action="http://twick.it/find_topic.php" method="get">
                <os:parameter name="search" value="{selection}" type="text" />
            </os:execute>
        </os:activityAction>
    </os:activity>
</os:openServiceDescription>