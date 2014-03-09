<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\Test;

use ThinFrame\Events\Dispatcher;
use ThinFrame\Events\EventsApplication;

/**
 * ApplicationTest
 *
 * @package ThinFrame\Events\Tests
 * @since   0.2
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test dispatcher presence
     */
    public function testDispatcher()
    {
        $application = new EventsApplication();

        $application->make();

        $this->assertEquals(
            $application->getName(),
            'EventsApplication',
            'Application name should be correct'
        );

        $this->assertTrue(
            $application->getContainer()->get('events.dispatcher') instanceof Dispatcher,
            'Application should return the correct service'
        );
    }
}
