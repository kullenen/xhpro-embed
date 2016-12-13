<?php

namespace XhprofEmbed\Storage;

use XhProf\Storage\StorageInterface;
use XhProf\Trace;
use XhProf\Context\Context;
use XhProf\Context\Bag;

/**
 * @codeCoverageIgnore
 * Saves profiler results to file with XhProf default format
 */
class DefaultFileStorage implements StorageInterface {

	private $fileMask;

	public function __construct() {
		$dir = ini_get("xhprof.output_dir") ?: sys_get_temp_dir();
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$this->fileMask = "$dir/%s.xhprof";
	}

	private function getFileName($token) {
		return sprintf($this->fileMask, $token);
	}

	private function parseFileName($fileName) {
		$parts = explode('.', basename($fileName, '.xhprof'));
		return [
			'token' => $parts[0],
			'namespace' => isset($parts[1]) ? $parts[1] : '',
			'time' => filectime($fileName)
		];
	}

	public function store(Trace $trace) {
		$fileName = $this->getFileName($trace->getToken() . '.embed');
		if (!@file_put_contents($fileName, serialize($trace->getData()))) {
			throw new \RuntimeException(sprintf('Could not write data in file %s', $fileName));
		}
	}

	private function createContext($fileName) {
		$context = new Context();
		$context->setBag('xhprof-embed', new Bag($this->parseFileName($fileName)));
		return $context;
	}

	public function fetch($token) {
		$fileName = $this->getFilename($token);
		if (!$data = @file_get_contents($fileName)) {
			throw new \RuntimeException(sprintf('Could not read data from file %s', $fileName));
		}
		return new Trace($token, unserialize($data), $this->createContext($fileName));
	}

	public function getTokens() {
		$files = new \GlobIterator($this->getFilename('*'));
		$tokens = [];
		foreach ($files as $file) {
			$tokens[] = $file->getBasename('.xhprof');
		}
		return $tokens;
	}
}
