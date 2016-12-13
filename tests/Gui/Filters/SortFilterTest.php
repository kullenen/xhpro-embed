<?php

namespace XhprofEmbed\Tests\Gui\Filters;

use XhprofEmbed\Gui\Filters\SortFilter;

class SortFilterTest extends \PHPUnit_Framework_TestCase {


	public function dataProvider() {
		return [
			'no sort by default' => [
				[ ['b' => 3], ['b' => 2], ['b' => 4], ],
				[],
				[ ['b' => 3], ['b' => 2], ['b' => 4], ],
			],
			'sort by existing column' => [
				[ ['a' => 3], ['a' => 2], ['a' => 1], ],
				['order' => 'a'],
				[ ['a' => 1], ['a' => 2], ['a' => 3], ],
			],
			'sort by existing column, desc' => [
				[ ['a' => 1,], ['a' => 2], ['a' => 3], ],
				['order' => 'a', 'reverse' => 1],
				[ ['a' => 3], ['a' => 2], ['a' => 1], ],
			],
			'sort by existing column, asc' => [
				[ ['a' => 1], ['a' => 2], ['a' => 3],	],
				['order' => 'a', 'reverse' => 0],
				[ ['a' => 1], ['a' => 2], ['a' => 3], ],
			],
			'sort by fn column, asc' => [
				[ ['fn' => 'b'], ['fn' => 'a'], ['fn' => 'c'],	],
				['order' => 'fn'],
				[ ['fn' => 'a'], ['fn' => 'b'], ['fn' => 'c'],	],
			],
			'sort by not existing column' => [
				[ ['a' => 2], ['a' => 1], ['a' => 3],	],
				['order' => 'c'],
				[ ['a' => 2], ['a' => 1], ['a' => 3], ],
			],
			'sort recursively' => [
				[
					[
						'one' => [ ['a' => 3], ['a' => 2], ['a' => 1], ],
						[
							'two' => [ ['a' => 3], ['a' => 2], ['a' => 1], ]
						]
					]
				],
				['order' => 'a'],
				[
					[ 'one' => [ ['a' => 1], ['a' => 2], ['a' => 3], ],
					  [
						  'two' => [ ['a' => 1], ['a' => 2], ['a' => 3], ]
					  ]
					]
				],
			]
		];
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testFilter($input, $params, $expected) {
		$this->assertEquals($expected, (new SortFilter($params))->filter($input));
	}
}
