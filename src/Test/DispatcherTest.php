<?php

/**
 * src/Tests/DispatcherTest.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\Test;

use Monolog\Handler\NullHandler;
use Monolog\Logger;
use ThinFrame\Events\Constant\Priority;
use ThinFrame\Events\Dispatcher;
use ThinFrame\Events\SimpleEvent;
use ThinFrame\Events\Test\Sample\SampleListener;
use ThinFrame\Foundation\Exception\InvalidArgumentException;

/**
 * Class DispatcherTest
 *
 * @package ThinFrame\Events\Tests
 * @since   0.2
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

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
        $this->dispatcher = new Dispatcher();
        $this->dispatcher->setLogger($this->logger);
    }

    /**
     * Test dispatcher attachTo method arguments validation
     */
    public function testAttachToArgumentsValidation()
    {
        try {
            $this->dispatcher->attachTo([], 'var_dump');
            $this->assertFalse(true, 'Method should throw an invalid argument exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $e instanceof InvalidArgumentException,
                'Method should throw an invalid argument exception'
            );
        }

        try {
            $this->dispatcher->attachTo('some_event', 'invalid_callback');
            $this->assertFalse(true, 'Method should throw an invalid argument exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $e instanceof InvalidArgumentException,
                'Method should throw an invalid argument exception'
            );
        }

        try {
            $this->dispatcher->attachTo('some_event', 'var_dump', 12345);
            $this->assertFalse(true, 'Method should throw an invalid argument exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $e instanceof InvalidArgumentException,
                'Method should throw an invalid argument exception'
            );
        }

        try {
            $this->dispatcher->attachTo('some_event', 'var_dump', Priority::CRITICAL);
        } catch (\Exception $e) {
            $this->assertFalse(true, 'Method should\'t throw an exception');
        }
    }

    /**
     * Test a simple event
     */
    public function testSimpleEvents()
    {
        $triggered = false;

        $callback = function (SimpleEvent $event) use (&$triggered) {
            $triggered = true;
        };

        $this->dispatcher->attachTo('test.simple.events', $callback);

        $this->dispatcher->trigger(new SimpleEvent('test.simple.events'));

        $this->assertTrue($triggered, 'Callback should have been triggered');
    }

    /**
     * Test events priorities and propagation
     */
    public function testEventsPriorityAndPropagation()
    {
        $criticalTriggered = false;
        $mediumTriggered   = false;

        $criticalCallback = function (SimpleEvent $event) use (&$criticalTriggered) {
            $criticalTriggered = true;
            $event->stopPropagation();
        };

        $mediumCallback = function (SimpleEvent $event) use (&$mediumTriggered) {
            $mediumTriggered = true;
        };

        $this->dispatcher->attachTo('test.priority.propagation', $mediumCallback, Priority::MEDIUM);
        $this->dispatcher->attachTo('test.priority.propagation', $criticalCallback, Priority::CRITICAL);

        $this->dispatcher->trigger(new SimpleEvent('test.priority.propagation'));

        $this->assertTrue($criticalTriggered, 'Critical callback should have been triggered');

        $this->assertFalse($mediumTriggered, 'Medium callback shouldn\'t have been triggered');
    }

    /**
     * Test event bindings
     */
    public function testEventBindings()
    {
        $triggered = false;

        $callback = function (SimpleEvent $event) use (&$triggered) {
            $triggered = true;
        };

        $this->dispatcher->attachTo('test.event.bindings', $callback);

        $binding = $this->dispatcher->bindTo('test.event.bindings');

        $binding();

        $this->assertTrue($triggered, 'Binding should have triggered event');
    }

    /**
     * Test Listener
     */
    public function testListener()
    {
        $listener = new SampleListener();

        $this->dispatcher->attachListener($listener);

        $this->dispatcher->trigger(new SimpleEvent('test.listener'));

        $this->assertTrue($listener->triggered, 'Listener should have been triggered');
    }
}
