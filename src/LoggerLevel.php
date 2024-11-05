<?php namespace AgungDhewe\PhpLogger;

class LoggerLevel
{
	const string INFO = 'INFO';
	const string DEBUG = 'DEBUG';
	const string ERROR = 'ERROR';
	const string WARNING = 'WARNING';

	public static function getLabel(string $level) {
		switch ($level) {
			case self::INFO:
				return "\e[1;37;40m". self::INFO . "\e[0m";

			case self::DEBUG:
				return "". self::DEBUG;

			case self::ERROR:
				return "\e[1;31;40m". self::ERROR . "\e[0m";

			case self::WARNING:
				return "\e[1;33;40m". self::WARNING . "\e[0m";
		}
	}

}