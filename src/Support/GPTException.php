<?php

namespace Capevace\GPT\Support;

use Exception;

/**
 * Represents an error that occurred while interacting with the GPT3 API.
 */
class GPTException extends Exception
{
    public function __construct(
        string $message,
        public readonly string $type
    ) {
        parent::__construct($message);
    }
}
