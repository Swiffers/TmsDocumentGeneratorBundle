<?php

/**
 * @license MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DataFetcher;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tms\Bundle\DocumentGeneratorBundle\Entity\MergeTag;

use Tms\Bundle\DocumentGeneratorBundle\Exception\MissingGenerationParametersException;

/**
 * Class AbstractDataFetcher
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DataFetcher
 */
abstract class AbstractDataFetcher implements DataFetcherInterface
{
    /**
     * {@inheritDoc}
     */
    public function fetch(array $data, MergeTag $mergeTag)
    {
        //identifier.postfix
        $pattern = sprintf(
            "/^(%s)(\.(?<postfix>(.+)))?/",
            $mergeTag->getIdentifier()
        );

        /**
         * loop on data to search parameters(postfix).
         * if postfix is null, use placeholder '_' as parameter,
         * it will be immediately replaced by the default parameter of every fetcher.
         */
        $parameters = array();
        foreach ($data as $key => $value) {
            if (empty($key) || empty($value)) {
                continue;
            }
            if (preg_match($pattern, $key, $matches)) {
                if (isset($matches['postfix'])) {
                    $parameters[$matches['postfix']] = $value;
                } else {
                    $parameters['_'] = $value;
                }
            }
        }

        if (empty($parameters)) {
            throw new MissingGenerationParametersException();
        }

        $resolver = new OptionsResolver();
        $this->configureParameters($resolver);
        $resolvedParameters = $resolver->resolve($parameters);
        unset($resolvedParameters['_']);

        return $this->doFetch($resolvedParameters);
    }

    /**
     * Do fetch.
     *
     * @param  array $parameters
     *
     * @return array
     */
     abstract public function doFetch(array $parameters);

    /**
     * Configure parameters
     *
     * @param OptionsResolverInterface $resolver
     */
     abstract protected function configureParameters(OptionsResolverInterface $resolver);
}
