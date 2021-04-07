<?php
$file = fopen("chapterdata.csv","a");
fputcsv($file, array("board","standard_id","semester","subject_id","chapter_id","name","drive_link","icon_url","video_count","material_count"));
getdata("93");
function getdata($subject_id)
{
	$vars = 'id=660adcf2-0d31-4d14-b113-e318768f7f86&unique_key=64QUsi&subject_id='.$subject_id.'&v_code=52';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://api.studentbro.in/Chapter/getSubjectChapter");
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
	
	foreach($data as $lec)
	{
		foreach($lec->lec as $chapter)
		{
			$file = fopen("chapterdata.csv","a");
			fputcsv($file, array($chapter->board,$chapter->std,$chapter->semester,$subject_id,$chapter->id,$chapter->name,$chapter->drive_link,$chapter->icon_url,$chapter->l_cnt,$chapter->m_cnt));
		}
	}
}
fclose($file);