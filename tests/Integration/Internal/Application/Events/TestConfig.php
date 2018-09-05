<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:58
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use OxidEsales\Eshop\Core\Config;

class TestConfig extends Config
{
    public function getConfigParam($key, $default=null)
    {
        if ($key == 'sShopDir') {
            return __DIR__;
        }

        if ($key == 'sCompileDir') {
            return __DIR__;
        }

        throw new \Exception('Unknown key ' . $key);
    }

}