<?php

namespace XhprofEmbed\Tests\Gui\Data;

use XhprofEmbed\Gui\Data\FunctionProvider;

class FunctionProviderTest extends BaseFuncProviderTest {
	private $expected = [
		'foo' => [
			'function' => [
				[
					'fn' => 'foo', 'ct' => 3, 'pr.ct' => '14.3', 'wt' => 104, 'pr.wt' => '74.8',
					'cpu' => 0, 'pr.cpu' => 'N/A', 'mu' => 4168, 'pr.mu' => '70.2',
					'pmu' => 0, 'pr.pmu' => 'N/A', 'ex.wt' => 64, 'pr.ex.wt' => '61.5',
					'ex.cpu' => 0, 'pr.ex.cpu' => 'N/A', 'ex.mu' => 1336, 'pr.ex.mu' => '32.1',
					'ex.pmu' => 0, 'pr.ex.pmu' => 'N/A'
				],
			],
			'parents' => [
				[
					'fn' => 'main()', 'ct' => 3, 'pr.ct' => '100', 'wt' => 104, 'pr.wt' => '100',
					'cpu' => 0, 'pr.cpu' => 'N/A', 'mu' => 4168, 'pr.mu' => '100', 'pmu' => 0, 'pr.pmu' => 'N/A'
				]
			],
			'childs' => [
				[
					'fn' => 'bar', 'ct' => 6, 'pr.ct' => '54.5', 'wt' => 37, 'pr.wt' => '35.6',
					'cpu' => 0, 'pr.cpu' => 'N/A', 'mu' => 2208, 'pr.mu' => '53.0', 'pmu' => 0, 'pr.pmu' => 'N/A'
				],
				[
					'fn' => 'strlen', 'ct' => 5, 'pr.ct' => '45.5', 'wt' => 3, 'pr.wt' => '2.9',
					'cpu' => 0, 'pr.cpu' => 'N/A', 'mu' => 624, 'pr.mu' => '15.0', 'pmu' => 0, 'pr.pmu' => 'N/A'
				]
			],
		]
	];

	public function noFunctionDataProvider() {
		return [['no_existing_function'], ['__root__']];
	}

	public function testGetData() {
		$this->storage->method('fetch')->willReturn($this->trace);
		$provider = new FunctionProvider($this->storage);
		$this->assertEquals(
			$this->sortArray($this->expected['foo']),
			$this->sortArray($provider->getData(['token' => '', 'fn' => 'foo']))
		);
	}

	/**
	 * @dataProvider noFunctionDataProvider
	 * @expectedException Exception
	 */
	public function testNotFound($function) {
		$this->storage->method('fetch')->willReturn($this->trace);
		$provider = new FunctionProvider($this->storage);
		$provider->getData(['token' => '', 'fn' => $function]);
	}

	public function testNoParents() {
		$this->storage->method('fetch')->willReturn($this->trace);
		$provider = new FunctionProvider($this->storage);
		$data = $provider->getData(['token' => '', 'fn' => 'main()']);
		$this->assertCount(0, $data['parents']);
	}
}
