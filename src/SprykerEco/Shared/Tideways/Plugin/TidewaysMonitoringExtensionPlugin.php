<?php
/**
 * Copyright © 2018-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Tideways\Plugin;

use Spryker\Shared\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;
use Tideways\Profiler;

class TidewaysMonitoringExtensionPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @var string
     */
    protected $applicationName;

    /**
     * Report an error at this line of code, with a complete stack trace.
     *
     * @param string $message
     * @param \Exception|\Throwable $exception
     *
     * @return void
     */
    public function setError(string $message, $exception): void
    {
        if ($exception) {
            Profiler::logException($exception);
        }
    }

    /**
     * @param null|string $application
     * @param null|string $store
     * @param null|string $environment
     *
     * @return void
     */
    public function setApplicationName(?string $application = null, ?string $store = null, ?string $environment = null): void
    {
        $name = $application . '-' . $store;

        Profiler::setServiceName($name);
        $this->addCustomParameter('env', $environment);
        $this->applicationName = $name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setTransactionName(string $name): void
    {
        Profiler::setTransactionName($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        Profiler::start();
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        Profiler::stop();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        Profiler::ignoreTransaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
        $name = isset($this->applicationName) ? $this->applicationName . '-CLI' : 'CLI';
//            file_put_contents(APPLICATION_ROOT_DIR . '/tmmp.log', $name, FILE_APPEND); // TODO
        Profiler::setServiceName($name);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addCustomParameter(string $key, $value): void
    {
        Profiler::setCustomVariable($key, (string)$value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer = 'classname::function_name'): void
    {
        Profiler::watch($tracer);
    }
}
