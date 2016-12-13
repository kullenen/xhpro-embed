<?php

namespace XhprofEmbed\Gui\Data;

class ContextProvider extends BaseProvider {
    public function getData($params) {
		$data = [];
        $trace = $this->storage->fetch($params['token']);
		$context = $trace->getContext();
		if ($context) {
			foreach ($context->all() as $name => $bag) {
				$data[$name] = $bag->all();
			}
		}
		return $data;
    }
}
