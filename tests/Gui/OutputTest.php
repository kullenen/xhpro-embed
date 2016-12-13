<?php

namespace XhprofEmbed\Tests\Gui;

use XhprofEmbed\Gui\Output;
use XhprofEmbed\Config\Config;

class OutputTest extends \PHPUnit_Framework_TestCase {
	public function dataProvider() {
		return [
			['hook', 'hook', true],
			['hook', 'book', false],
		];
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testGenerate($hookUrl, $requestUri, $output) {
		$config = new Config;
		$config->read("[gui]\nhookUrl='$hookUrl'");
		$this->assertEquals($output, (new Output($config))->generate(['REQUEST_URI' => $requestUri], []));
	}

	public function setUp() {
		ob_start();
	}

	public function tearDown() {
		ob_get_clean();
	}
}
