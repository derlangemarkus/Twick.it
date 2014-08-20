<?php

require_once("../../util/inc.php");
require(DOCUMENT_ROOT . '/util/thirdparty/fpdf/AlphaPDF.php');

class TwickitSupertrumpfPDF extends FPDF {

    const offsetX = 30;
    const offsetY = 35;
    const cardsPerRow = 2;
    const rowsPerPage = 2;

	public function Header() {
		$this->Image("http://twick.it/html/img/logo.jpg", 175, 10, 20);
		
		$this->SetXY(10, 5);
		$this->SetFontSize(24);
		$this->MultiCell(200, 22, "Twick.it Supertrumph");
	}
	
	
	public function Footer() {
		$this->SetXY(10, 270);
		$this->SetFontSize(8);
		$this->MultiCell(200, 22, "Ein Spiel von Twick.it (http://twick.it)");
	}
	
	
	public function printIntro() {
		$this->AddPage();
		
		$this->SetFontSize(12);
		$this->MultiCell(180, 12, utf8_decode("Mit Twick.it Supertrumph wirst DU zum Joker. Und so einfach geht's:\n1) Dieses Dokument ausdrucken.\n2) Karten ausschneiden.\n3) Karten mischen und unter den Mitspielern verteilen.\n4) Jeder Spieler bildet aus seinen Karten einen Stapel.\n5) Beliebigen Wert einer Karte vorlesen.\n6) Der Spieler, der den höchsten Wert hat, gewinnt die Karten der Mitspieler und darf einen Wert der nächsten Karte aussuchen.\n7) Der Spieler, der zum Schluss alle Karten hat, gewinnt."));
		
		$this->Image('front_card.jpg', 80, 160, 66);
	}
		
	
    public function printCards() {
		$this->AddPage();
		$chars = array("A", "B", "C", "D");

        $numberOfCards = getArrayElement($_GET, "cards", 32);
        $namedUsers = explode(",", getArrayElement($_GET, "users", ""));
        if (!$namedUsers[0]) {
            array_shift($namedUsers);
        }


        $users = array();
        foreach($namedUsers as $user) {
            $users[] = User::fetchById($user);
        }

        $randomCards = $numberOfCards - sizeof($namedUsers);
        if ($randomCards > 0) {
            $random = User::fetch(array("deleted"=>0), false, array("ORDER BY"=>"rand()", "LIMIT"=>4*$numberOfCards));
			foreach($random as $randomUser) {
				if(!in_array($randomUser, $users)) {
					$users[] = $randomUser;
				}
			}
        }

        $numberOfFetchedUsers = sizeof($users);

        $counter = 0;
        foreach ($users as $user) {
			if($counter >= $numberOfCards) {
				break;
			}

            $numberOfTwicks = $user->findNumberOfTwicks();
            $ratingSum = $user->getRatingSumCached();
            $ratingCount = $user->findNumberOfRatings();

            if (
                $numberOfTwicks < 2 &&
                $ratingCount < 2 &&
                $numberOfFetchedUsers-$counter > $numberOfCards-$counter &&
                !in_array($user->getId(), $namedUsers)
            ) {
                // Lullis raus!
                continue;
            }


            $number = floor(1 + $counter/4);
            $char = $chars[$counter%4];
            $row = floor($counter / self::cardsPerRow) % self::rowsPerPage;
            $col = $counter%self::cardsPerRow;

            $x = self::offsetX+$col*85;
            $y = self::offsetY+$row*120;

            $this->Image('card.jpg', $x, $y, 66);

            $this->Image(HTTP_ROOT . "/playground/supertrumpf/gravatar.php?id=" . $user->getId(), $x+15.2, $y+15.55, 36.2, 36.2, "jpg");

			$this->SetFontSize(10);
            $this->SetTextColor(255, 255, 255);

            $this->SetXY($x+8, $y+8.3);
            $this->MultiCell(10, 10, $number . $char);

            $this->SetXY($x+14, $y+8.3);
            $this->MultiCell(66, 10, utf8_decode(substringAfter($user->getLogin(), ":")));

            $this->SetFontSize(8);
            $this->SetTextColor(0, 0, 0);

            $this->SetXY($x+14, $y+50.3);
            $this->MultiCell(55, 10, "Twick.it-Rang:");

            $this->SetXY($x+14, $y+55.6);
            $this->MultiCell(55, 10, "Anzahl Twicks:");

            $this->SetXY($x+14, $y+61);
            $this->MultiCell(55, 10, "Bewertungspunkte:");

            $this->SetXY($x+14, $y+66.5);
            $this->MultiCell(55, 10, "Abgegebene Bewertungen:");

            $this->SetXY($x+14, $y+71.8);
            $this->MultiCell(55, 10, "Dabei seit:");

            $this->SetXY($x, $y+50.3);
            $this->MultiCell(59.6, 10, $user->findRatingPosition(), 0, "R");

            $this->SetXY($x, $y+55.5);
            $this->MultiCell(59.6, 10, $numberOfTwicks, 0, "R");

            $this->SetXY($x, $y+61);
            $this->MultiCell(59.6, 10, $ratingSum, 0, "R");

            $this->SetXY($x, $y+66.6);
            $this->MultiCell(59.6, 10, $ratingCount, 0, "R");

            $this->SetXY($x, $y+71.8);
            $this->MultiCell(59.6, 10, substringBefore($user->getCreationDate(), "-"), 0, "R");
			
			if ($row == self::rowsPerPage-1 && $col == self::cardsPerRow-1 && $counter < $numberOfCards-1) {
                $this->AddPage();
            }

            $counter++;
        }
    }
	
	function Error($inText) {}
}

ini_set("max_execution_time", 6000000);

$pdf = new TwickitSupertrumpfPDF('P','mm','A4');
$pdf->SetFont('Arial', '', 10);
$pdf->printIntro();
$pdf->printCards();
$pdf->Output();
?>