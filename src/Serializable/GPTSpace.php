<?php

namespace Capevace\GPT\Serializable;

class GPTSpace extends GPTSerializable
{
    public function __construct(
        public string $name,
        public string $type,
        public string $features,
        public GPTBuilding $building,
        public string $floor,
        public string $rentPerM2,
        public string $extraCostsPerM2,
        public string $area,
        public string $sharedArea,
        public string $totalArea
    ) {
    }
}
