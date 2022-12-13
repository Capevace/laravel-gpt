<?php

namespace Capevace\GPT\Serializable;

class GPTOfferDescriptions extends GPTSerializable
{
	public function __construct(
		public array $spaces,
		public GPTRent $rent,
	) {
	}
}
