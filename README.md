<div align="center">
	<a href="https://github.com/capevace/laravel-gpt">
		<img src="https://user-images.githubusercontent.com/10093858/207289815-1656ca5a-9473-4c32-a099-35f20ff0f60c.png" width="200">
	</a>
	<h1>laravel-gpt</h1>
	<p>
		This package provides a <strong>type-safe</strong> interface for making requests to the <a href="https://beta.openai.com/docs/api-reference/introduction">GPT-3 API</a>.
	</p>
	<p>
		<a href="https://packagist.org/packages/capevace/laravel-gpt">
            <img src="https://img.shields.io/packagist/v/capevace/laravel-gpt.svg?style=flat-square" alt="Latest Version on Packagist" />
        </a>
        <a href="https://github.com/capevace/laravel-gpt/actions?query=workflow%3Arun-tests+branch%3Amain">
            <img src="https://img.shields.io/github/workflow/status/capevace/laravel-gpt/run-tests?label=tests" alt="GitHub Tests Action Status" />
        </a>
        <a href="https://packagist.org/packages/capevace/laravel-gpt">
            <img src="https://img.shields.io/packagist/dt/capevace/laravel-gpt.svg?style=flat-square" alt="Total Downloads" />
        </a>
	</p>
</div>

```php
use Capevace\GPT\Facades\GPT;

$response = GPT::generate(
    'Name a thing that is blue.',
    model: 'text-davinci-003',
    maxTokens: 400,
    frequencyPenalty: 1.0,
);

echo $response->first(); // "The sky"
```

<br />

## Installation

You can install the package via composer:

```bash
composer require capevace/laravel-gpt
```

<br />

## Configuration

You will need an API key for the OpenAI GPT-3 API. Once you have obtained an API key, you can configure it in your .env file by adding the following line:

```bash
OPENAI_API_KEY=your-api-key-here
```

You could also publish the config file directly, **but this really probably isn't necessary**:

```bash
php artisan vendor:publish --tag="laravel-gpt-config"
```

<br />

## Usage

The `Capevace\GPT\GPTService` class provides methods for making requests to the GPT-3 API. You can inject it into controllers or use the Facade to access the container.

```php
# Access via injection

use Capevace\GPT\GPTService;

class MyController extends Controller {
    protected GPTService $gpt;

    public function __construct(GPTService $gpt) {
        $this->gpt = $gpt;
    }

    public function index() {
        $this->gpt->generate(
            // ..
        );
    }

}

# Access via Facade

use Capevace\GPT\Facades\GPT;

GPT::generate(/* .. */);
```

<br />

### GPT::generate(_\<prompt\>_, _[...options]_)

The `generate` method returns a `GPTResponse` object that contains the response from the GPT-3 API. If no text is returned (empty string), the method will throw an error.

`generate` takes the following arguments:

-   `prompt` (required): the prompt to send to the GPT-3 API
-   `model`: the GPT-3 model to use (defaults to text-davinci-003)
-   `temperature`: a value between 0 and 1 that determines how "creative" the response will be (defaults to 0.83)
-   `maxTokens`: the maximum number of tokens (i.e., words) to return in the response (defaults to 1200)
-   `stop`: a string that, when encountered in the response, will cause the response to end (defaults to null)
-   `frequencyPenalty`: a value between 0 and 1 that determines how much the model will penalize frequent words (defaults to 0.11)
-   `presencePenalty`: a value between 0 and 1 that determines how much the model will penalize words that don't appear in the prompt (defaults to 0.03)

#### Example

```php
use Capevace\GPT\Facades\GPT;

$response = GPT::generate(
    'Generate a list of things that are blue.',
    model: 'text-davinci-003',
    maxTokens: 400,
    frequencyPenalty: 1.0,
);
```

<br />

### Handling responses

The `generate` method returns a `GPTResponse` object that contains the response from the GPT-3 API.

It has two methods:

-   `$response->first()` (_string_): returns the first text suggested by GPT-3
-   `$response->all()` (_array_): returns a list of all the text choices suggested by GPT-3

#### Example

```php
use Capevace\GPT\Facades\GPT;

$response = GPT::generate(
    'Name a thing that is blue.',
    model: 'text-davinci-003',
    maxTokens: 400,
    frequencyPenalty: 1.0,
);

$firstChoice = $response->first(); // "the sky"

$allChoices = $response->all(); // ["the sky", "the ocean" ...]
```

<br />

### Error handling

If an error occurs while making a request to the GPT-3 API, the `generate()` method will throw a `Capevace\GPT\Support\GPTException` exception.

`laravel-gpt` will also throw an error, if a response does not contain any text (empty string).

#### Example

```php
use Capevace\GPT\Facades\GPT;
use Capevace\GPT\Support\GPTException;
use Exception;

try {
    $response = GPT::generate('Do nothing.');
} catch (GPTException $e) {
    // Exception will be thrown, as the response text is ""
} catch (Exception $e) {
    // Catch connectivity errors etc.
}
```

<br />

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
