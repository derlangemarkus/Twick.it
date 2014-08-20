<?
/*
Twick.it specific Exception which is thrown if a mandatory parameter is missing 
when you call a method.

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
class Twickit_TwickitMissingParameterException extends Exception{
    
    // ---------------------------------------------------------------------
	// ----- Attributes ----------------------------------------------------
	// ---------------------------------------------------------------------
	private $parameterName;
	private $errormessage;


	// ---------------------------------------------------------------------
	// ----- Constructor ---------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Creates a new Exception.
	 *
	 *	@param string $inParameterName The name of the missing parameter.
	 */
	public function __construct($inParameterName) {      
		$this->parameterName = $inParameterName;
	}
	
	
	// ---------------------------------------------------------------------
	// ----- Getter --------------------------------------------------------
	// ---------------------------------------------------------------------
	/**
	 *	Get the name of the missing parameter.
	 *
	 *	@return string The name of the parameter.
	 */
	public function getParameterName() {
		return $this->parameterName;
	}
	
	
	/**
	 *	Get an error message including the name of the missing parameter.
	 *
	 *	@return string The error message.
	 */
	public function getErrorMessage() {
		return "Please specify the mandatory paramater '". $this->getParameterName() . "'.";
	}
}
?>