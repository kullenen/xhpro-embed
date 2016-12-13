<?php

namespace XhprofEmbed\Gui;

class Utils {
	public static function isNumericArray($array) {
		foreach (array_keys($array) as $i) {
			if (!is_int($i)) {
				return false;
			}
		}
		return true;
	}

	public static function getExNames($names) {
		return array_map(
			function ($name) {
				return "ex.$name";
			},
			$names
		);
	}

	public static function calcPercents(&$data, $totals) {
		foreach ($data as &$row) {
			foreach ($totals as $k => $sum) {
				if (isset($row[$k])) {
					$row['pr.' . $k] = $sum ? sprintf('%4.1f', 100 * $row[$k] / $sum) : 'N/A';
				}
			}
		}
	}

	public static function colSum($array, $colName) {
		$sum = 0;
		foreach ($array as $a) {
			$sum += $a[$colName];
		}
		return $sum;
	}
}
