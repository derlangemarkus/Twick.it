<?php
/*
 * Created at 25.05.2009
 *
 * @author Markus Moeller - Twick.it
 */
require_once("../util/inc.php"); 
checkLogin();

$word = getArrayElement($_POST, "word");
$count = 1+getArrayElement($_POST, "count");

$suggestion = "";
$noWord = NoWord::fetchByUserIdAndWord(getUserId(), $word);
if (!$noWord) {
	$noWord = new NoWord();
	$noWord->setUserId(getUserId());
	$noWord->setWord($word);
	$noWord->setCreationDate(getCurrentDate());
	$noWord->save();
	
	$user = getUser();
	$suggestions = $user->findTopicSuggestions($count);
	if (sizeof($suggestions) >= $count) {
		$suggestion = array_pop(array_keys($suggestions));
	}
}
?>
{
"word" : "<?php jecho($word) ?>",
"suggestion" : "<?php jecho($suggestion) ?>",
"suggestionWord" : "<?php jecho(correctCapitalization($suggestion)) ?>"
}
