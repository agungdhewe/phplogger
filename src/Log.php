<?php namespace AgungDhewe\PhpLogger;

class Log {

	private static function log(string $level, mixed $message) {
		if (is_array($message) || is_object($message)) {
			$text = print_r($message, true);
		} else {
			$text = $message;
		}

		Logger::WriteLn(date("Y-m-d H:i:s") . "\t" . LoggerLevel::getLabel($level) . "\t" . $text);
		if (Logger::$OUTPUT == LoggerOutput::SCREEN | Logger::$OUTPUT == LoggerOutput::SCREEN_ONLY) {
			Logger::PrintLn(LoggerLevel::getLabel($level) . ": " . $text);
		}
	}

	public static function getCallerReference() : string {
		$trace = debug_backtrace();
		$caller = $trace[1];
		$reference = $caller['file'] . ":" . $caller['line'];
		return $reference;
	}

	public static function info(mixed $message) : void {
		self::log(LoggerLevel::INFO, $message);
	}

	public static function debug(mixed $message) : void {
		$reference = self::getCallerReference();
		self::log(LoggerLevel::DEBUG, $message . "\t" . $reference);;
	}

	public static function error(mixed $message) : void {
		$reference = self::getCallerReference();
		self::log(LoggerLevel::ERROR, $message . "\t" . $reference);
	}

	public static function warning(mixed $message) : void {
		$reference = self::getCallerReference();
		self::log(LoggerLevel::WARNING, $message . "\t" . $reference);
	}

	public static function print(mixed $message) : void {
		if (is_array($message) || is_object($message)) {
			$text = print_r($message, true);
		} else {
			$text = $message;
		}

		Logger::PrintLn($text);
	}
}