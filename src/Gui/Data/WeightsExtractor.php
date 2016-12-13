<?php

namespace XhprofEmbed\Gui\Data;

class WeightsExtractor {
    private $vertex;

    public function __construct($vertex) {
        $this->vertex = $vertex;
    }

    private function getWeights($edges, $onlyWeights) {
        return array_map(
            function ($edge) use ($onlyWeights) {
                $v = $edge->getFrom() == $this->vertex ? $edge->getTo() : $edge->getFrom();
                return array_merge(
                    $onlyWeights ? [] : ['fn' => $v->getName()],
                    $edge->getWeights()
                );
            },
            $edges
        );
    }

    public function parents($onlyWeights) {
        return $this->getWeights(
            array_filter(
                $this->vertex->getEdges(),
                function ($edge) use ($onlyWeights) {
                    return $edge->getTo() == $this->vertex;
                }
            ),
            $onlyWeights
        );
    }

    public function childs($onlyWeights) {
        return $this->getWeights(
            array_filter(
                $this->vertex->getEdges(),
                function ($edge) use ($onlyWeights) {
                    return $edge->getFrom() == $this->vertex;
                }
            ),
            $onlyWeights
        );
    }
}
