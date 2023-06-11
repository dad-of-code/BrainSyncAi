<?php

class ChatGPT
{
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKeyParam)
    {
        $this->apiKey = $apiKeyParam;
        $this->baseUrl = 'https://api.openai.com/v1/completions';
    }

    public function chat($prompt, $maxTokens = 4000, $temperature = 0, $topP = 1, $n = 1, $stream = false, $logprobs = null, $stop = "\\n")
    {
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ];

        $data = [
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
            'top_p' => $topP,
            'n' => $n,
            'stream' => $stream,
            'logprobs' => $logprobs,
            'stop' => $stop
        ];
       

        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Disable SSL host verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Disable SSL peer certificate verification
        $response = curl_exec($ch);
        curl_close($ch);

        $decodedResponse = json_decode($response, true);
        //var_dump($response);
    
        return $decodedResponse['choices'][0]["text"];
    }


    public function aiGetFrequencies($brainWaveGoal) {
        $prompt = 'You are a binaural beat generator. Generate 2 frequencies (frequencyOne) and (FrequencyTwo) that best match this brain wave goal: "' . $brainWaveGoal . '". Output in only json. numerical values only.  ';
        $attempts = 0;
    
        while ($attempts < 1) {
            $response = json_decode($this->chat($prompt));
            if (isset($response->frequencyOne) && isset($response->frequencyTwo)) {
                return [
                   $response->frequencyOne,
                   $response->frequencyTwo
                ];
            }
    
            $attempts++;
        }
    
        return [];
    }
    
    
    
    
}
