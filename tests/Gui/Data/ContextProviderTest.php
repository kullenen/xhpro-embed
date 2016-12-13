<?php

namespace XhprofEmbed\Tests\Gui\Data;

use XhprofEmbed\Gui\Data\ContextProvider;
use XhProf\Context\Context;
use XhProf\Context\Bag;
use XhProf\Trace;

class ContextProviderTest extends BaseFuncProviderTest {
	public function testGetData() {
		$context = new Context;
		$context->setBag('bname', new Bag(['k1' => 'v1']));
		$trace = new Trace('', [], $context);
		$this->storage->method('fetch')->willReturn($trace);
		$provider = new ContextProvider($this->storage);
		$this->assertEquals(['bname' => ['k1' => 'v1']], $provider->getData(['token' => '']));
	}
}
