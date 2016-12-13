<?php

namespace XhprofEmbed\Tests\Gui\Data;

use XhprofEmbed\Gui\Data\TokensProvider;
use XhProf\Context\Context;
use XhProf\Context\Bag;
use XhProf\Trace;

class TokensProviderTest extends BaseFuncProviderTest {
	public function testGetData() {
		$time = time();
		$context = new Context;
		$context->setBag('headers', new Bag(['_host' => 'host1']));
		$context->setBag('server', new Bag(['request_time' => $time]));
		$context->setBag('xhprof-embed', new Bag(['time' => $time]));

		$trace = new Trace('', [], $context);
		$this->storage->method('getTokens')->willReturn(['token1']);
		$this->storage->method('fetch')->willReturn($trace);
		$provider = new TokensProvider($this->storage);
		$this->assertEquals(
			[['token' => 'token1', 'time' => date('Y-m-d h:i:s'), 'host' => 'host1']],
			$provider->getData([])
		);
	}
}
