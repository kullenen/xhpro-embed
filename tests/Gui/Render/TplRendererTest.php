<?php

namespace XhprofEmbed\Tests\Gui\Render;

use XhprofEmbed\Gui\Render\TplRenderer;
use XhprofEmbed\Gui\Data\Provider;

class TplRendererTest extends \PHPUnit_Framework_TestCase {

	private $provider;
	private $twig;
	private static $data = 'tplData';

	public function setUp() {
		$this->provider = $this->getMockBuilder('\XhprofEmbed\Gui\Data\Provider')->getMock();
		$this->twig = $this->getMockBuilder('\Twig_Environment')->getMock();
		ob_start();
	}

	public function tearDown() {
		ob_get_clean();
	}

	public function testRender() {
		$this->provider->expects($this->once())->method('getData')->willReturn(self::$data);
		$filter = $this->getMockBuilder('\XhprofEmbed\Gui\Filters\Filter')->getMock();
		$filter->expects($this->once())->method('filter')->with($this->equalTo(self::$data))->willReturn(self::$data);

		$renderer = new TplRenderer('', [], $this->provider, [$filter], $this->twig, 'tplName');

		$this->twig->expects($this->once())->method('render')
			->with(
				$this->equalTo('tplName.html'),
				$this->equalTo(['renderer' => $renderer, 'data' => self::$data])
			);

		$renderer->render();
	}

	public function testRenderError() {
		$exception = new \Exception;
		$this->provider->expects($this->once())->method('getData')->will($this->throwException($exception));

		$renderer = new TplRenderer('', [], $this->provider, [], $this->twig, 'tplName');

		$this->twig->expects($this->once())->method('render')
			->with(
				$this->equalTo('error.html'),
				$this->equalTo(['renderer' => $renderer, 'exception' => $exception])
			);

		$renderer->render();
	}

	public function testLink() {
		$renderer = new TplRenderer('/base_url', [], $this->provider, [], $this->twig, 'tplName');
		$this->assertEquals('/base_url?a=1&b=2&c=3', $renderer->link(['a' => 1, 'b' => 2, 'c' => 3]));
	}
}
