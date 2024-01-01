<?php

include 'config.php'; // literally just a normal php file, using this instead of .env cos i wanted to keep it completely packageless. Just remember to make sure config.php is included in our .gitignore so that any sensitive keys dont get committed to source!

if(!isset($env)){
        echo "config.php not set correctly";
        return;
}

if(!isset($env['OPEN_AI_API_KEY'])){
        echo "You need to add your own API key to the config.php file";
        return;
}

$api_key = $env['OPEN_AI_API_KEY']; // $env is coming from config.php if not obvious ;P
$api_url = 'https://api.openai.com/v1/chat/completions';


// See this for possible settings: https://platform.openai.com/docs/api-reference/chat/create
$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => 'Describe the purpose of json to someone who is computer illiterate, do so in verbosely poetic old english.']
    ],
    'temperature' => 1,
    //"max_tokens" => 2000
];

function send_http_req($api_url, $data, $api_key){

    $return = new stdClass();

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n" .
                        "Authorization: Bearer " . $api_key,
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($api_url, false, $context);

    if ($response === false) {
        // Handle error
       // Handle error and get additional details
        $meta = stream_get_meta_data($context);
        //echo 'Error accessing the API: ' . implode("\n", $meta['wrapper_data']);

        $return->status = false;
        $return->message = 'Error accessing the API: ' . implode("\n", $meta['wrapper_data']);
    } else {
            
        $response_data = json_decode($response, true); 
    //     echo "<pre>";
    //     print_r($response_data);
    //     echo "</pre>";
        $chat_response = $response_data['choices'][0]['message']['content'] ?? NULL;

        if(!is_null($chat_response)){
            //echo $chat_response;
            
                // echo "<pre>";
                // print_r($chat_response);
                // echo "</pre>";

            /**
             * $chat_response: Pray, lend me thine ear, for I shall unfold the tale of JSON in the parlance of old English so thou may comprehend its purpose, though thy knowledge of computers be frail...etc
             * **/

            $return->status = true;
            $return->message = $chat_response;

            
        } else {
            
            $return->status = false;
            $return->message = 'Query successful, but problem with parsing response.';
        }

        return $return;
    } // end response received check



} // end fn


function send_curl_req($api_url, $data, $api_key) {
    
    $return = new stdClass();
     
     
    $options = [
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        ],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    if ($response === false) {
        //echo 'cURL Error: ' . curl_error($curl);
        
        $return->status = false;
        $return->message = 'cURL Error: ' . curl_error($curl);
    } else {
        
       $response_data = json_decode($response, true); 
        
       $chat_response = $response_data['choices'][0]['message']['content'] ?? NULL;

        if(!is_null($chat_response)){
            //echo $chat_response;
            
                // echo "<pre>";
                // print_r($chat_response);
                // echo "</pre>";

            /**
             * $chat_response: Pray, lend me thine ear, for I shall unfold the tale of JSON in the parlance of old English so thou may comprehend its purpose, though thy knowledge of computers be frail...etc
             * **/

            $return->status = true;
            $return->message = $chat_response;

            
        } else {
            
            $return->status = false;
            $return->message = 'Query successful, but problem with parsing response.';
        }
            
       
    }

     curl_close($curl);
      return $return;
} // end fn

  
 



?>
