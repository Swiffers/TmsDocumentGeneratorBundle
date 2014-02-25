<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Entity events
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
final class ConfigurationTagEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_documentgenerator.configurationtag.pre_create';
    const POST_CREATE = 'tms_documentgenerator.configurationtag.post_create';

    const PRE_UPDATE =  'tms_documentgenerator.configurationtag.pre_update';
    const POST_UPDATE = 'tms_documentgenerator.configurationtag.post_update';

    const PRE_DELETE =  'tms_documentgenerator.configurationtag.pre_delete';
    const POST_DELETE = 'tms_documentgenerator.configurationtag.post_delete';
}
