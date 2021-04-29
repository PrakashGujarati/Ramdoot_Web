<?php
$utoken="dWkMsvDzR-GLb-OJg1byo7:APA91bF-sisz1ifoNqW9SludcIu2aCtbnwVPdcdfGButhbgZI5vVs6rLXDpY7pInrOK_4uubV4T6reIPKZoHzzcgMMcyvFaHnibMDeNEFPdiZj4V91B8I5GiU9r9ybIIUTRlbZsYWmbu";
$title="title for notification";
$message="message body";
push_notification($utoken, $message, $title);

function push_notification($utoken, $message, $title = null) {
      
                $API_ACCESS_KEY = 'AIzaSyCC3WAurKIK_h3h39QXxMm3_M2u61C_CkM';

                $headers = array
                (
                'Authorization: key=' . $API_ACCESS_KEY,
                'Content-Type: application/json'
                );                

                $token = $utoken;

                $msg = array(
                'alert' => $message,
                'title' => $title,
                'message' => $message,
                'notification_type' => "",
                'user_type' => "",
                'sound' => 'default',
                'client_id' => "",
                'flag'=>"",
                );

                $notification = array(
                'title' => $title,
                'body' => $message,               
                'sound' => 'default',
                );
                

                $fields = array(
                'to' => $token,
                'data' => $msg,
                'priority' => 'high',
                'vibrate' => 1,             
                'notification' => $notification
                );
                    
                try {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                    
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $errMsg = '';
                    $res = (array) json_decode($result);

                    $errMsg = '';
                    
                    if (!empty($res)) {
                        if ($res['failure'] == 1) {
                            $errMsg = $res['results'][0]->error;
                        }
                    }
                    
                      
                } catch (Exception $e) {
                        Log::info("ERROR IN CACHE");
                }                    
   
}
?>