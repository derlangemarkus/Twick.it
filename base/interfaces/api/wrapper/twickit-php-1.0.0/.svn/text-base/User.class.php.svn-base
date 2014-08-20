<?php
/*
This class represents an user at Twick.it.
 
@author		Markus Möller (Twick.it)
@link 		http://twick.it Twick.it homepage
@link 		http://twick.it/blog/en/for-developers/api/ API documentation
@see 		Twickit_UserInfo
@version	1.0
@licence	BSD License

Copyright (c) 2010, Markus Möller
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright
      notice, this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the above copyright
      notice, this list of conditions and the following disclaimer in the 
      documentation and/or other materials provided with the distribution.
    * Neither the name of Twick.it nor the names of its contributors may be 
      used to endorse or promote products derived from this software without 
      specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.
*/
class Twickit_User {

	// ---------------------------------------------------------------------
	// ----- Attributes ----------------------------------------------------
	// ---------------------------------------------------------------------
	private $gravatar;
	private $name;
	private $username;
	private $url;
	
	
	// ---------------------------------------------------------------------
	// ----- Constructor ---------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Creates a new User instance.
	 *
	 *	@param SimpleXMLElement $inXml XML data return by the api call.
	 */
	public function __construct($inXml) {      
		$this->gravatar = (string)$inXml->gravatar;
		$this->name = (string)$inXml->name;
		$this->username = (string)$inXml->username;
		$this->url = (string)$inXml->url;
	}
	

	// ---------------------------------------------------------------------
	// ----- Getter --------------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Get the gravatar (=user image) of the user.
	 *
	 *	@return the gravatar.
	 */
	public function getGravatar() {
		return $this->gravatar;
	}
	
	/**
	 *	Get the name (constists of username and real name if specified) of the user.
	 *
	 *	@return the name.
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 *	Get the username of the user.
	 *
	 *	@return the username.
	 */
	public function getUsername() {
		return $this->username;
	}
	
	/**
	 *	Get the URL to the user's profile page at Twick.it.
	 *
	 *	@return the URL.
	 */
	public function getUrl() {
		return $this->url;
	}
}
?>