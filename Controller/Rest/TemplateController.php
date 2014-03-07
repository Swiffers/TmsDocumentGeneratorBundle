<?php

/**
 *
 * @author:  Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Rest;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

/**
 * Template REST Controller
 */
class TemplateController extends FOSRestController
{
    /**
     * [GET] /templates
     * Retrieve a set of templates
     *
     * @QueryParam(name="name", nullable=true, description="(optional) Template name")
     * @QueryParam(name="tags", array=true, nullable=true, requirements="\w+", description="List of tags")
     * @QueryParam(name="limit", requirements="\d+", strict=true, nullable=true, description="(optional) Pagination limit")
     * @QueryParam(name="offset", requirements="\d+", strict=true, nullable=true, description="(optional) Pagination offset")
     *
     * @param string $name
     * @param array  $tags
     * @param string $limit
     * @param string $offset
     */
    public function getTemplatesAction(
        $name    = null,
        $tags    = array(),
        $limit   = null,
        $offset  = null
    )
    {
        $criteria = $this->get('tms_rest.criteria_builder')->clean(
            array(
                'name'  => $name,
                'tags'  => $tags,
                'limit' => $limit,
            ),
            $this->get('request')->get('_route')
        );
        $entities = $this->get('tms_document_generator.manager.template')->findByNameAndTagNames(
            isset($criteria['name']) ? $criteria['name'] : null,
            isset($criteria['tags']) ? $criteria['tags'] : array(),
            $criteria['limit'],
            $offset
        );

        $context = SerializationContext::create()->setGroups(array('list'));
        $view = $this->view($entities, Codes::HTTP_OK);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * [GET] /templates/{id}
     * Retrieve a template
     *
     * @param string $id
     */
    public function getTemplateAction($id)
    {
        $entity = $this->get('tms_document_generator.manager.template')->findOneById($id);
        if (!$entity) {
            $view = $this->view(array(), Codes::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $context = SerializationContext::create()->setGroups(array('details'));
        $view = $this->view(
            array('class' => get_class($entity),
                  'data'  => $entity,
            ),
            Codes::HTTP_OK
        );
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }

    /**
     * [GET] /templates/{id}/mergetags
     * Retrieve the merge tags of a template
     *
     * @param string $id
     * @param Request $request
     */
    public function getTemplateMergetagsAction($id, Request $request)
    {
        $entity = $this->get('tms_document_generator.manager.template')->findOneById($id);
        if (!$entity) {
            $view = $this->view(array(), Codes::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $data = $this->get('tms_rest.entity_handler')->getSubResource($entity, 'merge_tags');
        $context = SerializationContext::create()->setGroups(array('list'));
        $view = $this->view($data, Codes::HTTP_OK);
        $view->setSerializationContext($context);

        return $this->handleView($view);
    }
}
