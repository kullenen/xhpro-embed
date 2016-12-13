<?php

namespace XhprofEmbed\Gui\Data;

use XhProf\Context\Context;

class TokensProvider extends BaseProvider {
	private function readContext(Context $context) {
		$all = $context->all();

		if (isset($all['headers'])) {
			$host = $context->getBag('headers')->get('_host', 'N/A');
		}

		if (isset($all['server'])) {
			$time = $context->getBag('server')->get('request_time');
		}

		if (isset($all['xhprof-embed'])) {
			$time = $context->getBag('xhprof-embed')->get('time');
		}

		return ['time' => $time ? date('Y-m-d h:i:s', $time) : null, 'host' => $host];
	}

    public function getData($params) {
		return array_map(
			function ($t) {
				$trace = $this->storage->fetch($t);
				$ctxData = $trace->getContext() ? $this->readContext($trace->getContext()) : [];
				return array_merge(['token' => $t], $ctxData);
			},
			$this->storage->getTokens()
		);
    }
}
