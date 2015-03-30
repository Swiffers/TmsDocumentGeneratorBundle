<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Options;
use Tms\Bundle\DocumentGeneratorBundle\Handler\JsonHandler;

/**
 * Class DefaultDataFetcher
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFetcher
 */
class DefaultDataFetcher extends AbstractDataFetcher
{
    /**
     * {@inheritDoc}
     */
    public function doFetch(array $parameters)
    {
        $rawfetchedData = $parameters;

        return JsonHandler::is_json($rawfetchedData['_identifier_'], true, true)
            ?
            : $rawfetchedData['_identifier_']
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function configureParameters(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setOptional(array('_'))
            ->setDefaults(array(
                '_identifier_' => function (Options $options) {
                    return $options['_'];
                },
            ))
            ->setRequired(array('_identifier_'));
    }
}