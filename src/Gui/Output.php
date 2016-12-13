<?php

namespace XhprofEmbed\Gui;

use XhprofEmbed\Config\Config;

class Output {
	private $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	private function getBaseUrl($serverVars) {
		if (!isset($serverVars['REQUEST_URI'])) {
			return false;
		}

		$uri = parse_url($serverVars['REQUEST_URI']);
		$baseUrl = $uri['path'];
		$hookUrl = $this->config->getValue('gui', 'hookUrl');
		return !strcasecmp(substr($baseUrl, 0, strlen($hookUrl)), $hookUrl) ? $baseUrl : false;
	}

	public function generate($serverVars, $get) {
		$baseUrl = self::getBaseUrl((array) $serverVars);
		if ($baseUrl) {
			$storage = $this->config->getValue('common', 'storage');
			(new Render\Factory)->create(new $storage, $baseUrl, $get)->render();
			return true;
		}
		return false;
	}
}
