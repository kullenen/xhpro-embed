<?php

namespace XhprofEmbed\Tests\Gui\Data;

use XhprofEmbed\Gui\Data\FunctionsProvider;

class FunctionsProviderTest extends BaseFuncProviderTest {

	private $expected = [
		'totals' => ['ct' => '21', 'wt' => '139', 'cpu' => '0', 'mu' => '5936', 'pmu' => '0'],
		'all' => [
			[
				'fn' => 'main()', 'ct' => '1', 'pr.ct' => '4.8', 'wt' => '139', 'pr.wt' => '100.0',
				'ex.wt' => '34', 'pr.ex.wt' => '24.5', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '5936', 'pr.mu' => '100.0',
				'ex.mu' => '1424', 'pr.ex.mu' => '24.0', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			],
			[
				'fn' => 'foo', 'ct' => '3', 'pr.ct' => '14.3', 'wt' => '104', 'pr.wt' => '74.8',
				'ex.wt' => '64', 'pr.ex.wt' => '46.0', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '4168', 'pr.mu' => '70.2',
				'ex.mu' => '1336', 'pr.ex.mu' => '22.5', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			],
			[
				'fn' => 'bar', 'ct' => '6', 'pr.ct' => '28.6', 'wt' => '37', 'pr.wt' => '26.6',
				'ex.wt' => '35', 'pr.ex.wt' => '25.2', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '2208', 'pr.mu' => '37.2',
				'ex.mu' => '1352', 'pr.ex.mu' => '22.8', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			],
			[
				'fn' => 'strlen', 'ct' => '5', 'pr.ct' => '23.8', 'wt' => '3', 'pr.wt' => '2.2',
				'ex.wt' => '3', 'pr.ex.wt' => '2.2', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '624', 'pr.mu' => '10.5',
				'ex.mu' => '624', 'pr.ex.mu' => '10.5', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			],
			[
				'fn' => 'bar@1', 'ct' => '4', 'pr.ct' => '19.0', 'wt' => '2', 'pr.wt' => '1.4',
				'ex.wt' => '2', 'pr.ex.wt' => '1.4', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '856', 'pr.mu' => '14.4',
				'ex.mu' => '856', 'pr.ex.mu' => '14.4', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			],
			[
				'fn' => 'xhprof_disable', 'ct' => '2', 'pr.ct' => '9.5', 'wt' => '1', 'pr.wt' => '0.7',
				'ex.wt' => '1', 'pr.ex.wt' => '0.7', 'cpu' => '0', 'pr.cpu' => 'N/A',
				'ex.cpu' => '0', 'pr.ex.cpu' => 'N/A', 'mu' => '344', 'pr.mu' => '5.8',
				'ex.mu' => '344', 'pr.ex.mu' => '5.8', 'pmu' => '0', 'pr.pmu' => 'N/A',
				'ex.pmu' => '0', 'pr.ex.pmu' => 'N/A'
			]
		]
	];

	public function testGetData() {
		$this->storage->method('fetch')->willReturn($this->trace);
		$provider = new FunctionsProvider($this->storage);
		$this->assertEquals($this->sortArray($this->expected), $this->sortArray($provider->getData(['token' => ''])));
	}
}
