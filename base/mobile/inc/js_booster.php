<script type="text/javascript">
	var textarea = new Element("textarea", {"name":"text", "style":"width:95%"});
	textarea.update($("explanationText").value);
	$("explanationText").insert({after:textarea});
	$("explanationLabel").update("<?php loc('mobile.yourTwick.explanation') ?> (<span id='counter'>140</span> <?php loc('mobile.yourTwick.charsLeft') ?>):");
	textarea.onkeyup = function() { updateCounter(); }
	updateCounter();
	$("explanationText").remove();
	
	function updateCounter() {
		var textLength = textarea.value.length;
		var charsLeft = 140-textLength;
		$("counter").update(charsLeft);

		if (charsLeft < 0) {
			//disableTwickitButton(inId);
			$("counter").style.color = "#F00";
			textarea.style.backgroundColor = "#C00";
		} else if (charsLeft == 140) {
			//disableTwickitButton(inId);
		} else {
			//enableTwickitButton(inId);
			$("counter").style.color = "#333";
			textarea.style.backgroundColor = "#FFF";
		}
	}
</script>