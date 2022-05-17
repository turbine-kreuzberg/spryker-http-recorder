<?php

declare(strict_types = 1);

namespace TurbineKreuzberg\Shared\HttpRecorder;

class HttpRecorderConstants
{
    /**
     * @var string
     */
    public const MODE = 'HTTP-RECORDER:CONFIG:VCR_MODE';

    /**
     * @var string
     */
    public const MODE_RECORD = 'RECORD';

    /**
     * @var string
     */
    public const MODE_REPLAY = 'REPLAY';

    /**
     * @var array<string>
     */
    public const MODES = [
        self::MODE_RECORD,
        self::MODE_REPLAY,
    ];

    /**
     * @var string
     */
    public const VCR_CASSETTE_PATH = 'HTTP-RECORDER:CONFIG:VCR_CASSETTE_PATH';

    /**
     * @var string
     */
    public const VCR_LIBRARY_HOOKS = 'HTTP-RECORDER:CONFIG:VCR_LIBRARY_HOOKS';

    /**
     * @var string
     */
    public const VCR_REQUEST_MATCHERS = 'HTTP-RECORDER:CONFIG:VCR_REQUEST_MATCHERS';

    /**
     * @var string
     */
    public const VCR_STORAGE_TYPE = 'HTTP-RECORDER:CONFIG:VCR_STORAGE_TYPE';

    /**
     * @var string
     */
    public const VCR_ALLOW_LIST = 'HTTP-RECORDER:CONFIG:VCR_ALLOW_LIST';

    /**
     * @var string
     */
    public const VCR_DENY_LIST = 'HTTP-RECORDER:CONFIG:VCR_DENY_LIST';

    /**
     * @var string
     */
    public const REPLAY_REQUESTS_INCLUDED = 'HTTP-RECORDER:CONFIG:REPLAY_REQUESTS_INCLUDED';

    /**
     * @var string
     */
    public const REPLAY_REQUESTS_EXCLUDED = 'HTTP-RECORDER:CONFIG:REPLAY_REQUESTS_EXCLUDED';
}
