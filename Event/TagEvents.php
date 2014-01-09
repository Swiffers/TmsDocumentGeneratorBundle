<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Entity events
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
final class TagEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_documentgenerator.tag.pre_create';
    const POST_CREATE = 'tms_documentgenerator.tag.post_create';

    const PRE_UPDATE =  'tms_documentgenerator.tag.pre_update';
    const POST_UPDATE = 'tms_documentgenerator.tag.post_update';

    const PRE_DELETE =  'tms_documentgenerator.tag.pre_delete';
    const POST_DELETE = 'tms_documentgenerator.tag.post_delete';
}
