# openai_php
Connect a PHP project to the OpenAI API without any extra packages.

I wanted to use OpenAI's API in a lightweight project using as few packages as possible and couldnt find any existing examples that do it.
Therefore I built this. It's just 2 files and no dependencies. Simple ^_^

### Setup
- Set up a simple (and i mean very simple) config file with your API key for OpenAI
- Adapt index.php as needed. There are 2 functions, while both give same results, you may have a preference one over the other (one uses cURL, the other doesnt).
  - Both return a stdClass object with status (a bool) and message (a string). Status will be false if any issues.

### What's the point in the config.php file? Couldn't its $env array just be directly inside index.php?
Technically, yes. Yet it could and that'll work. Not a good idea though. It's bad practice to commit your API keys to any projects' version control system, lest they become public knowledge. So I'm using the config.php file as the equivalent of a .env file to keep our API keys safe from version control (note the reference the config.php inside the gitignore file). I'm not using .env because I didn't want to use any other packages at all.

### Examples
```
$api_key = $env['OPEN_AI_API_KEY']; // $env is coming from config.php if not obvious ;P
$api_url = 'https://api.openai.com/v1/chat/completions';
$prompt = 'Describe the purpose of json to someone who is computer illiterate, do so in verbosely poetic old english.';

$data = [
    // See this for possible settings: https://platform.openai.com/docs/api-reference/chat/create
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => $prompt]
    ],
    'temperature' => 1,
    "max_tokens" => 3500
];

// Eg 1.
$test = send_http_req($api_url, $data, $api_key); 
echo $test->message; // Pray, lend me thine ear, for I shall unfold the tale of JSON in the parlance of old English so thou may comprehend its purpose, though thy knowledge of computers be frail...etc

// Eg. 2
$test = send_curl_req($api_url, $data, $api_key); 
echo $test->message; // Pray, lend me thine ear, for I shall unfold the tale of JSON in the parlance of old English so thou may comprehend its purpose, though thy knowledge of computers be frail...etc


```




