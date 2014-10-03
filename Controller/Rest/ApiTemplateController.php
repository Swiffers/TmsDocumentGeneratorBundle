<?php

/**
 *
 * @author:  Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Controller\Rest;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Util\Codes;
use JMS\Serializer\SerializationContext;
use Tms\Bundle\RestBundle\Formatter\AbstractHypermediaFormatter;

/**
 * Template REST Controller
 */
class ApiTemplateController extends FOSRestController
{
    /**
     * [GET] /templates
     * Retrieve a set of templates
     *
     * @QueryParam(name="customer_id", nullable=true, description="(optional) The customer identifiant")
     * @QueryParam(name="name", nullable=true, description="(optional) Name")
     * @QueryParam(name="tags", array=true, nullable=true, description="(optional) Tags.")
     * @QueryParam(name="limit", requirements="^\d+$", strict=true, nullable=true, description="(optional) Pagination limit")
     * @QueryParam(name="offset", requirements="^\d+$", strict=true, nullable=true, description="(optional) Pagination offset")
     * @QueryParam(name="page", requirements="^\d+$", strict=true, nullable=true, description="(optional) Page number")
     * @QueryParam(name="sort", array=true, nullable=true, description="(optional) Sort")
     *
     * @param string  $customer_id
     * @param string  $name
     * @param array   $tags
     * @param integer $limit
     * @param integer $offset
     * @param integer $page
     * @param array   $sort
     */
    public function getTemplatesAction(
        $customer_id = null,
        $name        = null,
        $tags        = array(),
        $limit       = null,
        $offset      = null,
        $page        = null,
        $sort        = null
    )
    {
        $view = $this->view(
            $this
                ->get('tms_rest.formatter.factory')
                ->create(
                    'orm_collection',
                    $this->getRequest()->get('_route'),
                    $this->getRequest()->getRequestFormat()
                )
                ->setObjectManager(
                    $this->get('doctrine.orm.entity_manager'),
                    $this
                        ->get('tms_document_generator.manager.template')
                        ->getEntityClass()
                )
                ->setCriteria(array(
                    'customerId' => $customer_id,
                    'name'       => $name,
                    'tags'       => $tags,
                ))
                ->setSort($sort)
                ->setLimit($limit)
                ->setOffset($offset)
                ->setPage($page)
                ->format()
            ,
            Codes::HTTP_OK
        );

        $serializationContext = SerializationContext::create()
            ->setGroups(array(
                AbstractHypermediaFormatter::SERIALIZER_CONTEXT_GROUP_COLLECTION
            ))
        ;
        $view->setSerializationContext($serializationContext);

        return $this->handleView($view);
    }

    /**
     * [GET] /templates/{id}
     * Retrieve a template
     *
     * @Route(requirements={"id" = "^\d+$"})
     *
     * @param integer $id
     */
    public function getTemplateAction($id)
    {
        try {
            $view = $this->view(
            $this
                ->get('tms_rest.formatter.factory')
                ->create(
                    'item',
                    $this->getRequest()->get('_route'),
                    $this->getRequest()->getRequestFormat(),
                    array('id' => $id)
                )
                ->setObjectManager(
                    $this->get('doctrine.orm.entity_manager'),
                    $this
                        ->get('tms_document_generator.manager.template')
                        ->getEntityClass()
                )
                ->format(),
                Codes::HTTP_OK
            );

            $serializationContext = SerializationContext::create()
                ->setGroups(array(
                    AbstractHypermediaFormatter::SERIALIZER_CONTEXT_GROUP_ITEM
                ))
            ;
            $view->setSerializationContext($serializationContext);

            return $this->handleView($view);

        } catch(NotFoundHttpException $e) {
            return $this->handleView($this->view(
                array(),
                $e->getStatusCode()
            ));
        }
    }
}
