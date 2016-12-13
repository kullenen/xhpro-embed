<?php

namespace XhprofEmbed\Gui\Filters;

class Factory {
	public function create($params) {
		return array_merge(
			isset($params['order']) ? [new SortFilter($params)] : [],
			isset($params['limit']) ? [new LimitFilter($params)] : []
		);
	}
}
