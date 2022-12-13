<?php

namespace Capevace\GPT\Serializable;

class GPTRent extends GPTSerializable
{

	public function __construct(
		public string $cold,
		public string $warm,
		public string $tax,
		public string $total,
	) {
	}
}
