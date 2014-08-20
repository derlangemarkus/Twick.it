<?php
/*
Simple test script that shows how to call the Twick.it api. Just
call the static methods of the Twickit_Twickit class.

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
require_once "Twickit.class.php";

ini_set("display_errors", 1);
echo("<pre>");
print_r(Twickit_Twickit::findTopicsNearby(50, 8, 10000, 10));
exit;
print_r(Twickit_Twickit::explain("RSS"));
print_r(Twickit_Twickit::favorites("derlangemarkus"));
print_r(Twickit_Twickit::findTopicByTag("lied"));
print_r(Twickit_Twickit::findTopic("aster"));
print_r(Twickit_Twickit::findTwick(1));
print_r(Twickit_Twickit::findUser("derlangemarkus"));
print_r(Twickit_Twickit::latestTwicks(3));
print_r(Twickit_Twickit::randomTwick(3));
print_r(Twickit_Twickit::randomTopic(3));
print_r(Twickit_Twickit::searchTwick("simpson"));
print_r(Twickit_Twickit::stats());
echo("</pre>");
?>