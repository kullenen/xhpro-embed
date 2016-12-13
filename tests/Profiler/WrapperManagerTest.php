<?php

namespace XhprofEmbed\Tests\Profiler;

use XhprofEmbed\Profiler\WrapperManager;

class WrapperManagerTest extends \PHPUnit_Framework_TestCase {
	public function testWithWrapper() {
		$wrapper = $this->getMockBuilder('\XhprofEmbed\Profiler\WrapperInterface')->getMock();
		$wrapper->expects($this->once())->method('start');
		$wrapper->expects($this->once())->method('stop');
		new WrapperManager($wrapper);
	}
}
