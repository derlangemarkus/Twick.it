<?php
/*
This class represent a short explanation called "Twick". A Twick consists
of a text in at most 140 characters.

@author		Markus Möller (Twick.it)
@link 		http://twick.it Twick.it homepage
@link 		http://twick.it/blog/en/for-developers/api/ API documentation
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
class Twickit_Twick {

	// ---------------------------------------------------------------------
	// ----- Attributes ----------------------------------------------------
	// ---------------------------------------------------------------------
	private $id;
	private $acronym;
	private $text;
	private $link;
	private $url;
	private $standaloneUrl;
	private $creationDate;
	private $rating;
	private $user;
	
	
	// ---------------------------------------------------------------------
	// ----- Constructor ---------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Creates a new Twick instance.
	 *
	 *	@param SimpleXMLElement $inXml XML data return by the api call.
	 */
	public function __construct($inXml) {      
		$this->id = (int)$inXml->id;
		$this->acronym = (string)$inXml->acronym;
		$this->text = (string)$inXml->text;
		$this->link = (string)$inXml->link;
		$this->url = (string)$inXml->url;
		$this->standaloneUrl = (string)$inXml->standalone_url;
		$this->creationDate = (string)$inXml->creation_date;
		$this->rating = new Twickit_Rating($inXml->rating);
		$this->user = new Twickit_User($inXml->user);
	}
	

	// ---------------------------------------------------------------------
	// ----- Getter --------------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Get the ID of the Twick.
	 *
	 *	@return the ID.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *	Get the acronym (if specified) of the Twick.
	 *
	 *	@return the acronym.
	 */
	public function getAcronym() {
		return $this->acronym;
	}

	/**
	 *	Get the text (at most 140 characters) of the Twick.
	 *
	 *	@return the text.
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 *	Get the the link to further information (if specified).
	 *
	 *	@return the link.
	 */
	public function getLink() {
		return $this->link;
	}
	
	/**
	 *	Get the URL to the topic page at Twick.it added by an anker to
	 *	this Twick.
	 *
	 *	@see getStandaloneUrl()
	 *	@return the url.
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 *	Get the URL of a page where only this Twick is shown.
	 *
	 *	@see getUrl()
	 *	@return the url.
	 */
	public function getStandaloneUrl() {
		return $this->standaloneUrl;
	}
	
	/**
	 *	Get the creation date of the Twick.
	 *
	 *	@return the creation date.
	 */
	public function getCreationDate() {
		return $this->creationDate;
	}

	/**
	 *	Get the rating object of the Twick.
	 *
	 *	@see Twickit_Rating
	 *	@return the rating.
	 */
	public function getRating() {
		return $this->rating;
	}
	
	/**
	 *	Get the user object of the Twick.
	 *
	 *	@see Twickit::User
	 *	@return the user.
	 */
	public function getUser() {
		return $this->user;
	}
}
?>