<?php

namespace XhprofEmbed\Gui\Filters;

use XhprofEmbed\Gui\Utils;

class SortFilter implements Filter {
	private $order;
	private $direction;

	public function __construct($params) {
		$this->order = isset($params['order']) ? $params['order'] : null;
		$this->direction = isset($params['reverse']) && $params['reverse'] ? -1 : 1;
	}

	private function sort(&$rows) {
		$by = $this->order;
		if (!$rows || !isset($rows[0][$by])) {
			return;
		}
		usort(
			$rows,
			function ($a, $b) use ($by) {
				return $this->direction * strnatcasecmp($a[$by], $b[$by]);
			}
		);
	}

	private function recursiveSort(&$data) {
		if (Utils::isNumericArray($data)) {
			$this->sort($data);
		}
		foreach ($data as &$d) {
			if (is_array($d)) {
				$this->recursiveSort($d);
			}
		}
	}

	public function filter($data) {
		if ($this->order) {
			$this->recursiveSort($data);
		}
		return $data;
	}
}
