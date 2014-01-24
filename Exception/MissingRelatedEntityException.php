<?php

/**
 * 
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @license: GPL
 *
 */
namespace  Tms\Bundle\DocumentGeneratorBundle\Exception;

class MissingRelatedEntityException extends \Exception
{
    /**
     * The constructor.
     */
    public function __construct($entityClass, $formType)
    {
        $reflection = new \ReflectionClass($formType);

        parent::__construct(sprintf(
            'Set the %s to the entity before associated it with the form %s.', 
            $entityClass,
            $reflection->getName()
        ));
    }
}
