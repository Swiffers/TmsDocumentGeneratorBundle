<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Description of TemplateEvents
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class TemplateEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_document_generator.template.pre_create';
    const POST_CREATE = 'tms_document_generator.template.post_create';

    const PRE_UPDATE =  'tms_document_generator.template.pre_update';
    const POST_UPDATE = 'tms_document_generator.template.post_update';

    const PRE_DELETE =  'tms_document_generator.template.pre_delete';
    const POST_DELETE = 'tms_document_generator.template.post_delete';
}
