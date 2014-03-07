<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Tms\Bundle\DocumentGeneratorBundle\Entity\ConfigurationTag;

/**
 * Entity event
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
class ConfigurationTagEvent extends Event
{
    protected $configurationTag;

    /**
     * Constructor
     *
     * @param ConfigurationTag $mergeTag
     */
    public function __construct(ConfigurationTag $configurationTag)
    {
        $this->configurationTag = $configurationTag;
    }

    /**
     * Get Object
     *
     * @return ConfigurationTag
     */
    public function getConfigurationTag()
    {
        return $this->configurationTag;
    }
}
