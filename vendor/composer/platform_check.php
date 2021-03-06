<?php

// platform_check.php @generated by Composer

$issues = array();

if (!(PHP_VERSION_ID >= 50509)) {
    $issues[] = 'Your Composer dependencies require a PHP version ">= 5.5.9". You are running ' . PHP_VERSION  .  '.';
}

$missingExtensions = array();
extension_loaded('dom') || $missingExtensions[] = 'dom';
extension_loaded('json') || $missingExtensions[] = 'json';
extension_loaded('mbstring') || $missingExtensions[] = 'mbstring';
extension_loaded('openssl') || $missingExtensions[] = 'openssl';
extension_loaded('pcre') || $missingExtensions[] = 'pcre';
extension_loaded('reflection') || $missingExtensions[] = 'reflection';
extension_loaded('spl') || $missingExtensions[] = 'spl';
extension_loaded('tokenizer') || $missingExtensions[] = 'tokenizer';

if ($missingExtensions) {
    $issues[] = 'Your Composer dependencies require the following PHP extensions to be installed: ' . implode(', ', $missingExtensions);
}

if ($issues) {
    echo 'Composer detected issues in your platform:' . "\n\n" . implode("\n", $issues);
    exit(104);
}
