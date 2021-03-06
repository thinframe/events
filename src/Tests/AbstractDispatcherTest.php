<?php

/**
 * /src/ThinFrame/Events/Tests/AbstractDispatcherTest.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\Tests;

use Monolog\Handler\NullHandler;
use Monolog\Logger;
use ThinFrame\Events\SimpleEvent;
use ThinFrame\Events\Tests\Samples\SampleDispatcher;
use ThinFrame\Foundation\Exceptions\InvalidArgumentException;

/**
 * Class AbstractDispatcherTest
 *
 * @package ThinFrame\Events\Tests
 * @since   0.2
 */
class AbstractDispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->logger = new Logger('thinframe.events');
        $this->logger->pushHandler(new NullHandler());
    }


    /**
     * Test hooking
     */
    public function testHooking()
    {
        $dispatcher = new SampleDispatcher();

        $dispatcher->setLogger($this->logger);

        $triggered = false;

        $dispatcher->onSomeEvent(
            function (SimpleEvent $e) use (&$triggered) {
                $triggered = true;
            }
        );

        $dispatcher->trigger(new SimpleEvent('someEvent'));

        $this->assertTrue($triggered, 'Callback should have been triggered');
    }

    /**
     * Test bad method call
     */
    public function testBadMethodCall()
    {
        $dispatcher = new SampleDispatcher();

        $dispatcher->setLogger($this->logger);

        try {
            $dispatcher->osomeevent('var_dump');
            $this->assertFalse(true, 'AbstractDispatcher should throw an exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $e instanceof \BadMethodCallException,
                'AbstractDispatcher should throw the right type of exception'
            );
        }
    }

    /**
     * Test callback validator
     */
    public function testCallbackValidator()
    {
        $dispatcher = new SampleDispatcher();

        $dispatcher->setLogger($this->logger);

        try {
            $dispatcher->onsomeevent('some_invalid_callback');
            $this->assertFalse(true, 'AbstractDispatcher should throw an exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $e instanceof InvalidArgumentException,
                'AbstractDispatcher should throw the right type of exception'
            );
        }
    }
}
