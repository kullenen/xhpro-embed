<?php
namespace XhprofEmbed\Tests\Profiler;

use XhprofEmbed\Profiler\AutoStart;
use XhprofEmbed\Config\Config;

class AutoStartTest extends \PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return [
			'no active' => ['0', '0', null, [], null, [], 0],
			'active, no filtering' => [ '1', '0', null, [], null, [], 1],
			'active, empty filtering' => [ '1', '1', null, [], null, [], 1],
			'active, filtering by argv' => [ '1', '1', '/test0/', ['test0'], null, [], 1],
			'active, negative filtering by argv' => [ '1', '1', '/test1/', ['test0'], null, [], 0],
			'active, filtering by server' => [ '1', '1', null, [], '/test0/', ['SERVER_NAME' => 'test0'], 1],
			'active, negative filtering by server' => [ '1', '1', null, [], '/test1/', ['SERVER_NAME' => 'test0'], 0],
		];
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testStart($active, $filtering, $argvFilter, $argv, $serverFilter, $server, $calls) {
		$wrapper = $this->getMockBuilder('\XhprofEmbed\Profiler\WrapperInterface')->getMock();
		$wrapper->expects($this->exactly($calls))->method('start');

		$factory = $this->getMockBuilder('\XhprofEmbed\Profiler\WrapperFactory')->getMock();
		$factory->method('createFromConfig')->willReturn($wrapper);

		$config = new Config;
		$config->read(
			sprintf(
				"[profiler]\nactive='%s'\nfiltering='%s'\n%s\n%s",
				$active,
				$filtering,
				$argvFilter ? "argv_filters['0']='$argvFilter'" : '',
				$serverFilter ? "_server_filters['SERVER_NAME']='$serverFilter'" : ''
			)
		);

		AutoStart::start($config, $factory, $argv, $server);
	}
}
