<?php
include 'php-ofc-library/open-flash-chart.php';

$title = $_GET["topic"];
$days = $_GET["days"];

$colors = array("#FF0000", "#00FF00", "#0000FF", "#00FFFF", "#FF00FF");
$chart = new open_flash_chart();
$chart->set_title(new title("Twicks zum Thema &quot;$title&quot;"));

$xml = simplexml_load_file("http://twick.it/interfaces/api/explain.xml?limit=-1&search=" . urlencode($title));
if ($xml && $xml->topics->children()) {
	$max = 1;
	$counter = 1;
	foreach($xml->topics->children() as $topic) {
		$twicks = $topic->twicks->twick;
		
		$dateCounter = array();
		foreach($twicks as $twick) {
			$date = substr($twick->creation_date, 0, 10);
			$dateCounter[$date] = 1 + (isset($dateCounter[$date]) ? $dateCounter[$date] : 0);
			$max = max($max, $dateCounter[$date]);
		}
		
		$data = array();
		$today = time();
		for ($i=$days; $i>=0; $i--) {
			$date = date("Y-m-d", $today-$i*60*60*24);
			list($y, $m, $d) = split("-", $date);
			$data["$d.$m.$y"] = isset($dateCounter[$date]) ? $dateCounter[$date] :  0;
		}
		
		$name = (string) $topic->title[0];
		
		$yAxis = new y_axis();
		$yAxis->set_range(0, $max+1, 1);
		$chart->set_bg_colour('#FFFFFF');
		$chart->set_y_axis($yAxis);
		
		$xLabels = array();
		
		$line = new bar();
		$line->set_values(array_values($data));
		$line->set_key($name, 10);
		$line->set_tooltip($name . ": #val#");
		$line->set_colour($colors[$counter % sizeof($colors)]);
		
		$chart->add_element($line);
		
		
		$xAxis = new x_axis();
		$xAxis->set_steps(ceil($days/10));
		$xAxis->set_labels_from_array(array_keys($data));
		
		$chart->set_x_axis($xAxis);
		$counter++;
	}
}

echo $chart->toPrettyString(); 
?>
