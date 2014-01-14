<?php

/**
 * /src/ThinFrame/Events/EventsApplication.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events;

use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\AwareInterfaceDefinition;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\Events\DependencyInjection\EventsCompilerPass;

/**
 * Class EventsApplication
 *
 * @package ThinFrame\Events
 * @since   0.2
 */
class EventsApplication extends AbstractApplication
{
    /**
     * initialize configurator
     *
     * @param ContainerConfigurator $configurator
     *
     * @return mixed
     */
    public function initializeConfigurator(ContainerConfigurator $configurator)
    {
        $configurator->addAwareInterfaceDefinition(
            new AwareInterfaceDefinition(
                '\ThinFrame\Events\DispatcherAwareInterface',
                'setDispatcher',
                'thinframe.events.dispatcher'
            )
        );
        $configurator->addCompilerPass(new EventsCompilerPass());
    }

    /**
     * Get application name
     *
     * @return string
     */
    public function getApplicationName()
    {
        return 'ThinFrameEvents';
    }

    /**
     * Get configuration files
     *
     * @return mixed
     */
    public function getConfigurationFiles()
    {
        return [
            'resources/services.yml'
        ];
    }

    /**
     * Get parent applications
     *
     * @return AbstractApplication[]
     */
    protected function getParentApplications()
    {
        return [];
    }
}