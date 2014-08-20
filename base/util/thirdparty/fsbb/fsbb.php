<?php
// +----------------------------------------------------------------------+
// | formSpamBotBlocker 0.3                                               |
// +----------------------------------------------------------------------+
// | Date: 3 May 2007                                                     |
// +----------------------------------------------------------------------+
// | License: LGPL                                                        |
// +----------------------------------------------------------------------+
// | formSpamBotBlocker is a PHP class, that tries to prevent web form    |
// | submissions by spambots without having to interact with a human user.|
// | It generates <input type="hidden"> or visually hidden tags (CSS)     |
// | and checks their unique names and values to identify a spambot.      |
// | No CAPTCHA-, COOKIE or Javascript-based methods are used.            |
// +----------------------------------------------------------------------+
// | Author: Giorgos Tsiledakis <gt(at)corissia(dot)com>                  |
// +----------------------------------------------------------------------+
//==============================================================================================
// Please take a look at the included documentation file first: readme.txt
// Use of the class:
// 1. Create the required <input> tags on the page contaning the web form:
// a. Optionally set your defaults in the class source file (public variables), set your own unique $initKey!
// b. Include the class in your script
// c. Create an object: $blocker=new formSpamBotBlocker();
// d. Optionally call public functions or set public variables to adapt your defaults to the current web form
// e. get the xhtml string: $hiddentags=$blocker->makeTags(); (if $hasSession=true, make sure you call makeTags() before the output of any html code, or you will get an error message!)
// f. within your web form: print $hiddentags;
//
// 2. Check if the $_POST or $_GET array contains the valid parametes on the target page
// if ($_POST){ // or $_GET
// 		$blocker=new formSpamBotBlocker();
// 		$nospam=false;
// 		$nospam=$blocker->checkTags($_POST); // or $_GET
//			if ($nospam) print "Valid Submission"; // handle valid request
// 			else print "Invalid Submission"; // handle invalid request
// 	} 
//==============================================================================================
class formSpamBotBlocker{
//==============================================================================================
// PUBLIC VARIABLES AND FUNCTIONS
//==============================================================================================
var $initKey="twickit_markus"; // set some string here to make the encoded names and values hard to guess
var $minutesAfterMidnight=20; // minutes after midnight to allow a submission of a form generated at the previous day
var $minTime=2; // time in seconds needed to have passed, before o form can be submitted, set also by setTimeWindow()
var $maxTime=600; // max time in seconds to submit a form, set also by setTimeWindow()
var $hasTrap=true; // true: a visually hidden input tag will be generated, set also by setTrap()
var $trapName="twickit_email"; // name of the visually hidden input tag, set also by setTrap()
var $trapLabel="Do not enter anything in this text box otherwise your message will not be sent!"; // label info to warn human users, who do not use CSS, set also by setTrap()
var $hasSession=false; // enables a session based method to prevent multiple submissions with the same parameters
//==============================================================================================
// PUBLIC setTrap()
// param $bol: true to enable the trap tag, false to disable it [boolean, optional, default=true]
// param $name: if given, it sets the name of the trap tag [string, optional, default=false]
// param $label: if given, it sets the label of the trap tag [string, optional, default=false]
//==============================================================================================
	function setTrap($bol=true,$name=false,$label=false){
		if ($bol==false) $this->hasTrap=false;
		else{
			$this->hasTrap=true;
			if ($name) $this->trapName=$name;
			if ($label) $this->trapLabel=$label;
		}
	}
//==============================================================================================
// PUBLIC setTimeWindow()
// param $min: time in seconds needed to have passed, before o form can be submitted [numeric, optional, default=2]
// param $max: max time in seconds to submit a form [numeric, optional, default=600]
//==============================================================================================
	function setTimeWindow($min=2,$max=600){
		$this->minTime=$min;
		$this->maxTime=$max;
	}
	function formSpamBotBlocker(){

	}
//==============================================================================================
// PUBLIC makeTags() [string]
// generates the xhtml string for the required form input tags
//==============================================================================================
	function makeTags(){
		$this->initCode();
		$this->sessionStart($this->codeInit);		
		$out="";
		$out.=$this->setCodeID();
		$out.=$this->userID();
		$out.=$this->dynID();
		if ($this->hasTrap) $out.=$this->trapID();
		return $out;
	}
//==============================================================================================
// PUBLIC checkTags() [boolean]
// param $arr: the $_POST or $_GET array sent by a form
// checks if there are valid parameters in the $arr array
//==============================================================================================
	function checkTags($arr=array()){
			if ($arr[$this->keyName] && $arr[$this->keyName]!=""){
				$this->getCodeID($arr[$this->keyName]);
			}
			else {
				$this->logError("Spam 1");
				return false;
			}
		return
            $this->sessionCheck($arr[$this->keyName]) &&
           # $this->checkUserID($arr) &&
            $this->checkDynID($arr) &&
            $this->checkTrap($arr);
	}
//==============================================================================================
// PUBLIC getTagNames() [array]
// returns an array with the names of the generated form elements
// [0]: Name of the element that contains the generated key
// [1]: Name of the element that contains the generated userID
// [2]: Name of the element that contains the generated dynID
// [3]: Name of the element that contains the generated visually hidden element
//==============================================================================================
	function getTagNames(){
		$tagNames=array();
		$tagNames[0]=$this->keyName;
		$tagNames[1]=$this->userIDName;
		$tagNames[2]=$this->dynIDName;
		$tagNames[3]=$this->trapName;
		return $tagNames;
	}
//==============================================================================================
// PRIVATE VARIABLES AND FUNCTIONS
//==============================================================================================
var $version="v0.3 (030507)";
var $keyName="fsbb_key";
var $sesName="fsbb_ses";
var $userIDName="";
var $dynIDName="";
var $dynTime="";
//==============================================================================================
// PRIVATE sessionStart(), called in function makeTags()
// sets a session variable=0, if the public variable $hasSession==true, to prevent multiple submissions
//==============================================================================================
	function sessionStart($sid){
		if ($this->hasSession){
			session_start();
			$_SESSION[$this->sesName]=0;
			$_SESSION[$this->keyName]=$this->enc($sid);
		}
	}
//==============================================================================================
// PRIVATE sessionCheck(), called in function checkTags()
// checks a session variable, if the public variable $hasSession==true, to prevent multiple submissions
//==============================================================================================
	function sessionCheck($sid){
		if ($this->hasSession){
			session_start();
			$_SESSION[$this->sesName]=$_SESSION[$this->sesName]+1;
			$sesNum=$_SESSION[$this->sesName];
			$sesKey=$_SESSION[$this->keyName];
				if ($sesNum==1 && $sesKey==$this->enc($sid)) return true;
				else{
					$_SESSION[$this->sesName]=$sesNum++;
					$this->logError("Spam 2");
					return false;
				}
		}
		else return true;	
	}
//==============================================================================================
// PRIVATE userID() [string], called in function makeTags()
// generates the xhtml string for the hidden input tag, that contains some unique userID
//==============================================================================================
	function userID(){
		$userID=$this->intUserID();
		$tagName=substr($userID, $this->userIDNamestart, $this->userIDNameLength);
		$tagValue=substr($userID, $this->userIDValuestart, $this->userIDValueLength);
		$out="<input type=\"hidden\" name=\"".$tagName."\" value=\"".$tagValue."\" />\n";
		$this->userIDName=$tagName;
		return $out;
	}
//==============================================================================================
// PRIVATE dynID() [string], called in function makeTags()
// generates the xhtml string for the hidden input tag with a name, that changes daily
//==============================================================================================
	function dynID(){
		$actDay=date("j");
		$actMonth=date("n");
		$actYear=date("Y");
		$actTime=time();
		$today=mktime(0,0,0,$actMonth,$actDay,$actYear);
		$tagName=substr($this->enc($today.$this->initKey), $this->dynIDNamestart, $this->dynIDNameLength);
		$tagValue=$this->enc($actTime,"base64");
		$out="<input type=\"hidden\" name=\"".$tagName."\" value=\"".$tagValue."\" />\n";
		$this->dynIDName=$tagName;
		$this->dynTime=$actTime;
		return $out;
	}
//==============================================================================================
// PRIVATE setCodeID() [string], called in function makeTags()
// generates the xhtml string for the hidden input tag, that contains the key do decrypt the code passed
//==============================================================================================
	function setCodeID(){
		$out="<input type=\"hidden\" name=\"".$this->keyName."\" value=\"".$this->codeInit."\" />\n";
		return $out;
	}
//==============================================================================================
// PRIVATE trapID() [string], called in function makeTags()
// generates the xhtml string for the trag text input tag, that is hidden using CSS
// if CSS is disabled, a human user will be warned no to enter anything in this box
// It is a good idea to change the style="display:none" to class="somename"
// and set in your external CSS .somename {display:none;} to confuse spambots even more
//==============================================================================================
	function trapID(){
		$out="<span style=\"display:none;visibility:hidden;\">\n";
		$out.="<label for=\"".$this->trapName."\">".$this->trapLabel."</label>\n";
		$out.="<input type=\"text\" name=\"".$this->trapName."\" id=\"".$this->trapName."\" value=\"\" />\n";
		$out.="</span>\n";
		return $out;
	}
//==============================================================================================
// PRIVATE intUserID() [string], called in function userID()
// generates the unique userID
//==============================================================================================
	function intUserID(){
		$actSystem=$_SERVER['HTTP_USER_AGENT'];
		$actIP=$_SERVER['REMOTE_ADDR'];
		$userID=$this->enc($actSystem.$actIP.$this->initKey);
		return $userID;
	}
//==============================================================================================
// PRIVATE enc() [string]
// encoding method
//==============================================================================================
	function enc($var,$method=false){
		if ($method=="base64") return base64_encode($var);
		else return md5($var);
	}
//==============================================================================================
// PRIVATE initCode(), called in function makeTags()
// generates the required parameters to encrypt the generated hidden names and values
//==============================================================================================
	function initCode(){
		$r1=rand(10,124);
		$r2=rand(4,12);
		$r3=rand(17,89);
		$r4=rand(199,489);
		$r5=rand(1,42);
		$r6=rand(312,999);
		$userIDNameStart=rand(0,31);
		$userIDNameLength=(32-$userIDNameStart);
		$userIDValueStart=rand(0,31);
		$userIDValueLength=(32-$userIDValueStart);
		$dynIDNameStart=rand(0,31);
		$dynIDNameLength=(32-$dynIDNameStart);
		$this->userIDNamestart=$userIDNameStart;
		$this->userIDNameLength=$userIDNameLength;
		$this->userIDValuestart=$userIDValueStart;
		$this->userIDValueLength=$userIDValueLength;
		$this->dynIDNamestart=$dynIDNameStart;
		$this->dynIDNameLength=$dynIDNameLength;
		$this->codeInit=$r1.".".$userIDNameStart.".".$r2.".".$userIDNameLength.".".$r3.".".$userIDValueStart.".".$r4.".".$userIDValueLength.".".$r5.".".$dynIDNameStart.".".$r6.".".$dynIDNameLength;
	}
//==============================================================================================
// PRIVATE getCodeID(), called in function checkTags()
// sets the required perameters for the code decryption
//==============================================================================================
	function getCodeID($key){
		$keys=explode(".",$key);
		$this->userIDNamestart=$keys[1];
		$this->userIDNameLength=$keys[3];
		$this->userIDValuestart=$keys[5];
		$this->userIDValueLength=$keys[7];
		$this->dynIDNamestart=$keys[9];
		$this->dynIDNameLength=$keys[11];
	}
//==============================================================================================
// PRIVATE checkUserID() [boolean], called by function checkTags()
// checks if there is a valid userID in an array specified
//==============================================================================================
	function checkUserID($arr=array()){
		$found=false;
		$userID=$this->intUserID();
		$tagName=substr($userID, $this->userIDNamestart, $this->userIDNameLength);
		$tagValue=substr($userID, $this->userIDValuestart, $this->userIDValueLength);
			foreach ($arr as $name=>$value){
				if ($tagName==$name && $tagValue==$value){
					$found=true;
					$this->userIDName=$name;
				}
			}
		if (!$found) {
			$this->logError("Spam 3");
		}
		return $found;
	}
//==============================================================================================
// PRIVATE checkDynID() [boolean], called by function checkTags()
// checks if there is a valid dynID in an array specified
//==============================================================================================
	function checkDynID($arr=array()){
		$actDay=date("j");
		$actMonth=date("n");
		$actYear=date("Y");
		$now=time();
		$today=mktime(0,0,0,$actMonth,$actDay,$actYear);
		$yesterday=mktime(0,0,0,$actMonth,$actDay-1,$actYear);
		$indelay=$now-$today-($this->minutesAfterMidnight*60);
		$checktoday=substr($this->enc($today.$this->initKey), $this->dynIDNamestart, $this->dynIDNameLength);
		$checkyesterday=substr($this->enc($yesterday.$this->initKey), $this->dynIDNamestart, $this->dynIDNameLength);
			foreach ($arr as $name=>$value){
				if ($name==$checktoday OR ($name==$checkyesterday && $indelay<=0)){
					$val=base64_decode($value);
					$this->dynTime=$val;
					if ($this->checkSubmisionTime($val)){
						$found=true;
						$this->dynIDName=$name;
					}
				}
			}
			
		if (!$found) {
			$this->logError("Spam 5");
		}
		return $found;
	}
//==============================================================================================
// PRIVATE checkSubmisionTime() [boolean], called by function checkDynID()
// checks if the form was submitted within the time period, set by minTime and maxTime variables
//==============================================================================================
	function checkSubmisionTime($var){
		$now=time();
		$elapsed=$now-$var;
		if (($elapsed<$this->minTime) OR ($elapsed>$this->maxTime)) return false;
		else return true; 
	}
//==============================================================================================
// PRIVATE checkTrap() [boolean], called by function checkTags()
// checks if a parameter, hidden by CSS, has some value
//==============================================================================================
	function checkTrap($arr=array()){
		$noTrap=true;
			foreach ($arr as $name=>$value){
				if ($name==$this->trapName && $value!="") {
					if ($name != "0") {  // Keine Ahnung warum, aber es kam zu falschen Spam-Meldungen bei $name == 0
						$noTrap=false;
						$this->logError("Spam 6: $name ist nicht leer!");
					}
				}
			}
		return $noTrap;	
	}


    function logError($inMessage) {
        alert($inMessage);

        $message = $inMessage . "\n";
        $message .= print_r($_SERVER, true);
        $message .= "\n\n\n";

        $handle=fopen(DOCUMENT_ROOT . "/writable/spam.log", "a");
        fwrite($handle, $message);
        fclose($handle);
    }
}
?>