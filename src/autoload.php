<?php

namespace XhprofEmbed;

global $argv;

if (!strcasecmp('cli', php_sapi_name()) && isset($argv[0]) && stripos($argv[0], 'phpunit')) {
	return;
}

$config = Config\Config::create(getcwd() . '/xhprof-embed.ini');
if ((new Gui\Output($config))->generate($_SERVER, $_GET)) {
	exit;
}

if (extension_loaded('xhprof')) {
	Profiler\AutoStart::start($config, new Profiler\WrapperFactory, $argv, $_SERVER);
}
