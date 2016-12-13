<?php

namespace XhprofEmbed\Gui\Render;

use XhProf\Storage\StorageInterface;

class Factory {
	private function getRenderParams(StorageInterface $storage, $params) {
		if (!isset($params['token'])) {
			return [new \XhprofEmbed\Gui\Data\TokensProvider($storage), 'tokens'];
		}
		if (isset($params['context'])) {
			return [new \XhprofEmbed\Gui\Data\ContextProvider($storage), 'context'];
		}
		if (!isset($params['fn'])) {
			return [new \XhprofEmbed\Gui\Data\FunctionsProvider($storage), 'functions'];
		}
		return [new \XhprofEmbed\Gui\Data\FunctionProvider($storage), 'function'];
	}

	public function create(StorageInterface $storage, $baseUrl, $params) {
		if (isset($params['css'])) {
			return new CssRenderer;
		}
		if (isset($params['graph']) and isset($params['token'])) {
			return new GraphRenderer($storage, $params);
		}

		list($provider, $template) = $this->getRenderParams($storage, $params);

		\Twig_Autoloader::register();
		$loader = new \Twig_Loader_Filesystem(__DIR__ . '/../templates');
		$twig = new \Twig_Environment($loader);

		$filters = (new \XhprofEmbed\Gui\Filters\Factory)->create($params);
		return new TplRenderer($baseUrl, $params, $provider, $filters, $twig, $template);
	}
}
