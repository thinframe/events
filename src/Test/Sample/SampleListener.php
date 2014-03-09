<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\Test\Sample;

use ThinFrame\Events\Constant\Priority;
use ThinFrame\Events\ListenerInterface;
use ThinFrame\Events\SimpleEvent;

/**
 * SampleListener
 *
 * @package ThinFrame\Events\Tests\Samples
 * @since   0.2
 */
class SampleListener implements ListenerInterface
{
    public $triggered = false;

    /**
     * Get event mappings ["event"=>["method"=>"methodName","priority"=>1]]
     *
     * @return array
     */
    public function getEventMappings()
    {
        return [
            'test.listener' => [
                'method'   => 'onListenerTriggered',
                'priority' => Priority::MEDIUM
            ]
        ];
    }

    public function onListenerTriggered(SimpleEvent $event)
    {
        $this->triggered = true;
    }
}
