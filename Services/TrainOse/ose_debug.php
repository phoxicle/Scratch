<?php

$from = $_GET['from'];
$to = $_GET['to'];

// Get code for to/from
require('trainose_sdata.php');
$trainData = json_decode($sta8moi); // imported from trainose_sdata
$toCode = '';
$fromCode = '';
foreach ($trainData as $station) {
	if (!$toCode && ($station->gr == $to || $station->en == $to)) {
		$toCode = $station->code;	
	}
	if (!$fromCode && ($station->gr == $from || $station->en == $from)) {
		$fromCode = $station->code;
	}
	
	if ($toCode && $fromCode) break;
}

$params = array(
	'lang' => 'gr',
	'c' => 'dromologia',
	'op' => 'vres_dromologia',
	'travel_type' => 'metabash',
	'rtn_date' => '',
	'rtn_time' => '',
	'rtn_time_type' => '',
	'apo' => $fromCode,
	'pros' => $toCode,
	'date' => date('Y-m-d'),
	'time_type' => 'anaxwrihi',
	'time' => '23:59',
);
$additionalParams = '&trena[+]=apla&trena[+]=ic&trena[+]=ice&trena[+]=bed';
$url = 'http://tickets.trainose.gr/dromologia/ajax.php?' . http_build_query($params) . $additionalParams;
$jsonContents = file_get_contents($url);
$jsonArr = json_decode($jsonContents);

$routes = $jsonArr->data->metabash;
$routesArr = array();
foreach ($routes as $route) {
	
	//note: only take first segment
	$trainNum = $route->segments[0]->treno;
	if ($trainNum > 1500) { //array(1590,1592,1594,1596,1598,2590,2594,2598,3590) 
		$train = 'ΠΡΟ'; // Ηλεκτροκίνητο
	} else if (in_array($trainNum,array(52,53,54,55,70,71,74,75))) {
		$train = 'IC'; // Intercity
	} else if (in_array($trainNum,array(50,51,56,57))) {
		$train = 'ICE';	// Intercity Express
	} else if (in_array($trainNum,array(500,501,502,503))) {
		$train = 'ΤΑΧ'; // Ταχεία προτεραιότητας
	} else if (in_array($trainNum,array(604,605))) {
		$train = 'ΜΙΚ'; //	Μικτό προτεραιότητος
	} else if (in_array($trainNum,array(504,505))) {
		$train = 'ΚΛΙ'; // Κλινοθέσιο
	} else if (in_array($trainNum,array(592))) {
		$train = 'ΑΠΛ'; // Κοινή αμαξοστοιχία
	} else {
		$train = $trainNum;	
	}
	$routesArr[] = array(
		'duration' => $route->ttt,
		'train' => $train . ' ' . $trainNum, 
		'depart' => formatTime($route->segments[0]->wra1),
		'arrive' => formatTime($route->segments[0]->wra2),
		'delay' => $route->segments[0]->delay,
	);
}

$routesXml = '<xml><routes>';
foreach ($routesArr as $route) {
	$routesXml .= '
	<route>
		<train>'.$route['train'].'</train>
		<depart>'.$route['depart'].'</depart>
		<arrive>'.$route['arrive'].'</arrive>
		<duration>'.$route['duration'].'</duration>
		<stops>'.'TODO'.'</stops>
		<delay>'.$route['delay'].'</delay>
		<price>'.'TODO'.'</price>
	</route>';
}
$routesXml .= '</routes></xml>';



header('Content-type: text/xml');
echo $routesXml;


function formatTime($time) {$m = $time;
	list($hour,$min) = explode('.',$time);
	while (strlen($hour) < 2) $hour = '0' . $hour;
	while (strlen($min) < 2) $min = $min . '0';
	return $hour . ':' . $min;
}

/*



die();
// Get page contents
$fields = array(
    'from' => $from,
    'to' => $to,
    'hour_from' => '-',
    'hour_to' => '-',
    'send' => '1',
    'submitform' => 'Αναζήτηση',
);
$html = http_post_fields("http://www.trainose.com/content/wizards", $fields);
 
 // Create DOM object
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->resolveExternals = true;
@$doc->loadHTML($html);
 
 // Retrieve the TRs in question
$xpath = new DOMXPath($doc);
$rows = $xpath->query("//table [@class = 'tbl_data' ]/tr");

// Create XML
$rowNum = 0;
$routesXml = '<xml><routes>';
foreach ($rows as $row) {
	if ($rowNum++ < 1) continue;
	$td = $row->firstChild;
	$routesXml .= '
	<route>
		<train>'.$td->textContent.'</train>
		<depart>'.$td->nextSibling->textContent.'</depart>
		<arrive>'.$td->nextSibling->nextSibling->textContent.'</arrive>
		<duration>'.$td->nextSibling->nextSibling->nextSibling->textContent.'</duration>
		<stops>'.$td->nextSibling->nextSibling->nextSibling->nextSibling->textContent.'</stops>
	</route>';
}
$routesXml .= '</routes></xml>';
 
header('Content-type: text/xml');
echo $routesXml;

*/



?>
