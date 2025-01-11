# PHP Logger
Simple logger for php

## Install

	composer require agungdhewe/phplogger

## Example


### Output to Screen and record in log.txt

	use AgungDhewe\PhpLogger\Log;

	Log::Info("Hello World");
	Log::Debug("test debug");


### Output to File Only

	use AgungDhewe\PhpLogger\Log;
	use AgungDhewe\PhpLogger\Logger;
	use AgungDhewe\PhpLogger\LoggerOutput;

	Logger::SetOutput(LoggerOutput::FILE);

	Log::Info("Hello World");
	Log::Debug("test debug");
	Log::Error("test error");


### Change log filename

	use AgungDhewe\PhpLogger\Log;
	use AgungDhewe\PhpLogger\Logger;
	use AgungDhewe\PhpLogger\LoggerOutput;

	Logger::SetOutput(LoggerOutput::FILE);
	Logger::SetFilepath(__DIR__ . "/myownlog.txt");

	Log::Info("Hello World");
	Log::Debug("test debug");
	Log::Error("test error");