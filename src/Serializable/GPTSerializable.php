<?php

namespace Capevace\GPT\Serializable;

use JsonSerializable;

/**
 * This class is a helper for serializing objects to JSON.
 *
 * This is useful if you're trying to embed a JSON object into your prompt,
 * which should follow a specific format.
 */
abstract class GPTSerializable implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
