<?php

namespace XhprofEmbed\Gui\Render;

use XhprofEmbed\Gui\Data\Provider;

class TplRenderer implements Renderer {
	private $baseUrl;
	private $provider;
	private $filters;
	private $template;
	private $twig;
	public $params;

	public function __construct($baseUrl, $params, Provider $provider, $filters, $twig, $template) {
		$this->baseUrl = $baseUrl;
		$this->params = $params;
		$this->provider = $provider;
		$this->filters = (array) $filters;
		$this->template = $template;
		$this->twig = $twig;
	}

	public function link($params = []) {
		return $this->baseUrl . '?' . http_build_query($params);
	}

	public function render() {
		$template = $this->template . '.html';
		$data = ['renderer' => $this];
		try {
			$d = $this->provider->getData($this->params);
			foreach ($this->filters as $filter) {
				$d = $filter->filter($d);
			}
			$data['data'] = $d;
		} catch (\Exception $e) {
			$template = 'error.html';
			$data['exception'] = $e;
		}
		echo $this->twig->render($template, $data);
	}
}
