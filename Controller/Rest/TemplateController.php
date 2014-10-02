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
use Tms\Bundle\RestBundle\Formatter\AbstractHypermediaFormatter;

/**
 * Template REST Controller
 */
class TemplateController extends FOSRestController
{
    /**
     * [GET] /templates
     * Retrieve a set of templates
     *
     * @QueryParam(name="name", nullable=true, description="(optional) Name")
     * @QueryParam(name="tags", array=true, nullable=true, description="(optional) Tags.")
     * @QueryParam(name="limit", requirements="^\d+$", strict=true, nullable=true, description="(optional) Pagination limit")
     * @QueryParam(name="offset", requirements="^\d+$", strict=true, nullable=true, description="(optional) Pagination offset")
     * @QueryParam(name="page", requirements="^\d+$", strict=true, nullable=true, description="(optional) Page number")
     * @QueryParam(name="sort", array=true, nullable=true, description="(optional) Sort")
     *
     * @param string  $name
     * @param array   $tags
     * @param integer $limit
     * @param integer $offset
     * @param integer $page
     * @param array   $sort
     */
    public function getTemplatesAction(
        $name   = null,
        $tags   = array(),
        $limit  = null,
        $offset = null,
        $page   = null,
        $sort   = null
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
                    'name'  => $name,
                    'tags'  => $tags,
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
     * @param string $id
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
