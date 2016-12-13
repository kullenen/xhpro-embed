<?php

namespace XhprofEmbed\Tests\Gui\Filters;

use XhprofEmbed\Gui\Filters\LimitFilter;

class LimitFilterTest extends \PHPUnit_Framework_TestCase {

	private static $input = [
		'a' => [1,2,3,4,5],
		'b' => [1,2,3,4,5,6,7,8,9]
	];

	public function dataProvider() {
		return [
			'limit to less then' => [self::$input, 3, [ 'a' => [1,2,3], 'b' => [1,2,3] ]],
			'limit to 0' => [self::$input, 0, self::$input],
			'limit to more then' => [self::$input, 100, self::$input],
		];
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testFilter($input, $limit, $expected) {
		$this->assertEquals($expected, (new LimitFilter(['limit' => $limit]))->filter($input));
	}
}
