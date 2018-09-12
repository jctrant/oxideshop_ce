<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 10.07.18
 * Time: 11:41
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Application\Events;


use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Application\ContainerBuilder;
use OxidEsales\EshopCommunity\Internal\Utility\ContextInterface;
use OxidEsales\EshopCommunity\Tests\Unit\Internal\ContextStub;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ShopAwareEventsTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @var Config $originalConfig
     */
    private $originalConfig;


    public function setUp()
    {
        $this->originalConfig = Registry::get(Config::class);
        Registry::set(Config::class, new TestConfig());

        $builder = new ContainerBuilder();
        $this->container = $builder->getContainer();
        $definition = $this->container->getDefinition(ContextInterface::class);
        $definition->setClass(ContextStub::class);

        $this->container->compile();

        $this->dispatcher = $this->container->get('event_dispatcher');

    }

    public function tearDown() {

        Registry::set(\OxidEsales\Eshop\Core\Config::class, $this->originalConfig);

    }

    /**
     * All three subscribers are active for shop 1, current shop is 1
     * but propagation is stopped after the second handler, so
     * we should have 2 active event handlers
     */
    public function testShopActivatedEvent() {

        /**
         * @var $event TestEvent
         */
        $event = $this->dispatcher->dispatch('oxidesales.testevent', new TestEvent());
        $this->assertEquals(2, $event->getNumberOfActiveHandlers());

    }

    /**
     * Only the second and third subscriber are active for shop 2, current shop is 2
     * but propagation is stopped after the second handler, so
     * we should have 1 active event handler
     */
    public function testShopNotActivatedEvent() {

        /**
         * @var ContextStub $contextStub
         */
        $contextStub = $this->container->get(ContextInterface::class);
        $contextStub->setCurrentShopId(2);
        /**
         * @var $event TestEvent
         */
        $event = $this->dispatcher->dispatch('oxidesales.testevent', new TestEvent());
        $this->assertEquals(1, $event->getNumberOfActiveHandlers());

    }
}
