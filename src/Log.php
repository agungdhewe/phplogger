<?php namespace AgungDhewe\PhpLogger;

class Log {

	private static mixed $_prevMessage = null;


	private static function WriteLog(string $level, mixed $message, ?string $reference='') : string {
		if (is_array($message) || is_object($message)) {
			$text = print_r($message, true);
		} else {
			$text = $message;
		}
	
		if ($level==LoggerLevel::DEBUG) {
			// apabila level debug, tidak peru tulis ke log, dan tidak perlu menampilakan label
			Logger::Debug("\e[0;33;40m" . $text . "\e[0m" . "\t" . "\e[0;34;40m" . $reference . "\e[0m");
		} else {
			Logger::WriteLn(date("Y-m-d H:i:s") . "\t" . $level . "\t" . $text);
			if ($reference=='') {
				Logger::Debug(LoggerLevel::GetLabel($level) . "\t" . $text);
			} else {
				Logger::Debug(LoggerLevel::GetLabel($level) . "\t" . $text . " " . "\e[0;34;40m" . $reference. "\e[0m");
			}	
		}
	
		
		if (Logger::$OUTPUT == LoggerOutput::SCREEN | Logger::$OUTPUT == LoggerOutput::SCREEN_ONLY) {
			Logger::PrintLn(LoggerLevel::GetLabel($level) . ": " . $text);
		}

		return $text;
	}

	public static function GetCallerReference() : string {
		$trace = debug_backtrace();
		$caller = $trace[1];
		$reference = $caller['file'] . ":" . $caller['line'];
		return $reference;
	}

	public static function Info(mixed $message) : void {
		if (Logger::IsSuppressInfo()) {
			return;
		}

		if (Logger::IsCallerFileShownOnInfo()) {
			$reference = self::GetCallerReference();
			self::WriteLog(LoggerLevel::INFO, $message, $reference);
		} else {
			self::WriteLog(LoggerLevel::INFO, $message);
		}
	}

	public static function Debug(mixed $message) : void {
		if (Logger::IsSuppressDebug()) {
			return;
		}

		$reference = self::GetCallerReference();
		self::WriteLog(LoggerLevel::DEBUG, $message, $reference);;
	}

	public static function Error(mixed $message) : string {
		if (Logger::IsSuppressError()) {
			return $message;
		}

		if ($message==self::$_prevMessage) {
			return $message;
		} else {
			self::$_prevMessage = $message;
			$reference = self::GetCallerReference();
			$msg = self::WriteLog(LoggerLevel::ERROR, $message . "\t" . $reference);
			if (Logger::IsShowScriptReferenceToUser()) {
				return $msg;
			} else {
				return $message;
			}
		}
		
		
	}

	public static function Warning(mixed $message) : string {
		if (Logger::IsSuppressWarning()) {
			return $message;
		}

		$reference = self::GetCallerReference();
		$msg = self::WriteLog(LoggerLevel::WARNING, $message . "\t" . $reference);
		if (Logger::IsShowScriptReferenceToUser()) {
			return $msg;
		} else {
			return $message;
		}
		
	}

	public static function Print(mixed $message) : void {
		if (Logger::IsSuppressPrint()) {
			return;
		}

		if (is_array($message) || is_object($message)) {
			$text = print_r($message, true);
		} else {
			$text = $message;
		}

		Logger::PrintLn($text);
	}
}