<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Event;

/**
 * Description of MergeTagEvents
 *
 * @author Antoine Ribola <antoine.ribola@gmail.com>
 */
class MergeTagEvents
{
    /**
     * @var string
     */
    const PRE_CREATE =  'tms_document_generator.merge_tag.pre_create';
    const POST_CREATE = 'tms_document_generator.merge_tag.post_create';
    
    const PRE_UPDATE =  'tms_document_generator.merge_tag.pre_update';
    const POST_UPDATE = 'tms_document_generator.merge_tag.post_update';
    
    const PRE_DELETE =  'tms_document_generator.merge_tag.pre_delete';
    const POST_DELETE = 'tms_document_generator.merge_tag.post_delete';
}
