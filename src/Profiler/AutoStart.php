<?php

namespace XhprofEmbed\Profiler;

use XhprofEmbed\Config\Config;

class AutoStart {
	private static $manager;

	private static function checkRegs($data, $regs) {
		foreach ((array) $regs as $n => $regex) {
			$value = isset($data[$n]) ? $data[$n] : '';
			if (!preg_match($regex, $value)) {
				return false;
			}
		}
		return true;
	}

	private static function canStart(Config $config, $argv, $serverVars) {
		if (!$config->getValue('profiler', 'active')) {
			return false;
		}
		if (!$config->getValue('profiler', 'filtering')) {
			return true;
		}

		return (self::checkRegs((array) $argv, $config->getValue('profiler', 'argv_filters')))
			&& self::checkRegs((array) $serverVars, $config->getValue('profiler', '_server_filters'));
	}

	public static function start(Config $config, WrapperFactory $factory, $argv, $serverVars) {
		if (self::canStart($config, $argv, $serverVars)) {
			self::$manager = new WrapperManager($factory->createFromConfig($config));
		}
	}
}
