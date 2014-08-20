<?php
/*
Instances of this class holds information about the rating of twick including
number of votes, the sum of all ratings ant the ratio of the both values.

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
class Twickit_Rating {

	// ---------------------------------------------------------------------
	// ----- Attributes ----------------------------------------------------
	// ---------------------------------------------------------------------
	private $count;
	private $sum;
	private $ratio;
	
	
	// ---------------------------------------------------------------------
	// ----- Constructor ---------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Creates a new Rating instance.
	 *
	 *	@param SimpleXMLElement $inXml XML data return by the api call.
	 */
	public function __construct($inXml) {      
		$this->count = (int)$inXml->count;
		$this->sum = (int)$inXml->sum;
		$this->ratio = (float)$inXml->ratio;
	}
	

	// ---------------------------------------------------------------------
	// ----- Getter --------------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Get the number of votes.
	 *
	 *	@return int the rating count.
	 */
	public function getCount() {
		return $this->count;
	}
	
	
	/**
	 *	Get the of rating sum. 
	 *
	 *	@return int the rating sum.
	 */
	public function getSum() {
		return $this->sum;
	}


	/**
	 *	Get the ratio of rating sum and count as procent value. Thus a value 
	 *	of 100 means thatall ratings are positive. 
	 *
	 *	@return float the rating ration.
	 */
	public function getRatio() {
		return $this->ratio;
	}
}
?>