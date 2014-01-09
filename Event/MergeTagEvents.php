<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Entity events
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
final class MergeTagEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_documentgenerator.mergetag.pre_create';
    const POST_CREATE = 'tms_documentgenerator.mergetag.post_create';

    const PRE_UPDATE =  'tms_documentgenerator.mergetag.pre_update';
    const POST_UPDATE = 'tms_documentgenerator.mergetag.post_update';

    const PRE_DELETE =  'tms_documentgenerator.mergetag.pre_delete';
    const POST_DELETE = 'tms_documentgenerator.mergetag.post_delete';
}
