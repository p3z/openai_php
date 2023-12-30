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
    'temperature' => 0.7,
    //"max_tokens": 2000
];

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
    echo 'Error accessing the API.';
} else {
        
    $response_data = json_decode($response, true); 
//     echo "<pre>";
//     print_r($response_data);
//     echo "</pre>";
    $chat_response = $response_data['choices'][0]['message']['content'] ?? NULL;

    if(!is_null($chat_response)){
        echo $chat_response;

        /**
         * $chat_response: Pray, lend me thine ear, for I shall unfold the tale of JSON in the parlance of old English so thou may comprehend its purpose, though thy knowledge of computers be frail...etc
         * **/
        
    } else {
        echo "Didnt work, troubleshooting time...";
    }

}

?>
