<?php

require_once 'vendor/autoload.php';
require_once 'library/chatgpt.php';
require_once 'library/generator.php';

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'generate_wav') {
        // Retrieve the necessary parameters
        $frequency1 = $_POST['frequency1'];
        $frequency2 = $_POST['frequency2'];
        $duration = $_POST['duration'];

        // Create an instance of the BinauralBeatsGenerator class
        $generator = new BinauralBeatsGenerator($frequency1, $frequency2, $duration);

        // Generate the WAV file
        $wavFile = $generator->generateWAVFile();

        // Prepare the response
        $response = [
            'success' => true,
            'wavUrl' => $wavFile
        ];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } elseif ($_POST['action'] === 'ai_generate_wav') {
        // Retrieve the necessary parameters
        $brainWaveGoal = $_POST['brainWaveGoal'];
        $duration = $_POST['duration'];

        // Create an instance of the ChatGPT class
        $chatGPT = new ChatGPT($_ENV['OPENAI_API_KEY']);

        // Generate frequencies using ChatGPT
        $frequencies = $chatGPT->aiGetFrequencies($brainWaveGoal);
        
        // Check if frequencies are obtained
        if (count($frequencies) === 2) {
            // Create an instance of the BinauralBeatsGenerator class
            $generator = new BinauralBeatsGenerator($frequencies[0], $frequencies[1], $duration);

            // Generate the WAV file
            $wavFile = $generator->generateWAVFile();

            // Prepare the response
            $response = [
                'success' => true,
                'wavUrl' => $wavFile
            ];
        } else {
            // Frequencies not obtained, return error response
            $response = [
                'success' => false,
                'message' => 'Unable to generate frequencies.'
            ];
        }

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } elseif ($_POST['action'] === 'another_action') {
        // Handle another AJAX action
        // ...
    }
}
