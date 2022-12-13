<?php

namespace Capevace\GPT\Support;

use Exception;

/**
 * Represents an error that occurred while interacting with the GPT3 API.
 */
class GPTException extends Exception
{
	protected string $type;

	public function __construct(
		string $message,
		string $type
	) {
		parent::__construct($message);

		$this->type = $type;
	}
}
