<?php

namespace XhprofEmbed\Gui\Render;

use XhProf\Graph\Loader\GraphLoader;
use XhProf\Graph\Dumper\GraphvizDumper;
use XhProf\Storage\StorageInterface;

/**
 * @codeCoverageIgnore
 */
class GraphRenderer implements Renderer {

	private $params;
	private $storage;

	public function __construct(StorageInterface $storage, $params) {
		$this->params = $params;
		$this->storage = $storage;
	}

	public function render() {
		header('Content-type: image/png');
		echo (new GraphvizDumper)->dump((new GraphLoader)->load($this->storage->fetch($this->params['token'])));
	}
}
