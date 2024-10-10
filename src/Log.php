<?php namespace AgungDhewe\PhpLogger;

class Log {

	private static function log(string $level, mixed $message) {
		Logger::WriteLn(date("Y-m-d H:i:s") . "\t" . LoggerLevel::getLabel($level) . "\t" . $message);

		if (Logger::$OUTPUT == LoggerOutput::SCREEN | Logger::$OUTPUT == LoggerOutput::SCREEN_ONLY) {
			Logger::PrintLn(LoggerLevel::getLabel($level) . $message);
		}
	}

	public static function getCallerReference() {
		$trace = debug_backtrace();
		$caller = $trace[1];
		$reference = $caller['file'] . ":" . $caller['line'];
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
		Logger::PrintLn($message);
	}
}