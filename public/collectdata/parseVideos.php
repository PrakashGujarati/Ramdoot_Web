<?php
$file = fopen("videodata.csv","a");
fputcsv($file, array("subject_id","chapter_id","topic_name","sub_topic_name","url"));
getdata("93","661");
function getdata($subject_id,$chapter_id)
{
	$vars = 'id=660adcf2-0d31-4d14-b113-e318768f7f86&unique_key=64QUsi&fcm_id=c5Txo2eSSUOS0SAaNJAxxn:APA91bE_n7_bFjx-CPDGD97cViZXss0S5MFPLMMN3xMcl4JOTRpwomhsQTmFXjdwVOd718ctj3ELvCtCKGxXV9gcShRykeo8UYC3QXI3i1cVKOG4xSKpUHhdsTailaDqqEpiOTfpNDND&subject_id='.$subject_id.'&chapter_id='.$chapter_id.'&v_code=52';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.studentbro.in/Chapter/GetLectureVideo");
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
	$data = json_decode($server_output);
	
	foreach($data->data as $chapterdata)
	{
		foreach($chapterdata->SubTopic as $topicvideo)
		{
			//echo $topicvideo->topic_name."<br>";
			//echo $topicvideo->sub_topic_name."<br>";
			//echo $topicvideo->url."<br>";
			$file = fopen("videodata.csv","a");
			fputcsv($file, array($subject_id,$chapter_id,$topicvideo->topic_name,$topicvideo->sub_topic_name,$topicvideo->url));
		}
	}
}
fclose($file);