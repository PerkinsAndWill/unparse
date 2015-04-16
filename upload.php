<?php
// sorry this is uncommented, trying to make it really quickly
$download = false;
if(isset($_POST['download']) && $_POST['download'] == 'on')
	$download = true;
$date_string = date("Y-m-d_h-i-s");
$report_dir = "report/" . $date_string . "/";
if(!file_exists($report_dir))
	mkdir($report_dir,0777,true);
$target_dir = $report_dir.'data/';
if(!file_exists($target_dir))
	mkdir($target_dir,0777,true);
$files = Array("activity","deck","task");
$filesOk = false;
$target_files = Array();
foreach($files as $index => $file_name){
	$target_files[$file_name] = $target_dir;
}
try{
	if(!isset($_POST["submit"]))
		throw new Exception("No POST data.");
	foreach($target_files as $file_name => $file){
		$target_files[$file_name] .= basename($_FILES[$file_name]["name"]);
		$file = $target_files[$file_name];
		if(file_exists($file)){
			$filesOk = true;
			continue;
		}
		$fileType = pathinfo($file,PATHINFO_EXTENSION);
		if($fileType != "json")
			throw new Exception("File ".$file." is not a JSON file");
		if(!move_uploaded_file($_FILES[$file_name]["tmp_name"],$file))
			throw new Exception("Could not move uploaded file to ".$target_dir);
	}
	$filesOk = true;
}catch( Exception $e){
	echo $e->getMessage() . "<br>\n";
}
if(!$filesOk)
	die("Files not present.<br>\n");
$fileData = Array();
$task_obj = json_decode(file_get_contents($target_files['task']))->results;
$tasks = Array();
foreach($task_obj as $index => $task){
	$tasks[$task->objectId] = $task;
}
$deck_obj = json_decode(file_get_contents($target_files['deck']))->results;
$decks = Array();
foreach($deck_obj as $index => $deck){
	$decks[$deck->objectId] = $deck;
}
$activity_obj = json_decode(file_get_contents($target_files['activity']))->results;
$activities = Array();
foreach($activity_obj as $index => $activity){
	$activities[$activity->objectId] = $activity;
}
include 'report.php';
?>