<?php

namespace Capevace\GPT\Facades;

use Capevace\GPT\GPTService;
use Capevace\GPT\Support\GPTResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static GPTResponse generate(string $prompt, string $model = 'text-davinci-003', float $temperature = 0.83, int $maxTokens = 1200, ?string $stop = null, float $frequencyPenalty = 0.0, float $presencePenalty = 0.0) Send a request to the GPT3 API.
 *
 * @example GPT::generate('Hello, my name is', 'text-davinci-003', 0.83, 1200, null, 0.0, 0.0)
 *
 * @see \Capevace\GPT\Services\GPTService::generate()
 */
class GPT extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GPTService::class;
    }
}
