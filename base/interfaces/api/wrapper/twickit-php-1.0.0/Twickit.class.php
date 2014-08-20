<?php
/*
Provides a mapper for the Twick.it REST-API. You can simply call the (static)
methods of this class. You don't have to take care of all the REST stuff (like
sending http-requests and parsing XML data).

If you create any cool gadgets for Twick.it please let us now. We're looking
forward to many interessting mashups :-)


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
require_once dirname(__FILE__)."/Twickit.class.php";
require_once dirname(__FILE__)."/Twick.class.php";
require_once dirname(__FILE__)."/Topic.class.php";
require_once dirname(__FILE__)."/User.class.php";
require_once dirname(__FILE__)."/UserInfo.class.php";
require_once dirname(__FILE__)."/Rating.class.php";


class Twickit_Twickit {

	// ---------------------------------------------------------------------
	// ----- Public methods ------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Retrieves the explanation of a topic by returning the best Twick(s).
	 *  @link http://twick.it/blog/en/for-developers/api/explain/
	 *
	 *	@param string	$inSearch 	Name of the topic
	 *	@param int 		$inLimit 	Number of Twicks. A number less or
	 *								equal 0 means no limitation.
	 *	@param bool		$inSimilar	Also search for similar topic titles if
	 *								true is specified as parameter value.
	 *								Otherwise the title must exactly match
	 *								the search term.
	 *	@param bool		inSkipHononyms	Do not show homonyms (=ambiguous
	 *								meanings) if true is specified as
	 *								parameter value.
	 *	@param string	$inLng 		Language in with the topic should be
	 *								explained.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function explain($inSearch, $inLimit=null, $inSimilar=null, $inSkipHononyms=null, $inLng=null) {
        $url = "http://twick.it/interfaces/api/explain.xml";
		self::_addUrlParameter($url, "search", $inSearch, true);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addBooleanUrlParameter($url, "similar", $inSimilar);
		self::_addBooleanUrlParameter($url, "skipHomonyms", $inSkipHononyms);
		self::_addUrlParameter($url, "lng", $inLng);
		return self::_getTopics($url);
	}


	/**
	 *	Retrieves favorite Twicks of a specific user.
	 *  @link http://twick.it/blog/en/for-developers/api/favorites/
	 *
	 *	@param string	$inUser 	The username.
	 *	@param int 		$inLimit 	Number of Twicks. A number less or
	 *								equal 0 means no limitation.
	 *	@param string	$inLng 		language in with the should be searched.
	 *  @return array 	An array with Twick elements.
	 *	@see Twickit_Twick
	 */
	public static function favorites($inUser, $inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/favorites.xml";
		self::_addUrlParameter($url, "user", $inUser, true);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTwicks($url);
	}


	/**
	 *	Retreives all topics witch tag clouds includes a specific search term.
	 *  @link http://twick.it/blog/en/for-developers/api/find_topic_by_tag/
	 *
	 *	@param string	$inSearch 	Search term which should be included in
	 *								the topic's tag cloud.
	 *	@param int 		$inLimit 	Number of topics. A number less or
	 *								equal 0 means no limitation.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function findTopicByTag($inSearch, $inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/find_topic_by_tag.xml";
		self::_addUrlParameter($url, "search", $inSearch, true);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Retrieves all topics which includes a given search term. Only the
	 *	topic's title is searched for the search term not the Twicks.
	 *  @link http://twick.it/blog/en/for-developers/api/find_topic/
	 *
	 *	@param string	$inSearch 	Search term that should be included
	 *								in the topic.
	 *	@param int 		$inLimit 	Number of Twicks. A number less or
	 *								equal 0 means no limitation.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function findTopic($inSearch, $inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/find_topic.xml";
		self::_addUrlParameter($url, "search", $inSearch, true);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Retrieves a Twick with a given ID.
	 *  @link http://twick.it/blog/en/for-developers/api/find_twick/
	 *
	 *	@param int 		$inId 		ID of the Twick.
	 *  @return Twickit_Twick		The Twick with the given ID.
	 *	@see Twickit_Twick
	 */
	public static function findTwick($inId) {
		$url = "http://twick.it/interfaces/api/find_twick.xml";
		self::_addUrlParameter($url, "id", $inId, true);

		return self::_getTwick($url);
	}


	/**
	 *	Retrieves data of a specific user.
	 *  @link http://twick.it/blog/en/for-developers/api/find_user/
	 *
	 *	@param string	$inSearch 	The username.
	 *	@param bool		$inExact 	Should the username match exactly
	 *								(true) or are users returned which
	 *								username includes the search term
	 *								as a substring (false).
	 *  @return array 	An array with UserInfo elements.
	 *	@see Twickit_UserInfo
	 */
	public static function findUser($inSearch, $inExact=null) {
		$url = "http://twick.it/interfaces/api/find_user.xml";
		self::_addUrlParameter($url, "search", $inSearch, true);
		self::_addBooleanUrlParameter($url, "exact", $inExact);

		$xml = simplexml_load_file($url);
		$users = array();
		foreach($xml->users as $xuser) {
			$users[] = new Twickit_UserInfo($xuser->user);
		}
		return $users;
	}


	/**
	 *	Retrieves the latest (=newest) Twicks.
	 *  @link http://twick.it/blog/en/for-developers/api/latest_twicks/
	 *
	 *	@param int 		$inLimit 	Number of Twicks.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function latestTwicks($inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/latest_twicks.xml";
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Retrieves one or more random Twicks.
	 *  @link http://twick.it/blog/en/for-developers/api/random_twick/
	 *
	 *	@param int 		$inLimit 	Number of Twicks.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function randomTwick($inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/random_twick.xml";
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Retrieves one or more random topics.
	 *  @link http://twick.it/blog/en/for-developers/api/random_topic/
	 *
	 *	@param int 		$inLimit 	Number of topics.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function randomTopic($inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/random_topic.xml";
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Retrieves all Twicks, which contain a given search term.
	 *  @link http://twick.it/blog/en/for-developers/api/search_twick/
	 *
	 *	@param string	$inSearch	Search term which just be contained
	 *								in the Twicks.
	  *	@param int 		$inLimit 	Number of topics.
	 *	@param string	$inLng 		Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function searchTwick($inSearch, $inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/search_twick.xml";
		self::_addUrlParameter($url, "search", $inSearch, true);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		return self::_getTopics($url);
	}


	/**
	 *	Returns some Twick.it statistics (number of Twicks/topics/users) both
	 *	for the current language and as the sum over all languages.
	 *  @link http://twick.it/blog/en/for-developers/api/stats/
	 *
	 *	@param string	$inLng 		Language for which the statistik should 
	 *								be returned.
	 *  @return array 	An array with the keys <code>numberOfTopics, 
	 *					numberOfTopicsInLanguage, numberOfTwicks, 
	 *					numberOfTwicksInLanguage, numberOfUsers, 
	 *					numberOfUsersInLanguage</code>.
	 *	@see Twickit_Topic
	 */
	public static function stats($inLng=null) {
		$url = "http://twick.it/interfaces/api/stats.xml";
		self::_addUrlParameter($url, "lng", $inLng);

		$xml = simplexml_load_file($url);

		return
			array(
				"numberOfTopics" => (int)$xml->numberOfTopics,
				"numberOfTopicsInLanguage" => (int)$xml->numberOfTopicsInLanguage,
				"numberOfTwicks" => (int)$xml->numberOfTwicks,
				"numberOfTwicksInLanguage" => (int)$xml->numberOfTwicksInLanguage,
				"numberOfUsers" => (int)$xml->numberOfUsers,
				"numberOfUsersInLanguage" => (int)$xml->numberOfUsersInLanguage
			);
	}


    /**
	 *	Find topics that are located nearby a position specified by a
     *  geocoordinate (latitude + longitude). Latitude and longitude are
     *  given as floats that specify an angle. Negative values means south
     *  resp. west.
     *
	 *  @link http://twick.it/blog/en/for-developers/api/topics_nearby/
	 *
     *	@param float	$inLatitude 	Latitude of the position.
     *	@param float	$inLongitude 	Longitude of the position.
     *  @param int 		$inRadius       Radius of the search in meters.
	 *	@param int 		$inLimit        Number of Twicks.
	 *	@param string	$inLng          Language in with the should be searched.
	 *  @return array 	An array with Topic elements.
	 *	@see Twickit_Topic
	 */
	public static function topicsNearby($inLatitude, $inLongitude, $inRadius, $inLimit=null, $inLng=null) {
		$url = "http://twick.it/interfaces/api/topics_nearby.xml";
        self::_addUrlParameter($url, "latitude", $inLatitude, true);
        self::_addUrlParameter($url, "longitude", $inLongitude, true);
        self::_addUrlParameter($url, "radius", $inRadius);
		self::_addUrlParameter($url, "limit", $inLimit);
		self::_addUrlParameter($url, "lng", $inLng);

		$xml = simplexml_load_file($url);
		$topics = array();
		foreach($xml->topics->children() as $xtopic) {
			$topic = new Twickit_Topic($xtopic);
            $topics[] = array($topic, (int)$xtopic->distance);
		}
        return $topics;
	}


	// ---------------------------------------------------------------------
	// ----- Private methods -----------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Adds a parameter to the REST url.
	 *	
	 *	@param string	$inoutUrl			The url.
	 *	@param string	$inParameterName	Name of the parameter.
	 *	@param string	$inParameterValue	Value of the parameter.
	 *	@param bool		$inIsMandatory		Is it a mandatory parameter?
	 *	@param bool		$inIsBoolean		Converts boolean values to 0 resp. 
	 *										1 if true.
	 */
	private static function _addUrlParameter(&$inoutUrl, $inParameterName, $inParameterValue, $inIsMandatory=false, $inIsBoolean=false) {
		if ($inIsMandatory && trim($inParameterValue) == "") {
			throw new TwickitMissingParameterException($inParameterName);
		}

		if ($inParameterValue != null) {
			if (strpos($inoutUrl, "?") !== false) {
				$inoutUrl .= "&";
			} else {
				$inoutUrl .= "?";
			}
			if ($inIsBoolean) {
				$inoutUrl .= "$inParameterName=" . $inParameterValue ? 1 : 0;
			} else {
				$inoutUrl .= "$inParameterName=" . urlencode($inParameterValue);
			}
		}
	}


	/**
	 *	Adds a boolean parameter to the REST url. <code>true</code> will be
	 * 	converted to 1, <code>false</code> to 0.
	 *	
	 *	@param string	$inoutUrl			The url.
	 *	@param string	$inParameterName	Name of the parameter.
	 *	@param string	$inParameterValue	Value of the parameter.
	 *	@param bool		$inIsMandatory		Is it a mandatory parameter?
	 */
	private static function _addBooleanUrlParameter(&$inoutUrl, $inParameterName, $inParameterValue, $inIsMandatory=false) {
		self::_addUrlParameter(&$inoutUrl, $inParameterName, $inParameterValue, $inIsMandatory, true);
	}


	/**
	 *	Send a url request and converts the XML response to an array of
	 *	topics.
	 *
	 *	@param string	$inUrl	The url.
	 *	@return array	An array of topics.
	 *	@see Twickit_Topic
	 */
	private static function _getTopics($inUrl) {
		$xml = simplexml_load_file($inUrl);
		$topics = array();
		foreach($xml->topics->children() as $xtopic) {
			$topics[] = new Twickit_Topic($xtopic);
		}
		return $topics;
	}


	/**
	 *	Send a url request and converts the XML response to an array of
	 *	Twicks.
	 *
	 *	@param string	$inUrl	The url.
	 *	@return array	An array of Twicks.
	 *	@see Twickit_Twick
	 */
	private static function _getTwicks($inUrl) {
		$xml = simplexml_load_file($inUrl);
		$twicks = array();
		foreach($xml->twicks->children() as $xtwick) {
			$twicks[] = new Twickit_Twick($xtwick);
		}
		return $twicks;
	}


	/**
	 *	Send a url request and converts the XML response to a single
	 *	Twick.
	 *
	 *	@param string	$inUrl	The url.
	 *	@return Twickit_Twick	A Twicks.
	 *	@see Twickit_Twick
	 */
	private static function _getTwick($inUrl) {
		$xml = simplexml_load_file($inUrl);
		return new Twickit_Twick($xml->topic->twick);
	}
}
?>