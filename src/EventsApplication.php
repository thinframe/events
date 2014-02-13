<?php

/**
 * /src/EventsApplication.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events;

use PhpCollection\Map;
use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\Applications\DependencyInjection\InterfaceInjectionRule;
use ThinFrame\Applications\DependencyInjection\TraitInjectionRule;
use ThinFrame\Events\DependencyInjection\EventsCompilerPass;
use ThinFrame\Events\DependencyInjection\EventsHybridExtension;
use ThinFrame\Monolog\MonologApplication;

/**
 * Class EventsApplication
 *
 * @package ThinFrame\Events
 * @since   0.2
 */
class EventsApplication extends AbstractApplication
{
    /**
     * Get application name
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflector->getShortName();
    }

    /**
     * Get application parents
     *
     * @return AbstractApplication[]
     */
    public function getParents()
    {
        //noop
        //TODO: implement monolog application
    }

    /**
     * Set different options for the container configurator
     *
     * @param ContainerConfigurator $configurator
     */
    protected function setConfiguration(ContainerConfigurator $configurator)
    {
        $configurator
            ->addResource('Resources/services/services.yml')
            ->addResource('Resources/services/config.yml')
            ->addInjectionRule(
                new TraitInjectionRule('\ThinFrame\Events\DispatcherAwareTrait', 'events.dispatcher', 'setDispatcher')
            )
            ->addInjectionRule(
                new InterfaceInjectionRule(
                    '\ThinFrame\Events\DispatcherAwareInterface',
                    'events.dispatcher',
                    'setDispatcher'
                )
            )
            ->addExtension($hybridExtension = new EventsHybridExtension())
            ->addCompilerPass($hybridExtension);
    }

    /**
     * Set application metadata
     *
     * @param Map $metadata
     *
     */
    protected function setMetadata(Map $metadata)
    {
        // TODO: Implement setMetadata() method.
    }

}
