<?php

declare(strict_types = 1);

namespace TurbineKreuzberg\Service\HttpRecorder;

use Exception;
use RuntimeException;
use VCR\VCR;

class HttpRecorderService
{
    protected static HttpRecorderServiceConfig $config;
    protected static bool $isEnabled = false;

    public static function initialize(): void
    {
        static::$config = new HttpRecorderServiceConfig();

        if (static::getConfig()->isEnabled()) {
            VCR::turnOn();
            static::$isEnabled = true;
            static::configure();
        }
    }

    public static function configure(): void
    {
        if (!static::$isEnabled) {
            return;
        }

        VCR::configure()
            ->setCassettePath(static::getConfig()->getVcrCassettePath())
            ->setStorage(static::getConfig()->getVcrStorage())
            ->setWhiteList(static::getConfig()->getVcrAllowList())
            ->setBlackList(static::getConfig()->getVcrDenyList())
            ->enableLibraryHooks(static::getConfig()->getVcrLibraryHooks());

        if (static::getConfig()->isReplayModeEnabled()) {
            static::enableConfiguredRequestMatchers();
        }
    }

    public static function isEnabled(): bool
    {
        return static::getConfig()->isEnabled();
    }

    public static function enableConfiguredRequestMatchers(): void
    {
        VCR::configure()->enableRequestMatchers(
            static::getConfig()->getVcrRequestMatchers(),
        );
    }

    public static function disableAllRequestMatchers(): void
    {
        VCR::configure()->enableRequestMatchers([]);
    }

    public function __construct()
    {
        static::configure();
    }

    public function setRecordingFile(string $fileName): void
    {
        $fileNameWithExtension = sprintf(
            '%s.%s',
            $fileName,
            static::getConfig()->getVcrStorage(),
        );

        VCR::insertCassette($fileNameWithExtension);
    }

    /**
     * @throws Exception
     */
    public function setRequestMatchingForRequest(string $request): void
    {
        if ($request
            && $this->shouldRequestBeIncludedInMatching($request) === true
            && $this->shouldRequestBeExcludedFromMatching($request) === false
        ) {
            static::enableConfiguredRequestMatchers();

            return;
        }

        static::disableAllRequestMatchers();

        $newTemporaryRecordingFile = tempnam(static::getConfig()->getVcrCassettePath(), 'php-vcr');

        if (!$newTemporaryRecordingFile) {
            throw new RuntimeException(
                'Unable to create temp file in ' . static::getConfig()->getVcrCassettePath()
            );
        }

        $this->setRecordingFile(
            $newTemporaryRecordingFile
        );
    }

    public function stopRecording(): void
    {
        VCR::turnOff();
        static::$isEnabled = false;
    }

    protected function shouldRequestBeIncludedInMatching(string $request): bool
    {
        return count(static::getConfig()->getIncludedReplayRequests()) === 0
            || in_array($request, static::getConfig()->getIncludedReplayRequests(), true);
    }

    protected function shouldRequestBeExcludedFromMatching(string $request): bool
    {
        return in_array($request, static::getConfig()->getExcludedReplayRequests(), true);
    }

    protected static function getConfig(): HttpRecorderServiceConfig
    {
        if (empty(static::$config)) {
            static::initialize();
        }

        return static::$config;
    }
}
