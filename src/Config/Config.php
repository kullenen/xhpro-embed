<?php

namespace XhprofEmbed\Config;

class Config {
	private $ini;

	private static function getDefault() {
		return [
			'common' => [
				'storage' => 'XhProf\Storage\FileStorage',
			],
			'profiler' => [
				'active' => '0',
				'flags' => [
					'XHPROF_FLAGS_NO_BUILTINS' => '0',
					'XHPROF_FLAGS_CPU' => '1',
					'XHPROF_FLAGS_MEMORY' => '1'
				],
				'filtering' => '1',
				'_server_filters' => [
					'SERVER_NAME' => '/.*/',
					'REQUEST_URI' => '/.*/'
				],
				'argv_filters' => [
					0 => '/.*/'
				],
			],
			'gui' => [
				'hookUrl' => '/xhprof-embed'
			]
		];
	}

	public function __construct() {
		$this->ini = $this->getDefault();
	}

	public function read($iniString) {
		$this->ini = array_replace_recursive($this->getDefault(), parse_ini_string($iniString, true));
	}

	public function write() {
		$ini = [];
		foreach ($this->ini as $section => $lines) {
			$ini[] = "[$section]";
			foreach ($lines as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $k => $v) {
						$ini[] = "{$key}['$k']='$v'";
					}
					continue;
				}
				$ini[] = "$key='$val'";
			}
		}
		return implode(PHP_EOL, $ini);
	}

	public function getValue($section, $key) {
		return isset($this->ini[$section][$key]) ? $this->ini[$section][$key] : null;
	}

	public static function create($file = null) {
		$config = new self;
		if ($file && file_exists($file)) {
			$config->read(file_get_contents($file));
		}
		return $config;
	}
}
