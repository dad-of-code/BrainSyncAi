<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binaural Beats Player</title>
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Binaural Beats Player</h1>
        <div class="row">
            <div class="col">
                <label for="frequency1">Frequency 1:</label>
                <input type="number" id="frequency1" class="form-control" placeholder="Enter Frequency 1">
            </div>
            <div class="col">
                <label for="frequency2">Frequency 2:</label>
                <input type="number" id="frequency2" class="form-control" placeholder="Enter Frequency 2">
            </div>
            <div class="col">
                <label for="duration">Duration (seconds):</label>
                <input type="number" id="duration" class="form-control" placeholder="Enter Duration">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <button id="generateBtn" class="btn btn-primary">Generate WAV</button>
            </div>
        </div>

        <!-- AI Mode Card -->
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="card-title">AI Mode</h5>
                <div class="row">
                    <div class="col">
                        <label for="brainWaveGoal">Brain Wave Goal:</label>
                        <input type="text" id="brainWaveGoal" class="form-control" placeholder="Enter Brain Wave Goal">
                    </div>
                    <div class="col">
                        <label for="aiDuration">Duration (seconds):</label>
                        <input type="number" id="aiDuration" class="form-control" placeholder="Enter Duration">
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <button id="aiGenerateBtn" class="btn btn-primary">Generate Bin Beat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Generate WAV file using user-input frequencies
            $('#generateBtn').on('click', function() {
                var frequency1 = $('#frequency1').val();
                var frequency2 = $('#frequency2').val();
                var duration = $('#duration').val();

                // Validate the input frequencies and duration
                if (!frequency1 || !frequency2 || !duration) {
                    alert('Please enter all required fields.');
                    return;
                }

                // Generate the WAV file using AJAX
                $.ajax({
                    url: 'app.php',
                    type: 'POST',
                    data: {
                        action: "generate_wav",
                        frequency1: frequency1,
                        frequency2: frequency2,
                        duration: duration
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('WAV file generated successfully: ' + response.wavUrl);
                            var audio = new Audio(response.wavUrl);
                            audio.play();
                        } else {
                            alert('Error generating WAV file.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('AJAX request failed: ' + error);
                    }
                });
            });

            // Generate Bin Beat using AI mode
            $('#aiGenerateBtn').on('click', function() {
                var brainWaveGoal = $('#brainWaveGoal').val();
                var aiDuration = $('#aiDuration').val();

                // Validate the input fields
                if (!brainWaveGoal || !aiDuration) {
                    alert('Please enter all required fields.');
                    return;
                }

                // Generate the Bin Beat using AJAX
                $.ajax({
                    url: 'app.php',
                    type: 'POST',
                    data: {
                        action: "ai_generate_wav",
                        brainWaveGoal: brainWaveGoal,
                        duration: aiDuration
                    },
                    dataType: 'json',
                    success: function(response) {
                       
                        console.log(response);
                        if (response.success) {
                            alert('Bin Beat generated successfully for Brain Wave Goal: ' + brainWaveGoal);
                            var audio = new Audio(response.wavUrl);
                            audio.play();
                        } else {
                            alert('Error generating Bin Beat.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        alert('AJAX request failed: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>
