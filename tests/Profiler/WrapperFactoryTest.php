<?php

namespace XhprofEmbed\Tests\Profiler;

use XhprofEmbed\Profiler\WrapperFactory;
use XhprofEmbed\Profiler\WrapperInterface;
use XhprofEmbed\Config\Config;

class WrapperFactoryTest extends \PHPUnit_Framework_TestCase {
	public function testCreate() {
		$storage = $this->getMockBuilder('\XhProf\Storage\StorageInterface')->getMock();
		$this->assertInstanceOf(WrapperInterface::class, (new WrapperFactory)->create($storage));
	}

	public function testCreateFromConfig() {
		$this->assertInstanceOf(WrapperInterface::class, (new WrapperFactory)->createFromConfig(new Config));
	}
}
