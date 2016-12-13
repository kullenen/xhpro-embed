<?php

namespace XhprofEmbed\Gui\Data;

use XhProf\Graph\Graph;
use XhprofEmbed\Gui\Utils;

class FunctionsProvider extends BaseProvider {
    public function getData($params) {
		$trace = $this->storage->fetch($params['token']);
        $processor = new TraceProcessor($trace);
        $rows = [];
        foreach ($processor->getVertices() as $vertex) {
			if ($vertex->getName() != Graph::ROOT) {
                $rows[] = array_merge(['fn' => $vertex->getName()], $processor->getVertexWeights($vertex));
            }
        }

		$incTotals = $processor->getTotals();
		if ($rows) {
			$exTot = array_diff_key($incTotals, ['ct' => 0]);
			$sums = array_merge($incTotals, array_combine(Utils::getExNames(array_keys($exTot)), $exTot));
			Utils::calcPercents($rows, $sums);
		}

        return [ 'totals' => $incTotals, 'all' => $rows ];
    }
}
