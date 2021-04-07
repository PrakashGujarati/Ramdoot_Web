<?php
if(isset($_REQUEST['getStandardByBoard'])=="getStandardByBoard")
{
    getStandardData($_REQUEST['board_id']);
}

if(isset($_REQUEST['getSubjectByStandard'])=="getSubjectByStandard")
{
    getSubjectData($_REQUEST['board_id'],$_REQUEST['standard_id']);
}

if(isset($_REQUEST['getChapterBySubject'])=="getChapterBySubject")
{
    getChapterData($_REQUEST['subject_id']);
}

if(isset($_REQUEST['getVideosByChapter'])=="getVideosByChapter")
{
    getVideosData($_REQUEST['board_id'],$_REQUEST['standard_id'],$_REQUEST['subject_id'],$_REQUEST['chapter_id']);
}


function getStandardData($board)
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

    $data = json_decode($server_output)->data;
    
    echo '<option>Select Standard</option>';
	foreach($data as $node)
	{
		foreach($node->standard as $standard)
		{            
            echo '<option value="'.$standard->id.'">'.$standard->name.'</option>';
		}
	}
}

function getSubjectData($board,$std)
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
	
    $data = json_decode($server_output)->subject;

    echo '<option>Select Subject</option>';
	foreach($data as $subject)
	{
        echo '<option value="'.$subject->id.'">'.$subject->name.'</option>';		
	}
}

function getChapterData($subject_id)
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
    
	$data = json_decode($server_output)->data;
	echo '<option>Select Chapter</option>';
	foreach($data as $lec)
	{
		foreach($lec->lec as $chapter)
		{
            echo '<option value="'.$chapter->id.'">'.$chapter->name.'</option>';
		}
	}
}

function getVideosData($board_id,$standard_id,$subject_id,$chapter_id)
{
    try{
        $fnm = $board_id."_".$standard_id."_".$subject_id."_".$chapter_id."_videodata.csv";
        $file = fopen($fnm,"w");
        fputcsv($file, array("board_id","standard_id","subject_id","chapter_id","topic_name","sub_topic_name","url"));

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

        $data = json_decode($server_output);       
        
        if(isset($data->lectures))
        {
            foreach($data->lectures as $topicvideo)
            {
                $file = fopen($fnm,"w");
                    fputcsv($file, array($board_id,$standard_id,$subject_id,$chapter_id,$topicvideo->topic_name,$topicvideo->sub_topic_name,$topicvideo->url));
            }
        }

        if(isset($data->data))
        {
            foreach($data->data as $chapterdata)
            {
                foreach($chapterdata->SubTopic as $topicvideo)
                {
                    $file = fopen($fnm,"w");
                    fputcsv($file, array($board_id,$standard_id,$subject_id,$chapter_id,$topicvideo->topic_name,$topicvideo->sub_topic_name,$topicvideo->url));
                }
            }
        }   

        fclose($file);        
        echo "success - ".$fnm;

    }catch(Exception $e){
            
    }
}