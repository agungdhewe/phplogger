<?php namespace AgungDhewe\PhpLogger;

class Logger {

	public static $OUTPUT = LoggerOutput::SCREEN;
	public static $FILEPATH;


	public static function SetOutput(string $output) : void {
		self::$OUTPUT = $output;
	}

	public static function SetFilepath(string $filepath) : void {
		self::$FILEPATH = $filepath;
	}

	public static function GetFilepath() : string {
		if (self::$FILEPATH == null) {
			$cwd = getcwd();
			self::$FILEPATH = implode(DIRECTORY_SEPARATOR, [$cwd, 'log.txt']);
		} 
		return self::$FILEPATH;
	}

	public static function WriteLn(string $message) :void {
		if (self::$OUTPUT == LoggerOutput::SCREEN_ONLY) {
			return;
		}

		$logpath = self::GetFilepath();
		file_put_contents($logpath, $message ."\r\n", FILE_APPEND);
	}

	public static function Print(string $message) : void {
		fwrite(STDOUT, $message);
	}

	public static function PrintLn(string $message) : void {
		self::Print($message . "\r\n");
	}
}