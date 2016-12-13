<?php

namespace XhprofEmbed\Tests\Profiler;

use XhprofEmbed\Profiler\Xhprof;

/**
 * @requires extension xhprof
 */
class XhprofTest extends \PHPUnit_Framework_TestCase {
	private function functionWithSomeName() {
		// do nothing
	}

	public function mustExists($trace) {
		if (!$trace) {
			return false;
		}
		return array_key_exists('main()==>' . __CLASS__ . '::functionWithSomeName', $trace->getData());
	}

	public function mustNotExists($trace) {
		if (!$trace) {
			return false;
		}
		return !array_key_exists('main()==>' . __CLASS__ . '::functionWithSomeName', $trace->getData());
	}

	private function getStorageMock(callable $storageCallBack) {
		$storage = $this->getMockBuilder('\XhProf\Storage\StorageInterface')->getMock();
		$storage->expects($this->once())->method('store')->with($this->callback($storageCallBack));
		return $storage;
	}

	public function testStartAndStop() {
		$xhprof = new Xhprof($this->getStorageMock([$this, 'mustExists']));
		$xhprof->start();
		$this->functionWithSomeName();
		$xhprof->stop();
	}

	public function testDoubleStartAndStop() {
		$xhprof = new Xhprof($this->getStorageMock([$this, 'mustNotExists']));
		$xhprof->start();
		$this->functionWithSomeName();
		$xhprof->start();
		$xhprof->stop();
	}
}
