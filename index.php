<?php
// Start the session
session_start();

// Check if the prompt_alert session item is not set
if (!isset($_SESSION['prompt_alert'])) {
    $_SESSION['prompt_alert'] = 0;
} else {
    if ($_SESSION['prompt_alert'] >= 3) {
        exit('You have exceeded the allowed number of prompt filter violations. You have been temporarily banned. Try again later.');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrainSyncAi Binaural Beats Ai Generator</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            position: relative;

            margin: 0;
            background: url('backgrounds\\background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container ps-5 pe-5" style="background-color:#f9f9f9; border-radius:10px; margin-top:5rem !important; padding-bottom:3rem;">
        <h1 class="mb-4" style="padding-top: 2rem !important;"><strong>BrainSyncAi</strong> Binaural Beats Ai Generator <span class="badge bg-dark">1.0.0-Alpha</span></h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">What is BrainSyncAi?</h5>
                <p class="card-text"><strong>BrainSyncAi</strong> is an innovative application designed to help users achieve desired brainwave states using the power of binaural beats. By inputting their brainwave goal, the AI algorithm generates custom bin beats, which are then played back to the user. These bin beats consist of two different frequencies that, when listened to with headphones, create a unique audio experience that can help induce relaxation, focus, or other desired mental states. With its user-friendly interface and advanced AI technology, Brain Sync AI provides a convenient and effective way to harness the potential of binaural beats for personal well-being and mental enhancement.</p>
                <p class="card-text">BrainSyncAi is still under development and is not ready for production, this is a preview. <br /><br /> <strong>Please read this disclaimer carefully before using BrainSyncAi:</strong> <a href="#" data-bs-toggle="modal" data-bs-target="#medical">Medical Disclaimer</a>
                    <br /> <strong>Also please note:</strong> By using this application, you agree to the terms and conditions outlined in our <a href="#" data-bs-toggle="modal" data-bs-target="#terms">Terms & Conditions</a>.
                </p>
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">Bin Board</h5>
                <div id="alert-section"></div>
                <div id="binBoard">
                    <div id="board-noti" class="card mt-3">
                        <div class="card-body text-center mt-2 ">
                            <h5 class="card-title text-secondary">Generate a bin beat to add to the bin board</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Mode Card -->
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">Ai Mode</h5>
                <span id="alert-section-ai"></span>
                <div class="row">
                    <div class="col">
                        <label for="brainWaveGoal">Brain Wave Goal:</label>
                        <input type="text" id="brainWaveGoal" class="form-control" placeholder="Playing call of duty">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button id="generateBtn-ai" class="btn btn-primary">Generate Ai Powered Bin Beat</button>
                        <button id="loadingBtn-ai" class="btn btn-primary d-none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Generating...
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manual Mode Card -->
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">Manual Mode</h5>
                <span id="alert-section-mn"></span>
                <div class="row">
                    <div class="col">
                        <label for="frequency1">Frequency 1 (Left Audio):</label>
                        <input type="number" id="frequency1" class="form-control" placeholder="Enter Frequency 1" value="500">
                    </div>
                    <div class="col">
                        <label for="frequency2">Frequency 2 (Right Audio):</label>
                        <input type="number" id="frequency2" class="form-control" placeholder="Enter Frequency 2" value="300">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button id="generateBtn-mn" class="btn btn-primary">Generate Manual Bin Beat</button>
                        <button id="loadingBtn-mn" class="btn btn-primary d-none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Generating...
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <center style="position:float; margin-top:2rem;" >Copyright 2023 - <strong>BrainSyncAi</strong></center>
    </div>

    <div class="modal" id="terms">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Terms & Conditions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h1>Disclaimer: BrainSyncAi - A Product in Development</h1>

                    <p>Before using BrainSyncAi, please carefully review this disclaimer. Usage of BrainSyncAi signifies your agreement to these terms and conditions.</p>

                    <h4>1. Development and Testing Phase</h4>
                    <p>BrainSyncAi is currently undergoing development and testing. Please expect potential limitations, inaccuracies, or performance fluctuations during this phase.</p>

                    <h4>2. Accuracy Not Guaranteed</h4>
                    <p>BrainSyncAi, powered by OpenAI's algorithms, generates information and suggestions that may not always be accurate or reliable. We advise users to cross-check and use such information judiciously.</p>

                    <h4>3. Not a Replacement for Professional Advice</h4>
                    <p>BrainSyncAi is not intended to substitute professional, medical, or any other form of specialized advice. Always consult with professionals for tailored advice related to your specific situation.</p>

                    <h4>4. User Discretion</h4>
                    <p>Users are responsible for interpreting and using the content generated by BrainSyncAi. Decisions made based on this information are the user's sole responsibility.</p>

                    <h4>5. Use At Your Own Risk</h4>
                    <p>Users should utilize BrainSyncAi at their own risk. BrainSyncAi's creators, developers, and affiliates disclaim any liability for direct, indirect, incidental, or consequential damages from the use or inability to use the application.</p>

                    <h4>6. Privacy and Data Security</h4>
                    <p>As described in our Privacy Policy, BrainSyncAi may collect and process user data. However, we cannot guarantee the absolute security of transmitted or stored data. Users are encouraged to take precautions to safeguard their personal information.</p>

                    <h4>7. Intellectual Property</h4>
                    <p>All intellectual property rights, including but not limited to OpenAI's algorithms, models, and content, belong to OpenAI. Unauthorized use, reproduction, or distribution of BrainSyncAi generated content is strictly prohibited.</p>

                    <p>By using BrainSyncAi, you acknowledge and agree to this disclaimer. If you disagree with any portion of this disclaimer, refrain from using BrainSyncAi.</p>

                    <p>Please ensure that you adhere to OpenAI's policies. You can review them <a href="https://openai.com/policies" target="_blank">here</a>.</p>

                    <p>Note: This disclaimer may be updated periodically as BrainSyncAi continues to evolve. We recommend regularly reviewing the most recent version of this disclaimer.</p>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="medical">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Medical Disclaimer</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <h1>Medical Disclaimer</h1>

                    <p>The binaural beats generated by BrainSyncAi are intended for relaxation, focus, sleep aid, and similar applications. They are not intended to diagnose, treat, cure, or prevent any disease or medical condition.</p>

                    <h4>1. No Medical Claims</h4>
                    <p>BrainSyncAi does not claim to provide medical advice or treatment. The application's purpose is to generate binaural beats, which some research suggests may influence mental states. However, the effects can vary greatly among individuals.</p>

                    <h4>2. Not a Substitute for Professional Advice</h4>
                    <p>The content provided by BrainSyncAi is not intended to replace professional medical advice, diagnosis, or treatment. Always seek the advice of your physician or other qualified health provider with any questions you may have regarding a medical condition.</p>

                    <h4>3. User Responsibility</h4>
                    <p>Users are responsible for their use of BrainSyncAi. Any decisions made based on the binaural beats provided by BrainSyncAi are solely the user's responsibility. If you have a history of seizures, psychiatric disorders, or other health conditions, consult your healthcare provider before using the app.</p>

                    <h4>4. Risk of Use</h4>
                    <p>The use of BrainSyncAi is at your own risk. The creators, developers, and affiliates of BrainSyncAi shall not be held liable for any direct, indirect, incidental, consequential, or other damages resulting from the use or inability to use the application.</p>

                    <p>By using BrainSyncAi, you acknowledge and accept the terms of this health disclaimer. If you do not agree with any part of this disclaimer, refrain from using the application.</p>

                    <p>Note: This health disclaimer may be subject to updates or changes as BrainSyncAi continues to evolve. It is your responsibility to review the latest version of the disclaimer before each use.</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Generate WAV file using user-input frequencies
            $('#generateBtn-mn').on('click', function() {
                var frequency1 = $('#frequency1').val();
                var frequency2 = $('#frequency2').val();

                // Validate the input frequencies
                if (!frequency1 || !frequency2) {
                    showErrorAlert('Please enter all required fields.', 'mn');
                    return;
                }

                disableGenerateButton("mn");
                showLoadingButton("mn");

                // Generate the WAV file using AJAX
                $.ajax({
                    url: 'app.php',
                    type: 'POST',
                    data: {
                        action: "generate_wav",
                        frequency1: frequency1,
                        frequency2: frequency2,
                        duration: 30
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showAlert('WAV file generated successfully: ' + response.wavUrl);
                            createBoardItem(frequency1, frequency2);
                            playBin(response.wavUrl);
                        } else {
                            showErrorAlert('Error generating WAV file.', 'mn');
                        }
                    },
                    error: function(xhr, status, error) {
                        showErrorAlert('AJAX request failed: ' + error, 'mn');
                    },
                    complete: function() {
                        enableGenerateButton("mn");
                        hideLoadingButton("mn");
                    }
                });
            });

            // Generate Bin Beat using AI mode
            $('#generateBtn-ai').on('click', function() {
                var brainWaveGoal = $('#brainWaveGoal').val();

                // Validate the input field
                if (!brainWaveGoal) {
                    showErrorAlert('Please enter all required fields.', 'ai');
                    return;
                }

                disableGenerateButton("ai");
                showLoadingButton("ai");

                // Generate the Bin Beat using AJAX
                $.ajax({
                    url: 'app.php',
                    type: 'POST',
                    data: {
                        action: "ai_generate_wav",
                        brainWaveGoal: brainWaveGoal,
                        duration: 30
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showAlert('Bin Beat generated successfully for Brain Wave Goal: ' + brainWaveGoal);
                            createBoardItem(response.frequency1, response.frequency2, brainWaveGoal);
                            playBin(response.wavUrl);
                            $("#brainWaveGoal").val("");
                        } else {
                            showErrorAlert('Error generating Bin Beat. ' + response.message, 'ai');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        showErrorAlert('AJAX request failed: ' + error, 'ai');
                    },
                    complete: function() {
                        enableGenerateButton('ai');
                        hideLoadingButton("ai");
                    }
                });
            });

            function createBoardItem(frequency1, frequency2, prompt = "") {
                $("#board-noti").remove();
                const boardItem = `<div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary play-button me-2">
                                    <i class="fas fa-pause"></i>
                                </button>
                                <h5 class="card-title" title="Prompt: ${prompt}">Frequencies: ${frequency1} Hz, ${frequency2} Hz <span class="badge bg-dark">${prompt}</span></h5>
                            </div>
                            <audio src="" preload="auto"></audio>
                        </div>
                    </div>`;
                const cardBody = $(boardItem).find('.card-body');
                const audioElement = cardBody.find('audio')[0];

                $('#binBoard').append(boardItem);
            }

            $('#binBoard').on('click', '.play-button', function() {
                const audioElement = $(this).siblings('audio')[0];
                togglePlayback(this, audioElement);
            });


            function togglePlayback(button, audioElement) {
                const iconElement = $(button).find('i');
                const isPlaying = !audioElement.paused;

                if (isPlaying) {
                    audioElement.pause();
                    iconElement.removeClass('fa-pause').addClass('fa-play');
                } else {
                    audioElement.play();
                    iconElement.removeClass('fa-play').addClass('fa-pause');
                }
            }

            function disableGenerateButton(btn) {
                $('#generateBtn-' + btn).prop('disabled', true);
            }

            function enableGenerateButton(btn) {
                $('#generateBtn-' + btn).prop('disabled', false);
            }

            function showLoadingButton(btn) {
                $('#loadingBtn-' + btn).removeClass('d-none');
                $('#generateBtn-' + btn).addClass('d-none');
            }

            function hideLoadingButton(btn) {
                $('#loadingBtn-' + btn).addClass('d-none');
                $('#generateBtn-' + btn).removeClass('d-none');
            }

            function showAlert(message) {
                const alert = `<div class="alert alert-success alert-dismissible fade show" role="alert">${message}</div>`;
                $('#alert-section').html(alert);

                setTimeout(function() {
                    $('#alert-section').html('');
                }, 15000);
            }

            function showErrorAlert(message, gen) {
                const alert = `<div class="alert alert-danger alert-dismissible fade show" role="alert">${message}</div>`;
                $('#alert-section-' + gen).html(alert);

                setTimeout(function() {
                    $('#alert-section-' + gen).html('');
                }, 15000);
            }

            function playBin(wavUrl) {
                const audioElements = $('audio');
                const audioElement = audioElements[audioElements.length - 1];
                audioElement.src = wavUrl;
                audioElement.addEventListener('ended', function() {
                    audioElement.currentTime = 0;
                    audioElement.play();
                });
                audioElement.play();
            }
        });
    </script>
</body>

</html>