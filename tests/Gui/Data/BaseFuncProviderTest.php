<?php

namespace XhprofEmbed\Tests\Gui\Data;

use XhprofEmbed\Gui\Utils;

abstract class BaseFuncProviderTest extends \PHPUnit_Framework_TestCase {
	private static $traceData = [
		'foo==>bar' => ['ct' => 6, 'wt' => 37, 'cpu' => 0, 'mu' => 2208, 'pmu' => 0],
		'foo==>strlen' => ['ct' => 5, 'wt' => 3, 'cpu' => 0, 'mu' => 624, 'pmu' => 0],
		'bar==>bar@1' => ['ct' => 4, 'wt' => 2, 'cpu' => 0, 'mu' => 856, 'pmu' => 0],
		'main()==>foo' => ['ct' => 3, 'wt' => 104, 'cpu' => 0, 'mu' => 4168, 'pmu' => 0],
		'main()==>xhprof_disable' => ['ct' => 2, 'wt' => 1, 'cpu' => 0, 'mu' => 344, 'pmu' => 0],
		'main()' => ['ct' => 1, 'wt' => 139, 'cpu' => 0, 'mu' => 5936, 'pmu' => 0],
	];

	protected $storage;
	protected $trace;

	protected function sortArray($array) {
		$result = [];
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				$v = $this->sortArray($v);
			}
			$result[$k] = $v;
		}

		if (Utils::isNumericArray($result)) {
			usort(
				$result, 
				function ($a, $b) {
					return strcmp(serialize($a), serialize($b));
				}
			);
			$result = array_values($result);
		} else {
			ksort($result);
		}
		return $result;
	}

	public function setUp() {
		$this->trace = new \XhProf\Trace('', self::$traceData);
		$this->storage = $this->getMockBuilder('\XhProf\Storage\StorageInterface')->getMock();
	}
}
