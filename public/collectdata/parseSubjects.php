<?php
$file = fopen("subjectdata.csv","a");
fputcsv($file, array("board","standard_id","subject_id","name","icon_url","s_position"));
getdata("19","27");
function getdata($board,$std)
{
	$vars = 'id=660adcf2-0d31-4d14-b113-e318768f7f86&unique_key=64QUsi&board='.$board.'&std='.$std.'&fcm_id=c5Txo2eSSUOS0SAaNJAxxn:APA91bE_n7_bFjx-CPDGD97cViZXss0S5MFPLMMN3xMcl4JOTRpwomhsQTmFXjdwVOd718ctj3ELvCtCKGxXV9gcShRykeo8UYC3QXI3i1cVKOG4xSKpUHhdsTailaDqqEpiOTfpNDND'.'&v_code=52';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.studentbro.in/User/getBalance");
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
	$data = json_decode($server_output)->subject;
	foreach($data as $subject)
	{
		$file = fopen("subjectdata.csv","a");
		fputcsv($file, array($subject->board,$subject->std,$subject->id,$subject->name,$subject->icon_url,$subject->s_position));
		
	}
}
fclose($file);