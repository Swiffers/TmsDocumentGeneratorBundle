<?php

/**
 *
 * @author:  Jean-Philippe CHATEAU <jp.chateau@trepia.fr>
 * @license: MIT
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ConfigurationTagRepository
 */
class ConfigurationTagRepository extends EntityRepository
{
    /**
     * Count
     */
    public function count()
    {
        $count = $this->createQueryBuilder('configuration_tag')
            ->select('COUNT(configuration_tag)')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return intval($count);
    }
}
