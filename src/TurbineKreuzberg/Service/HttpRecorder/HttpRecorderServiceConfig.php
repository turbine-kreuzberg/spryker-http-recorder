<?php

declare(strict_types = 1);

namespace TurbineKreuzberg\Service\HttpRecorder;

use TurbineKreuzberg\Shared\HttpRecorder\HttpRecorderConstants;
use Spryker\Service\Kernel\AbstractBundleConfig;

class HttpRecorderServiceConfig extends AbstractBundleConfig
{
    public function isEnabled(): bool
    {
        return in_array(
            $this->get(HttpRecorderConstants::MODE, false),
            HttpRecorderConstants::MODES,
            true,
        );
    }

    public function isReplayModeEnabled(): bool
    {
        return $this->get(HttpRecorderConstants::MODE, false) === HttpRecorderConstants::MODE_REPLAY;
    }

    /**
     * @return array<string>
     */
    public function getVcrRequestMatchers(): array
    {
        return $this->get(
            HttpRecorderConstants::VCR_REQUEST_MATCHERS,
            [
                'method',
                'url',
                'host',
            ],
        );
    }

    /**
     * @return array<string>
     */
    public function getIncludedReplayRequests(): array
    {
        return $this->get(
            HttpRecorderConstants::REPLAY_REQUESTS_INCLUDED,
            [],
        );
    }

    /**
     * @return array<string>
     */
    public function getExcludedReplayRequests(): array
    {
        return $this->get(
            HttpRecorderConstants::REPLAY_REQUESTS_EXCLUDED,
            [],
        );
    }

    public function getVcrCassettePath(): string
    {
        return $this->get(
            HttpRecorderConstants::VCR_CASSETTE_PATH,
            '/tmp',
        );
    }

    /**
     * @return array<string>
     */
    public function getVcrLibraryHooks(): array
    {
        return $this->get(
            HttpRecorderConstants::VCR_LIBRARY_HOOKS,
            [],
        );
    }

    public function getVcrStorage(): string
    {
        return $this->get(
            HttpRecorderConstants::VCR_STORAGE_TYPE,
            'json',
        );
    }

    /**
     * @return array<string>
     */
    public function getVcrAllowList(): array
    {
        return $this->get(
            HttpRecorderConstants::VCR_ALLOW_LIST,
            [
                'vendor/guzzle',
            ],
        );
    }

    /**
     * @return array<string>
     */
    public function getVcrDenyList(): array
    {
        return $this->get(
            HttpRecorderConstants::VCR_DENY_LIST,
            [],
        );
    }
}
