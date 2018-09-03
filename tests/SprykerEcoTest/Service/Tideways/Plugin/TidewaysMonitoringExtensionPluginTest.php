<?php

/**
 * Apache OSL-2
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Service\Tideways\Plugin;

use Codeception\Test\Unit;
use Spryker\Service\MonitoringExtension\Dependency\Plugin\MonitoringExtensionPluginInterface;
use SprykerEco\Service\Tideways\Plugin\TidewaysMonitoringExtensionPlugin;

class TidewaysMonitoringExtensionPluginTest extends Unit
{
    /**
     * @return void
     */
    public function testExtensionPluginCanBeInstantiated(): void
    {
        $this->assertInstanceOf(MonitoringExtensionPluginInterface::class, new TidewaysMonitoringExtensionPlugin());
    }
}
