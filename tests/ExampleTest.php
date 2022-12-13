<?php

use Capevace\GPT\Facades\GPT;
use Capevace\GPT\Support\GPTException;

function ensureAPIKey(bool $shouldEnsureKey = true)
{
    config(['gpt.api_key' => $shouldEnsureKey ? env('OPENAI_API_KEY') : null]);
}

it('can use GPT-3', function () {
    // Make sure key is configured
    ensureAPIKey();

    $response = GPT::generate('Output exactly, including the quotes in lower case: "hello world"\n\n');

    expect($response->first())->toBe('"hello world"');
});

it('can use stop words', function () {
    ensureAPIKey();

    $response = GPT::generate(
        'Output exactly, including the quotes in lower case: "hello world"\n\n',
        stop: 'world'
    );

    expect($response->first())->toBe('"hello ');
});

it('throws without API key', function () {
    ensureAPIKey(false);

    try {
        // Should fail due to missing key
        GPT::generate('test');
    } catch (Exception $e) {
        expect($e)->toBeInstanceOf(GPTException::class);
        expect($e->type)->toBe('no-api-key');
        expect($e->getMessage())->toBe('OpenAI API key not configured.');
    }
});
