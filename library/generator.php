<?php 

class BinauralBeatsGenerator
{
    private $frequency1;
    private $frequency2;
    private $duration;
    private $sampleRate;
    private $numSamples;
    private $leftSamples;
    private $rightSamples;
    private $normalizedLeftSamples;
    private $normalizedRightSamples;
    private $wavFolder;

    public function __construct($frequency1, $frequency2, $duration)
    {
        $this->frequency1 = $frequency1;
        $this->frequency2 = $frequency2;
        $this->duration = $duration;
        $this->sampleRate = 44100; // standard sample rate for audio
        $this->numSamples = $this->duration * $this->sampleRate;
        $this->leftSamples = [];
        $this->rightSamples = [];
        $this->normalizedLeftSamples = [];
        $this->normalizedRightSamples = [];
        $this->wavFolder = 'tones';

        // Create the WAV folder if it doesn't exist
        if (!file_exists($this->wavFolder)) {
            mkdir($this->wavFolder, 0777, true);
        }
    }

    private function toneExists() {
        $wavFile = $this->wavFolder . '/tone_' . $this->frequency1 . '_' . $this->frequency2 . '_' . $this->duration . 's.wav';
        return file_exists($wavFile);
    }


    public function generateWAVFile()
    {
        if ($this->toneExists()) {
            return $this->wavFolder . '/tone_' . $this->frequency1 . '_' . $this->frequency2 . '_' . $this->duration . 's.wav';
        }
        
        $this->generateAudioSamples();
        $this->normalizeAudioSamples();
        $wavFile = $this->createWAVFile();

        return $wavFile;
    }

    private function generateAudioSamples()
    {
        for ($i = 0; $i < $this->numSamples; $i++) {
            $this->leftSamples[] = sin(2 * M_PI * $this->frequency1 * $i / $this->sampleRate);
            $this->rightSamples[] = sin(2 * M_PI * $this->frequency2 * $i / $this->sampleRate);
        }
    }

    private function normalizeAudioSamples()
    {
        $maxLeftSample = max($this->leftSamples);
        $maxRightSample = max($this->rightSamples);
        $this->normalizedLeftSamples = array_map(function ($sample) use ($maxLeftSample) {
            return $sample / $maxLeftSample;
        }, $this->leftSamples);
        $this->normalizedRightSamples = array_map(function ($sample) use ($maxRightSample) {
            return $sample / $maxRightSample;
        }, $this->rightSamples);
    }

    private function createWAVFile()
    {
        $wavFile = $this->wavFolder . '/tone_' . $this->frequency1 . '_' . $this->frequency2 . '_' . $this->duration . 's.wav';

        $header = [
            'chunkId' => 'RIFF',
            'format' => 'WAVE',
            'subchunk1Id' => 'fmt ',
            'subchunk1Size' => 16,
            'audioFormat' => 1, // PCM format
            'numChannels' => 2, // Stereo
            'sampleRate' => $this->sampleRate,
            'byteRate' => $this->sampleRate * 4, // 2 channels * 2 bytes per sample (16-bit)
            'blockAlign' => 4, // 2 channels * 2 bytes per sample (16-bit)
            'bitsPerSample' => 16,
            'subchunk2Id' => 'data',
            'subchunk2Size' => $this->numSamples * 4 // 2 channels * 2 bytes per sample (16-bit)
        ];

        $batchSize = 10000; // Adjust the batch size as needed

        $wavHandle = fopen($wavFile, 'wb');
        fwrite($wavHandle, pack('A4VA4A4VvvVVvvA4V', $header['chunkId'], 0, $header['format'], $header['subchunk1Id'], $header['subchunk1Size'], $header['audioFormat'], $header['numChannels'], $header['sampleRate'], $header['byteRate'], $header['blockAlign'], $header['bitsPerSample'], $header['subchunk2Id'], $header['subchunk2Size']));

        for ($i = 0; $i < $this->numSamples; $i += $batchSize) {
            $remainingSamples = min($batchSize, $this->numSamples - $i);
            $leftSamplesBatch = array_slice($this->normalizedLeftSamples, $i, $remainingSamples);
            $rightSamplesBatch = array_slice($this->normalizedRightSamples, $i, $remainingSamples);
            $samplesBatch = [];

            for ($j = 0; $j < $remainingSamples; $j++) {
                $leftSampleValue = (int) ($leftSamplesBatch[$j] * 32767);
                $rightSampleValue = (int) ($rightSamplesBatch[$j] * 32767);
                $samplesBatch[] = pack('v', $leftSampleValue); // Left channel
                $samplesBatch[] = pack('v', $rightSampleValue); // Right channel
            }

            fwrite($wavHandle, implode('', $samplesBatch));
        }

        fclose($wavHandle);

        return $wavFile;
    }
}