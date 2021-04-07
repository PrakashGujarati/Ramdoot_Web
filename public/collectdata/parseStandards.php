<?php

$file = fopen("standarddata.csv","a");
fputcsv($file, array("board","standard_id","name","remark","s_position"));
getdata("19");
function getdata($board)
{
	$vars = 'id=660adcf2-0d31-4d14-b113-e318768f7f86&unique_key=64QUsi&board='.$board;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.studentbro.in/User/getAllStandardBoardWise");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$headers = [
		'Accept-Encoding: gzip',    
		'Connection: Keep-Alive',
		'Cache-Control: no-cache',    
		'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
		'Host: api.studentbro.in',
		'User-Agent: okhttp/3.12.0'    
	];

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$server_output = curl_exec ($ch);
	curl_close ($ch);

	//print $server_output;
	$data = json_decode($server_output)->data;
	foreach($data as $node)
	{
		foreach($node->standard as $standard)
		{
			//echo $topicvideo->id."<br>";
			//echo $standard->name."<br>";
			//echo $topicvideo->board."<br>";
			//echo $topicvideo->s_position."<br>";
			//echo $topicvideo->remark."<br>";
			$file = fopen("standarddata.csv","a");
			fputcsv($file, array($standard->board,$standard->id,$standard->name,$standard->remark,$standard->s_position));
		}
	}
}
fclose($file);