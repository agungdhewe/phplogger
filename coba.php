<?php
require_once __DIR__ . '/vendor/autoload.php';


use AgungDhewe\PhpLogger\Log;
use AgungDhewe\PhpLogger\Logger;
use AgungDhewe\PhpLogger\LoggerOutput;

ob_start();

// Logger::SetOutput(LoggerOutput::FILE);
Logger::SetFilepath(__DIR__ . "/coba.txt");

Log::info("Hello World");
Log::debug("test debug");
Log::error("test error");
Log::warning("test warning");
Log::print("test print");

sleep(2);
ob_end_clean();