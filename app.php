<?php 
// Start the session
session_start();
if(isset($_GET["reset-session"])){
    session_destroy();
}
// Check if the prompt_alert session item is not set
if (!isset($_SESSION['prompt_alert'])) {
    $_SESSION['prompt_alert'] = 0;
}else{
    if ($_SESSION['prompt_alert'] >= 3) {
        $banLog = date('Y-m-d H:i:s') . " - User banned for violating prompt filter.\n";
        file_put_contents('locker/.bans.txt', $banLog, FILE_APPEND | LOCK_EX);

        $response = [
            'success' => false,
            'message' => "You have exceeded the allowed number of prompt filter violations. You have been temporarily banned. Try again later.",
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

function countRecentBans() {
    $currentTime = time();
    $recentBans = file('locker/.bans.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $banCount = 0;

    foreach ($recentBans as $ban) {
        $banTimestamp = strtotime(substr($ban, 0, 19)); // Extract the timestamp from the log entry
        if (($currentTime - $banTimestamp) <= 1800) { // 1800 seconds = 30 minutes
            $banCount++;
        }
    }

    return $banCount;
}

$banCount = countRecentBans();
if ($banCount >= 3) {
    $response = [
        'success' => false,
        'message' => "The website is currently under maintenance. Our AI function is currently not accepting traffic. Please try again later.",
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

ini_set('memory_limit', '1G');
require_once 'vendor/autoload.php';
require_once 'library/chatgpt.php';
require_once 'library/generator.php';
require_once 'library/prompt-filter-php/src/filter.php';

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
        $brainWaveGoal = htmlspecialchars($brainWaveGoal, ENT_QUOTES, 'UTF-8');

        // Save the prompt locally
        $file = 'locker/.prompts.txt';
        $currentContent = file_get_contents($file);

        if (!empty($currentContent)) {
            $currentContent .= "\n";
        }

        $currentContent .= $brainWaveGoal;

        file_put_contents($file, $currentContent, FILE_APPEND);

        $duration = $_POST['duration'];
        $contentFilter = new promptFilter();

        $filteredPrompt = $contentFilter->filterPrompt($brainWaveGoal);

        // Check if the filtered prompt is different from the original prompt
        // If they are different, it means there was inappropriate content
        if ($filteredPrompt !== true) {
            // Inappropriate content detected
            $response = [
                'success' => false,
                'message' => "Warning, inappropriate content was detected in your prompt. This has been logged. Don't let it happen again.",
            ];
            $_SESSION['prompt_alert'] = $_SESSION['prompt_alert']+1;
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

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
                'wavUrl' => $wavFile,
                'frequency1' => $frequencies[0],
                'frequency2' => $frequencies[1]
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
