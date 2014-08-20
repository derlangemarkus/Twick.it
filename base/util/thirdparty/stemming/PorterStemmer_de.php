<?php

	/*
	Basic PHP4 Implementation of a german variant of the Porter Stemmer Algorithm as described
	by Martin Porter. See http://snowball.tartarus.org/algorithms/german/stemmer.html for
	details.

	I've tested this script with a list of 35.000 german words against the the output of
	the german Snowball algorithm. It shows 17 differences but I was unable to find the
	reason for this	deviation.
	The algorithm isn't optimzed, it will take about 60 seconds for 35.000 words on an old
	Pentium 200 - feel free to modify and/or improve it :)

	Copyright (c) 2005 Andreas Hecht (ahecht@bochmann.de)

	All rights reserved.

	This script is free software.

	Usage:

		$stemmer = new PorterStemmer_de; // you can recycle this object
		  :
		$stem = $stemmer->stem ('stereoschallplattenwiedergabeanlage')

		All functions except stem() are private (it simply doesn't make sense to call
		it from outside).
	*/

	class PorterStemmer_de {

		var $v = '(?:[aeiouyäöü])';					// the vowels
		var $c = '(?:[^aeiouyäöü])';				// the non-vowels (consonants)
		var $s_ending = '(?:[bdfghklmnrt])';		// valid s-ending predecessors
		var $st_ending = '(?:[bdfghklmnt])';		// valid st-ending  predecessors
		var $word = '';
		var $r1 = '';
		var $p1 = 0;
		var $r2 = '';
		var $p2 = 0;

		function stem($word) {

			if (strlen ($word) <= 2) return $this->postlude($word);

			$this->word = $this->prelude(trim($word));

			/*
			Setting up R1 und R2 (quoting original description):
			"R1 is the region after the first non-vowel following a vowel, or  is the null region at
			 the end of the word if there  is no such non-vowel.
			 R2 is the region after the first non-vowel following a vowel in  R1, or is the null
			 region at the  end of the word if there is no such non-vowel."

			Note: If R1 is a null region it is not necessary to proceed because none of the further
			steps will have matching patterns. The stem function then will be return immediately after
			executing the postlude part.
			*/

			if (preg_match ("/^(?U)(.*$this->v$this->c)(?X)(.*)\$/", $this->word, $match)) {
				$this->p1 = strlen ($match[1]) < 3 ? 3 : strlen ($match[1]);
				$this->r1 = substr ($this->word, $this->p1);
			} else
				return $this->postlude($this->word);

			preg_match ("/^(?U)(.*$this->v$this->c.*$this->v$this->c)(?X)(.*)\$/", $this->word, $match);
			$this->p2 = strlen($match[1]);
			$this->r2 = $match[2];


			$this->step_1();

			$this->step_2();

			if ($this->p2 == 0)
				return $this->postlude($this->word);

			$this->step_3();

			return $this->postlude($this->word);
		}


		/*
			Step 1:

			Search for the longest among the following suffixes,

				(a) e   em   en   ern   er   es

				(b) s (preceded by a valid s-ending)

			and delete if in R1. (Of course the letter of the valid s-ending is not necessarily in R1)
		*/
		function step_1() {
			// a
			$this->word = preg_replace ("/^(.{".$this->p1.",})(?:e|em|en|ern|er|es)\$/", '\\1', $this->word);

			// b
			if (preg_match ("/(?:s)\$/", $this->r1) && preg_match ("/".$this->s_ending."(?:s)\$/", $this->word)) {
				$this->word = substr ($this->word,0,-1);
			}
		}


		/*
			Step 2:

			Search for the longest among the following suffixes,

				(a) en   er   est

				(b) st (preceded by a valid st-ending, itself preceded by at least 3 letters)

			and delete if in R1.
		*/
		function step_2() {
			// a
			$this->word = preg_replace ("/^(.{".$this->p1.",})(?:en|er|est)\$/", '\\1', $this->word);
			// b
			if (preg_match ("/st/", $this->r1) && preg_match ("/.{3,}".$this->st_ending."(st)\$/", $this->word)) {
				$this->word = substr ($this->word,0,-2);
			}
		}


		/*
		Step 3: d-suffixes

			Search for the longest among the following suffixes, and perform the action indicated.

			end   ung
				delete if in R2 if preceded by ig,
				delete if in R2 and not preceded by e

			ig   ik   isch
				delete if in R2 and not preceded by e

			lich   heit
				delete if in R2
				if preceded by er or en, delete if in R1

			keit
				delete if in R2
				if preceded by lich or ig, delete if in R2
		*/
		function step_3() {
			if (preg_match ("/(end|ung)/", $this->r2)) {
				$this->word = preg_replace ('/^((.*)[(ig)])(?:end|ung)$/','\\1', $this->word);
				$this->word = preg_replace ('/^((.*)[^e])(?:end|ung)$/','\\1', $this->word);
			}


			if (preg_match ("/(ig|ik|isch)/", $this->r2)) {
				$this->word = preg_replace ('/^(.*[^e])(ig|ik|isch)$/','\\1', $this->word);
			}


			if (preg_match ('/(lich|heit)/', $this->r2)) {
				if (preg_match ('/(er|en)(lich|heit)/', $this->r1)) {
					$this->word = preg_replace ('/^(.*)(er|en)(lich|heit)$/U','\\1', $this->word);
				}
				$this->word = preg_replace ('/^(.*)(lich|heit)$/','\\1', $this->word);
			}


			if (preg_match ("/keit/", $this->r2)) {
				$this->word = preg_replace ('/^(.*)keit$/','\\1', $this->word);
				if (preg_match ('/(lich|ig)(keit)/', $this->r2)) {
					$this->word = preg_replace ('/^(.*)(lich|ig)$/','\\1', $this->word);
				}
			}
		}

		/*
		Prelude
		The original description says: Replace ß by ss, and put u and y  between vowels into upper case.
		The Snowball algorithm shows a difference here: It only puts u between vowels in upper case. y
		is uppercased if only followed by a vowel.
		*/
		function prelude($word) {
			$search = array ("/ß/","/($this->v)u($this->v)/","/y($this->v)/");
			$replace = array ("ss","\\1U\\2","Y\\1");
			return preg_replace ($search, $replace, $word);
		}

		/*
		Postlude
		the umlaut accent will be removed from ä, ö and ü, and U and Y will be turned back into lower case.
		*/
		function postlude($word) {
			$search = array ("ä","ö","ü");
			$replace = array ("a","o","u");
			return mb_strtolower (str_replace ($search,$replace,$word), "utf-8");
		}
	}
?>