<?php

namespace XhprofEmbed\Tests\Gui\Render;

use XhprofEmbed\Gui\Render\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase {

	public function createDataProvider() {
		return [
			[['css' => 1], \XhprofEmbed\Gui\Render\CssRenderer::class],
			[['token' => '', 'graph' => 1], \XhprofEmbed\Gui\Render\GraphRenderer::class],
			[[],  \XhprofEmbed\Gui\Render\TplRenderer::class],
			[['token' => ''], \XhprofEmbed\Gui\Render\TplRenderer::class],
			[['token' => '',  'context' => 1], \XhprofEmbed\Gui\Render\TplRenderer::class],
			[['token' => '',  'fn' => 'someFun'], \XhprofEmbed\Gui\Render\TplRenderer::class],
		];
	}

	/**
	 * @dataProvider createDataProvider
	 */
	public function testCreate($params, $class) {
		$storage = $this->getMockBuilder('\XhProf\Storage\StorageInterface')->getMock();
		$renderer = (new Factory)->create($storage, '', $params);
		$this->assertInstanceOf(\XhprofEmbed\Gui\Render\Renderer::class, $renderer);
		$this->assertInstanceOf($class, $renderer);
	}
}
