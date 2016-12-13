<?php

namespace XhprofEmbed\Profiler;

use XhProf\Storage\StorageInterface;
use XhprofEmbed\Config\Config;

class WrapperFactory {
	public function create(StorageInterface $storage, $flags = null, $options = []) {
		if (extension_loaded('xhprof')) {
			return new Xhprof($storage, $flags, $options);
		}
		return new Dummy;
	}

	public function createFromConfig(Config $config) {
		$flags = 0;
		foreach ((array) $config->getValue('profiler', 'flags') as $flag => $on) {
			if ($on && defined($flag)) {
				$flags |= constant($flag);
			}
		}

		$storage = $config->getValue('common', 'storage');

		return $this->create(new $storage, $flags, []);
	}
}
