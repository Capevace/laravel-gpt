<?php

namespace Capevace\GPT\Support;

/**
 * `GPTResponse` is a PHP class that represents a response from the OpenAI GPT-3 language model.
 */
class GPTResponse
{
    /**
     * The first choice in the response.
     */
    protected string $first;

    /**
     * The constructor for the `GPTResponse` class. Takes an array of choices as an argument.
     * If the response contains any empty choices, it throws a `GPTException` with the message "OpenAI returned an empty choice" and the error type "empty-choice".
     * If the response contains no choices, it throws a `GPTException` with the message "OpenAI returned no choices" and the error type "no-choices".
     * If the response contains a choice without text, it throws a `GPTException` with the message "OpenAI returned a choice without text" and the error type "no-text".
     *
     * @param array $choices The array of choices in the response.
     *
     * @throws GPTException if the response contains any empty choices, no choices, or a choice without text.
     */
    public function __construct(
        protected array $choices
    ) {
        // Check if the response contains any empty choices.
        // OpenAI has returned empty responses in the past.
        if ($empty = collect($choices)->first(fn ($choice) => !property_exists($choice, 'text') || !filled($choice->text))) {
            throw new GPTException("OpenAI returned an empty choice", 'empty-choice');
        }

        if (count($choices) === 0) {
            throw new GPTException("OpenAI returned no choices", 'no-choices');
        }

        if (!property_exists($choices[0], 'text') || !filled($choices[0]->text)) {
            throw new GPTException("OpenAI returned a choice without text", 'no-text');
        }

        $this->first = $choices[0]->text;
    }

    /**
     * Returns the `$first` property of the `GPTResponse` instance.
     *
     * @return string The first choice in the response.
     */
    public function first(): string
    {
        return $this->first;
    }

    /**
     * Get all choices by GPT-3.
     *
     * @return string[] All choices in the response.
     */
    public function all(): array
    {
        return $this->choices;
    }

    /**
     * Takes a JSON string representing a GPT-3 response and returns a new `GPTResponse` instance.
     * If the JSON cannot be decoded, it throws a `GPTException` with the message "Unknown GPT-3 error" and the error type "unknown".
     * If the decoded JSON contains an error property, it throws a `GPTException` with the error message and error type specified in the JSON.
     *
     * @param string $json A JSON string representing a GPT-3 response.
     *
     * @return GPTResponse A new `GPTResponse` instance.
     *
     * @throws GPTException if the JSON cannot be decoded or if it contains an error property.
     */
    public static function fromJSON(string $json): GPTResponse
    {
        $data = json_decode($json);

        if ($data === null) {
            throw new GPTException("Unknown GPT-3 error", 'unknown');
        }

        if (property_exists($data, 'error')) {
            throw new GPTException($data->error->message, $data->error->type);
        }

        return new GPTResponse($data->choices);
    }
}
