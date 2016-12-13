<?php

namespace XhprofEmbed\Gui\Data;

use XhprofEmbed\Gui\Utils;
use XhProf\Graph\Graph;

class FunctionProvider extends BaseProvider {
	private function getIncPart($functionRow) {
		$incData = [];
		foreach ($functionRow as $k => $v) {
			if ($k == 'ct' || substr($k, 0, 3) == 'ex.') {
				continue;
			}
			$incData[$k] = $v;
		}
		return $incData;
	}

	private function functionPercents($functionRow, $incTotals) {
		$tot = $this->getIncPart($functionRow);
		$exTot = array_combine(Utils::getExNames(array_keys($tot)), $tot);
		$rows = [$functionRow];
		Utils::calcPercents($rows, array_merge($incTotals, $exTot));
		return $rows[0];
	}

	private function percents($rows, $functionRow) {
		Utils::calcPercents(
			$rows,
			array_merge([ 'ct' => Utils::colSum($rows, 'ct')], $this->getIncPart($functionRow))
		);
		return $rows;
	}

    public function getData($params) {
        $processor = new TraceProcessor($this->storage->fetch($params['token']));

        $fname = isset($params['fn']) ? $params['fn'] : '';
        $vertex = $processor->getVertex($fname);
        if (!$vertex || $fname == Graph::ROOT) {
            throw new \Exception("Function '$fname' not found");
        }

        $extractor = new WeightsExtractor($vertex);
		$functionRow = $processor->getVertexWeights($vertex);

        return [
			'function' => [
				array_merge(
					['fn' => $vertex->getName()],
					$this->functionPercents($functionRow, $processor->getTotals())
				)
			],
			'parents' => $this->percents(
				array_filter(
					$extractor->parents(false),
					function ($row) {
						return $row['fn'] != Graph::ROOT;
					}
				),
				$functionRow
			),
			'childs' => $this->percents($extractor->childs(false), $functionRow)
        ];
    }
}
