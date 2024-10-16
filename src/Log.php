<?php namespace AgungDhewe\PhpLogger;

class Log {

	private static function log(string $level, mixed $message, ?string $reference='') {
		if (is_array($message) || is_object($message)) {
			$text = print_r($message, true);
		} else {
			$text = $message;
		}
	
		if ($level==LoggerLevel::DEBUG) {
			// apabila level debug, tidak peru tulis ke log, dan tidak perlu menampilakan label
			Logger::Debug($text . "\t" . "\e[0;33;40m" . $reference . "\e[0m");
		} else {
			Logger::WriteLn(date("Y-m-d H:i:s") . "\t" . $level . "\t" . $text);
			Logger::Debug(LoggerLevel::getLabel($level) . "\t" . $text);
		}
	
		
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
		self::log(LoggerLevel::DEBUG, $message, $reference);;
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