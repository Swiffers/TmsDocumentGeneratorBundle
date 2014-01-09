<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Entity events
 *
 * @author Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 */
final class TemplateEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_documentgenerator.template.pre_create';
    const POST_CREATE = 'tms_documentgenerator.template.post_create';

    const PRE_UPDATE =  'tms_documentgenerator.template.pre_update';
    const POST_UPDATE = 'tms_documentgenerator.template.post_update';

    const PRE_DELETE =  'tms_documentgenerator.template.pre_delete';
    const POST_DELETE = 'tms_documentgenerator.template.post_delete';
}
