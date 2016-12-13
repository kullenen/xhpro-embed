<?php

namespace XhprofEmbed\Profiler;

use XhProf\Storage\StorageInterface;
use XhProf\Trace;
use XhProf\Context\ContextFactory;
use XhProf\Context\Bag;

class Xhprof implements WrapperInterface {
	private $flags;
	private $options;
	private $storage;
	private static $started;

	public function __construct(StorageInterface $storage, $flags = null, $options = []) {
		$this->flags = $flags ?: (XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
		$this->options = (array) $options;
		$this->storage = $storage;
	}

	public function start() {
		if (self::$started) {
			xhprof_disable();
		}
		xhprof_enable($this->flags, $this->options);
		self::$started = true;
	}

	public function stop() {
		if (self::$started) {
			self::$started = false;
			$data = xhprof_disable();
			$context = ContextFactory::create();
			$context->setBag('xhprof-embed', new Bag(['time' => time()]));
			$this->storage->store(new Trace(uniqid(), $data, $context));
		}
	}
}
