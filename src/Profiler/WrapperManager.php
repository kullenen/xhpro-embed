<?php

namespace XhprofEmbed\Profiler;

class WrapperManager {
	private $wrapper;

	public function __construct(WrapperInterface $wrapper) {
		$this->wrapper = $wrapper;
		$this->wrapper->start();
	}

	public function __destruct() {
		$this->wrapper->stop();
	}
}
