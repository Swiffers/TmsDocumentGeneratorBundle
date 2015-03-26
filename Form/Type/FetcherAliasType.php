<?php

namespace Tms\Bundle\DocumentGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tms\Bundle\DocumentGeneratorBundle\DataFetcher\DataFetcherRegistry;

class FetcherAliasType extends AbstractType
{
    /**
     * @var DataFetcherRegistry
     */
    protected $fetcherRegistry;

    /**
     * Constructor
     *
     * @param DataFetcherRegistry $fetcherRegistry
     */
    public function __construct(DataFetcherRegistry $fetcherRegistry)
    {
        $this->fetcherRegistry = $fetcherRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array_combine(
                $this->fetcherRegistry->getDataFetchersAlias(),
                $this->fetcherRegistry->getDataFetchersAlias()
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fetcher_alias';
    }
}