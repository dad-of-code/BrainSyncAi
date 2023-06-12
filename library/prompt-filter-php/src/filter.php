<?php 
declare(strict_types=1);

/*
 * This file is part of Prompt Filter.
 *
 * (c) Dad-Of-Code <hello-world@dadofcode.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class PromptFilter {
    private $forbiddenContentFilePath;
    private $forbiddenContent;

    public function __construct() {
        $this->forbiddenContentFilePath = __DIR__ . '/forbidden_content.txt';
        $this->forbiddenContent = $this->loadForbiddenContent();
    }

    private function loadForbiddenContent() {
        if (file_exists($this->forbiddenContentFilePath)) {
            $forbiddenContent = file($this->forbiddenContentFilePath, FILE_IGNORE_NEW_LINES);
            return array_map('trim', $forbiddenContent);
        } else {
            throw new Exception("Forbidden content file not found.");
        }
    }

    public function filterPrompt($content) {
        $filteredContent = $content;

        foreach ($this->forbiddenContent as $phrase) {
            $phrase = trim($phrase);
            $pattern = '/\b' . preg_quote($phrase, '/') . '\b/i';
            $filteredContent = preg_replace($pattern, '', $filteredContent);
        }

        if ($filteredContent !== $content) {
            return false; // Inappropriate content detected
        } else {
            return true; // No inappropriate content detected
        }
    }
}
