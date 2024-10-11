<?php namespace AgungDhewe\PhpLogger;

class Logger {

	public static string $OUTPUT = LoggerOutput::SCREEN;
	public static string $LOG_FILEPATH;
	public static string $DEBUG_FILEPATH;

	private static bool $_DEBUG_MODE = false;

	public static function SetOutput(string $output) : void {
		self::$OUTPUT = $output;
	}

	public static function SetLogFilepath(string $filepath) : void {
		self::$LOG_FILEPATH = $filepath;
	}

	public static function SetDebugFilepath(string $filepath) : void {
		self::$DEBUG_FILEPATH = $filepath;
	}

	public static function SetDebugMode(bool $mode) : void {
		self::$_DEBUG_MODE = $mode;

		// clear debug log
		$debugpath = self::GetDebugFilepath();
		file_put_contents($debugpath, "");
	}


	public static function GetLogFilepath() : string {
		if (!isset(self::$LOG_FILEPATH)) {
			$cwd = getcwd();
			self::$LOG_FILEPATH = implode(DIRECTORY_SEPARATOR, [$cwd, 'log.txt']);
		} 
		return self::$LOG_FILEPATH;
	}

	public static function GetDebugFilepath() : string {
		if (!isset(self::$DEBUG_FILEPATH)) {
			$cwd = getcwd();
			self::$DEBUG_FILEPATH = implode(DIRECTORY_SEPARATOR, [$cwd, 'debug.txt']);
		} 
		return self::$DEBUG_FILEPATH;
	}




	public static function Debug(string $message) :void {
		if (!self::$_DEBUG_MODE) {
			return;
		}
		$debugpath = self::GetDebugFilepath();
		file_put_contents($debugpath, $message ."\r\n", FILE_APPEND);
	}


	public static function WriteLn(string $message) :void {
		if (self::$OUTPUT == LoggerOutput::SCREEN_ONLY) {
			return;
		}

		$logpath = self::GetLogFilepath();
		file_put_contents($logpath, $message ."\r\n", FILE_APPEND);
	}

	public static function Print(string $message) : void {
		fwrite(STDOUT, $message);
	}

	public static function PrintLn(string $message) : void {
		self::Print($message . "\r\n");
	}
}