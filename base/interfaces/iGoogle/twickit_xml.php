<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../../util/inc.php"); 

header("Content-Type: text/xml; charset=utf-8");
printXMLHeader(); 
?>

<Module>
	<ModulePrefs 
		title="Twick.it" 
		title_url="http://twick.it" 
		directory_title="Twick.it" 
		description="Add the power of Twick.it to iGoogle" 
		author="Markus Möller (Twick.it)" 
		author_email="markus@twick.it" 
		author_affiliation="Twick.it" 
		author_link="http://twick.it/user/derlangemarkus" 
		author_location="Siegen, Germany" 
		height="300" 
		screenshot="http://twick.it/interfaces/iGoogle/screenshot.png" 
		thumbnail="http://twick.it/interfaces/iGoogle/thumbnail.png" 
		category="tools"
	>
		<Locale messages="http://twick.it/interfaces/iGoogle/en_ALL.xml"/>
	    <Locale lang="de" messages="http://twick.it/interfaces/iGoogle/de_ALL.xml"/>

		<Icon>http://twick.it/favicon.ico</Icon>
	</ModulePrefs>
	<UserPref name="language" display_name="__MSG_language__" default_value="de" datatype="enum">
		<?php foreach($languages as $languageData) { ?>
    	<EnumValue value="<?php echo($languageData["code"]) ?>" display_value="<?php echo($languageData["name"]) ?>"/>
    	<?php } ?>
  	</UserPref> 
	<Content type="url" href="http://twick.it/interfaces/iGoogle/gadget.php?lng=__UP_language__"/>
</Module>