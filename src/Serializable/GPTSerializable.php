<?php

namespace Capevace\GPT\Serializable;

use JsonSerializable;

abstract class GPTSerializable implements JsonSerializable
{
	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}
}
