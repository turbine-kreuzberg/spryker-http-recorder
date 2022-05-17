<?php

namespace TurbineKreuzbergTest\Service\HttpRecorder;

use PHPUnit\Framework\TestCase;
use TurbineKreuzberg\Service\HttpRecorder\HttpRecorderService;

class HttpRecorderServiceTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testIsEnabledShouldNotThrowException(): void
    {
        define('Spryker\\Shared\\Config\\APPLICATION_ENV', 'local_test');
        define('Spryker\\Shared\\Config\\APPLICATION_STORE', 'DE');
        define('Spryker\\Shared\\Config\\APPLICATION_ROOT_DIR', '/tmp');

        $isEnabled = HttpRecorderService::isEnabled();

        $this->assertFalse($isEnabled);
    }

    /**
     * @runInSeparateProcess
     */
    public function testIsEnabledShouldReturnTrue(): void
    {
        define('Spryker\\Shared\\Config\\APPLICATION_ENV', 'local_test');
        define('Spryker\\Shared\\Config\\APPLICATION_STORE', 'DE');
        define('Spryker\\Shared\\Config\\APPLICATION_ROOT_DIR', './tests/_data/');

        $isEnabled = HttpRecorderService::isEnabled();

        $this->assertTrue($isEnabled);
    }
}
