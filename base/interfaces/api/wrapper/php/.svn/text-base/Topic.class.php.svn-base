<?php
/*
This class represents a topic at Twick.it. A topic consists of a title,
some tags and several Twicks.

@author		Markus Möller (Twick.it)
@link 		http://twick.it Twick.it homepage
@link 		http://twick.it/blog/en/for-developers/api/ API documentation
@version	1.0
@licence	BSD License

Copyright (c) 2010, Markus M�ller
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
class Twickit_Topic {

	// ---------------------------------------------------------------------
	// ----- Attributes ----------------------------------------------------
	// ---------------------------------------------------------------------
	private $id;
	private $title;
	private $url;
	private $tags;
	private $twicks;
    private $latitude;
    private $longitude;
	
	
	// ---------------------------------------------------------------------
	// ----- Constructor ---------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Creates a new Topic instance.
	 *
	 *	@param SimpleXMLElement $inXml XML data return by the api call.
	 */
	public function __construct($inXml) {      
		$this->id = (int)$inXml->id;
		$this->title = (string)$inXml->title;
		$this->url = (string)$inXml->url;

		if ($inXml->twick) {
			$this->twicks = array(new Twickit_Twick($inXml->twick));
		} else {		
			$twicks = array();
			foreach($inXml->twicks as $xtwick) {
				$twick = new Twickit_Twick($xtwick->twick);
				$twicks[] = $twick;
			}
			$this->twicks = $twicks;
		}
		
		$tags = array();
		foreach($inXml->tags->children() as $xtags) {
			$attributes = $xtags->attributes();
			$tags[(string)$xtags] = (int)$attributes["count"];
		}
		$this->tags = $tags;

        if($inXml->geo) {
            $this->latitude = $inXml->geo->latitude->asXML();
            $this->longitude = $inXml->geo->longitude->asXML();
        }
	}
	

	// ---------------------------------------------------------------------
	// ----- Getter --------------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Get the ID of the topic.
	 *
	 *	@return the ID.
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *	Get the title of the topic.
	 *
	 *	@return the title.
	 */
	public function getTitle() {
		return $this->title;
	}	
	
	/**
	 *	Get the url to the topic page at Twick.it.
	 *
	 *	@return the url.
	 */
	public function getUrl() {
		return $this->url;
	}
	
	/**
	 *	Get an array of tags, where the tags are the keys. The values shows
	 *	the number of occurences.
	 *	<code>
	 *		"tag1" => 3,
	 *		"tag2" => 1,
	 *		"tag3" => 1
	 *	</code>
	 *
	 *	@return the tags as array.
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 *	Get an array of Twicks for this topic.
	 *
	 *	@see Twickit_Twicks
	 *	@return the Twicks.
	 */
	public function getTwicks() {
		return $this->twicks;
	}

    /**
	 *	Get latitude for this topic.
	 *
	 *	@return the latitude.
	 */
	public function getLatitude() {
		return $this->latitude;
	}

    /**
	 *	Get longitude for this topic.
	 *
	 *	@return the longitude.
	 */
	public function getLongitude() {
		return $this->longitude;
	}

    /**
     * Check wether the topic has geo coordinates.
     *
     * @return bool true, if there are coordinates.
     */
    public function hasCoordinates() {
        return $this->getLatitude() != null && $this->getLongitude();
    }
}
?>