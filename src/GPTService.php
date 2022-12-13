<?php

namespace Capevace\GPT;

use Capevace\GPT\Serializable\{GPTOfferDescriptions};
use Capevace\GPT\Support\GPTException;
use Capevace\GPT\Support\GPTResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Orhanerday\OpenAi\OpenAi;

/**
 * The GPTService class is a service class that provides an interface for making requests to the GPT-3 API.
 */
class GPTService
{
    private ?OpenAi $openAi = null;

    private bool $shouldLog = false;

    public function __construct()
    {
        $apiKey = config('gpt.api_key');

        if ($apiKey !== null) {
            $this->openAi = new OpenAi($apiKey);
        }

        $this->shouldLog = env('OPENAI_LOG_RESPONSES', false);
    }

    protected function getOpenAI(): OpenAi
    {
        if ($this->openAi === null) {
            throw new GPTException('OpenAI API key not configured.', 'no-api-key');
        }

        return $this->openAi;
    }

    /**
     * Sends a request to the GPT3 API.
     *
     * @param  string  $prompt The prompt to send to the API.
     * @param  string  $model The model to use.
     * @param  float  $temperature
     * @param  int  $maxTokens
     * @param  ?string  $stop
     * @param  float  $frequencyPenalty
     * @param  float  $presencePenalty
     * @return GPTResponse
     *
     * @throws GPTException
     */
    public function generate(
        string $prompt,
        string $model = 'text-davinci-003',
        float $temperature = 0.83,
        int $maxTokens = 1200,
        ?string $stop = null,
        float $frequencyPenalty = 0.11,
        float $presencePenalty = 0.03,
    ): GPTResponse {
        $json = $this
            ->getOpenAI()
            ->completion([
                'model' => $model,
                'prompt' => $prompt,
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
                'stop' => $stop,
                'frequency_penalty' => $frequencyPenalty,
                'presence_penalty' => $presencePenalty,
            ]);

        $response = GPTResponse::fromJSON($json);

        if ($this->shouldLog) {
            Storage::disk('gpt')
                ->put(
                    'offer-'.Str::uuid().'.json',
                    json_encode(
                        [
                            'prompt' => $prompt,
                            'result' => $response->first(),
                        ]
                    )
                );
        }

        return $response;
    }

    /**
     * Sends a request to the GPT3 API and parses the generated text.
     *
     * The text we want is enclosed in a @template block and ends with @endtemplate.
     */
    public function generateOfferDescriptions(GPTOfferDescriptions $gpt)
    {
        $prompt = view('gpt.offer-description', ['data' => json_encode($gpt, JSON_PRETTY_PRINT)])
            ->render();

        $response = $this->generate(
            prompt: $prompt,
            stop: '@endtemplate',
        );

        $result = str($response->first())
            ->beforeLast('@endtemplate');

        return $result;
    }
}
