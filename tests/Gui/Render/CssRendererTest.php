<?php

namespace XhprofEmbed\Tests\Gui\Render;

use XhprofEmbed\Gui\Render\CssRenderer;

class CssRendererTest extends \PHPUnit_Framework_TestCase {
	
	public function testRender() {
		ob_start();
		$renderer = new CssRenderer;
		$renderer->render();
		$this->assertEquals(ob_get_clean(), file_get_contents(__DIR__ . '/../../../src/Gui/templates/main.css'));
	}
}
