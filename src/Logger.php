<?php namespace AgungDhewe\PhpLogger;

if(!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));

class Logger {

	public static string $OUTPUT = LoggerOutput::SCREEN;
	public static string $LOG_FILEPATH;
	public static string $DEBUG_FILEPATH;

	private static bool $_DEBUG_MODE = false;
	private static bool $_INFO_SHOW_CALLER_FILE = false;
	private static bool $_SHOW_SCRIPT_REF_TOUSER = true;

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

		if (php_sapi_name() === 'cli') {
			// pada mode cli, clear file debug pada saat memulai debug
			self::clearDebug();
		} else {
			// pada mode webserver, debug di clear hanya saat ada parameter $_GET['cleardebug'] = 1
			if (array_key_exists('cleardebug', $_GET)) {
				$cleardebug = $_GET['cleardebug'];
				if ($cleardebug == 1) {
					self::clearDebug();
				}
			}
		}

	}

	public static function clearDebug() : void {
		$debugpath = self::GetDebugFilepath();
		file_put_contents($debugpath, "");
	}

	public static function ShowCallerFileOnInfo(bool $value) : void {
		self::$_INFO_SHOW_CALLER_FILE = $value;
	}

	public static function IsCallerFileShownOnInfo() : bool {
		return self::$_INFO_SHOW_CALLER_FILE;
	}


	public static function IsShowScriptReferenceToUser() : bool {
		return self::$_SHOW_SCRIPT_REF_TOUSER;
	}

	public static function ShowScriptReferenceToUser(bool $value) : void {
		self::$_SHOW_SCRIPT_REF_TOUSER = $value;
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
		if (self::$OUTPUT == LoggerOutput::SCREEN_ONLY || self::$OUTPUT == LoggerOutput::NONE) {
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