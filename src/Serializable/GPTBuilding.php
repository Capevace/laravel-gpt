<?php

namespace Capevace\GPT\Serializable;

class GPTBuilding extends GPTSerializable
{
	public function __construct(
		public string $name,
		public string $features,
		public string $address,
		public ?int $floors = null
	) {
	}
}
