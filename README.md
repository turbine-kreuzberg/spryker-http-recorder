# Spryker Http Recorder

This package provides an integration for [php-vcr](https://php-vcr.github.io/) in Spryker.  
It is a wrapper around [php-vcr/php-vcr](https://github.com/php-vcr/php-vcr).  

* [Installation](#installation)
* [Usage](#usage)
    + [Examples](#examples)
        - [Glue integration](#glue-integration)
        - [Integration in HTTP request method](#integration-in-http-request-method)
* [Configuration](#configuration)
* [Credits](#credits)
* [License](#license)

## Installation

- Install the package via composer (usually as a dev dependency with the flag `--dev`)
```
composer require [--dev] turbine-kreuzberg/spryker-http-recorder
```

## Usage

You need to `HttpRecorderService::initialize();` as early as possible after class autoloading
in your callstack (usually in an `index.php`), because php-vcr intercepts with all HTTP requests.  

### Examples 

#### Glue integration

Add `HttpRecorderService::initialize();` in `public/Glue/index.php` right after `Environment::initialize();` 
```php
...
require_once APPLICATION_ROOT_DIR . '/vendor/autoload.php';

Environment::initialize();

HttpRecorderService::initialize();
...
```

#### Integration in HTTP request method 

In your class that makes HTTP requests you want to record, you need to set a file 
to use for recording (and replay).
```php
    public function makeHttpRequest(...)
    {
        // just define the basic filename, the file extension will be added
        // based on the configured storage type ('.yaml', '.json')
        $this->httpRecorderService->setRecordingFile('your-recording-file');

        try {
            $this->client->call(...);
        } finally {
            // stop recording (=turn off VCR client) after the request,
            // no matter if it succeeds or fails
            register_shutdown_function(function () {
                $this->httpRecorderService->stopRecording();
            });
        }
    }
```

## Configuration

For an easy start, copy the following snippet to your `config_local.php` 

```php
use TurbineKreuzberg\Shared\HttpRecorder\HttpRecorderConstants;

/**
 * MODES: 
 * To enable the usage of http recorder, set the mode.
 * - To just record requests and responses, use mode HttpRecorderConstants::MODE_RECORD
     $config[HttpRecorderConstants::MODE] = HttpRecorderConstants::MODE_RECORD;
 * - To just replay recorded requests and responses, use mode HttpRecorderConstants::MODE_REPLAY
 *   If no recording exists, the first request (and response) will be recorded
     $config[HttpRecorderConstants::MODE] = HttpRecorderConstants::MODE_REPLAY;
 * 
 * LIBRARY HOOKS:
 * By default all library hooks are enabled.
 * But you can also specifically enable only some hooks, e.g. 'soap':
   $config[HttpRecorderConstants::VCR_LIBRARY_HOOKS] = [
     'soap',
   ];
 * For more details, see https://php-vcr.github.io/documentation/configuration/#library-hooks
 *
 * RECORDING PATH:
 * By default, recordings are stored and read from /tmp
 * To use recordings from a different folder, set HttpRecorderConstants::VCR_CASSETTE_PATH to that path.
   $config[HttpRecorderConstants::VCR_CASSETTE_PATH] = APPLICATION_ROOT_DIR . '/your/custom/path/for/vcr/recordings';
 *
 * STORAGE TYPE: 
 * By default, recordings are stored in JSON format ('json'). 
 * To use yaml format, set storage type to 'yaml':  
   $config[HttpRecorderConstants::VCR_STORAGE_TYPE] = 'yaml';
 * For more details, see https://php-vcr.github.io/documentation/configuration/#storage   
 *
 * REQUEST MATCHERS:
 * Requests are matched by different criteria. By default, these request matchers are used:
   $config[HttpRecorderConstants::VCR_REQUEST_MATCHERS] =             [
     'method',
     'url',
     'host',
   ];
 * You can create your own request matchers and use them as callbacks
 * For more details, see https://php-vcr.github.io/documentation/configuration/#request-matching
 * 
 * ALLOW/DENY LISTS FOR PATHS TO INTERCEPT:
 * By default, there is an allow list with 'vendor/guzzle':  
   $config[HttpRecorderConstants::VCR_ALLOW_LIST] = [
     'vendor/guzzle',
   ];
 * The deny list is empty by default:  
   $config[HttpRecorderConstants::VCR_DENY_LIST] = [];
 * For more details, see https://php-vcr.github.io/documentation/configuration/#white--and-blacklisting-paths
*/
```

## Credits

- [All Contributors](../../graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
