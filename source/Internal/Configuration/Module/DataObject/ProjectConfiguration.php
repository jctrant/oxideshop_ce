<?php
declare(strict_types=1);

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Configuration\Module\DataObject;

/**
 * @internal
 */
class ProjectConfiguration
{
    /**
     * @return array
     */
    public function getEnvironmentNames(): array
    {
        return [
            'dev',
            'testing',
            'staging',
            'production'
        ];
    }

    /**
     * @param string $name
     *
     * @return EnvironmentConfiguration
     */
    public function getEnvironmentConfiguration(string $name): EnvironmentConfiguration
    {
        return new EnvironmentConfiguration();
    }
}
