<?php
// assumes $download, $tasks, $activities, and $decks already built
if($download){
	header('Content-Type: application/excel');
	header('Content-Disposition: attachment; filename="'.$date_string.'.csv"');
	$fp = fopen('php://output','w');
}else
	$fp = fopen($report_dir.$date_string.'.csv','w');
fputcsv($fp,Array('installation','deck','date','question','response'));
foreach($activities as $id => $activity){
	$inst = $activity->installation;
	if(!isset($activity->deck))
		continue;
	if(!isset($activity->taskResponse))
		continue;
	$deck = $decks[$activity->deck];
	$deckName = $deck->objectId;
	$date = $activity->createdAt;
	if(isset($deck->name))
		$deckName = $deck->name;
	$answers = Array();
	foreach($activity->taskResponse as $taskId => $response_value){
		if(!isset($tasks[$taskId]))
			continue;
		$answers[] = Array($tasks[$taskId]->title,$response_value);
	}
	foreach($answers as $inded => $answer){
		fputcsv($fp,Array($inst,$deckName,$date,$answer[0],$answer[1]));
	}
}
fclose($fp);
echo '<a href="'.$report_dir.$date_string.'.csv">'.$date_string.'.csv</a>';
?>