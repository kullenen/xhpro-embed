<?php

namespace XhprofEmbed\Gui\Filters;

use XhprofEmbed\Gui\Utils;

class LimitFilter implements Filter {
	private $limit;

	public function __construct($params) {
		$this->limit = isset($params['limit']) ? $params['limit'] : 0;
	}

	private function recursiveLimit(&$data) {
		if (!$this->limit) {
			return;
		}
		if (Utils::isNumericArray($data)) {
			array_splice($data, $this->limit);
		}
		foreach ($data as &$d) {
			if (is_array($d)) {
				$this->recursiveLimit($d);
			}
		}
	}

	public function filter($data) {
		$this->recursiveLimit($data);
		return $data;
	}
}
