<?php

/**
 * Apache OSL-2
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\Tideways\Plugin;

use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;
use Tideways\Profiler;

class TidewaysMonitoringExtensionPlugin implements MonitoringExtensionPluginInterface
{
    /**
     * @var string
     */
    protected $applicationName;

    /**
     * @var bool
     */
    protected $isActive;

    public function __construct()
    {
        $this->isActive = class_exists('Tideways\Profiler');
    }

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
        if (!$this->isActive) {
            return;
        }

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
        if (!$this->isActive) {
            return;
        }

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
        if (!$this->isActive) {
            return;
        }

        Profiler::setTransactionName($name);
    }

    /**
     * @return void
     */
    public function markStartTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        Profiler::start();
    }

    /**
     * @return void
     */
    public function markEndOfTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        Profiler::stop();
    }

    /**
     * @return void
     */
    public function markIgnoreTransaction(): void
    {
        if (!$this->isActive) {
            return;
        }

        Profiler::ignoreTransaction();
    }

    /**
     * @return void
     */
    public function markAsConsoleCommand(): void
    {
        if (!$this->isActive) {
            return;
        }

        $name = isset($this->applicationName) ? $this->applicationName . '-CLI' : 'CLI';
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
        if (!$this->isActive) {
            return;
        }

        Profiler::setCustomVariable($key, (string)$value);
    }

    /**
     * @param string $tracer
     *
     * @return void
     */
    public function addCustomTracer(string $tracer = 'classname::function_name'): void
    {
        if (!$this->isActive) {
            return;
        }

        Profiler::watch($tracer);
    }
}
