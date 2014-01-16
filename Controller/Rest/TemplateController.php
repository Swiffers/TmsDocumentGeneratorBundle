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
     * @QueryParam(name="limit", requirements="\d+", default=20, strict=true, nullable=true, description="(optional) Pagination limit")
     * @QueryParam(name="offset", requirements="\d+", strict=true, nullable=true, description="(optional) Pagination offet")
     *
     * @param string $name
     * @param string $limit
     * @param string $offset
     */
    public function getTemplatesAction(
        $name               = null,
        $limit              = null,
        $offset             = null
    )
    {
        $criteria = $this->get('tms_rest.criteria_builder')->clean(array(
            'name' => $name,
        ));

        $entities = $this->get('tms_document_generator.manager.template')->findBy($criteria, null, $limit, $offset);
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
}
