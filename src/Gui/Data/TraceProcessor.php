<?php

namespace XhprofEmbed\Gui\Data;

use XhProf\Graph\Loader\GraphLoader;
use XhProf\Graph\Graph;
use XhProf\Trace;
use XhprofEmbed\Gui\Utils;

class TraceProcessor {
    private $graph;

    public function __construct(Trace $trace) {
        $this->graph = (new GraphLoader)->load($trace);
    }

    private function aggregate($arrays, $sum = true) {
        $result = [];
        foreach ($arrays as $array) {
            foreach ($array as $k => $v) {
                $diff = $sum ? $v : -$v;
                $result[$k] = isset($result[$k]) ? $result[$k] + $diff : $v;
            }
        }
        return $result;
    }

    public function getVertexWeights($vertex) {
        $extractor = new WeightsExtractor($vertex);

        $weights = $this->aggregate($extractor->parents(true));
        $exWeights = array_diff_key(
            $this->aggregate([$weights, $this->aggregate($extractor->childs(true))], false),
            ['ct' => 0]
        );

        return array_merge($weights, array_combine(Utils::getExNames(array_keys($exWeights)), $exWeights));
    }

	public function getTotals() {
		$totals = ['ct' => 0];
        foreach ($this->getVertices() as $vertex) {
			if ($vertex->getName() == Graph::ROOT) {
				$childs = (new WeightsExtractor($vertex))->childs(true);
				$totals = array_merge(array_shift($childs), $totals);
			} else {
				$totals['ct'] += Utils::colSum((new WeightsExtractor($vertex))->parents(true), 'ct');
            }
        }
        return $totals;
	}

    public function getVertices() {
        return $this->graph->getVertices();
    }

    public function getVertex($name) {
        return $this->graph->getVertex($name);
    }
}
