<?php

/**
 * @license: MIT
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class HtmlConverterCompilerPass
 *
 * @package Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler
 */
class HtmlConverterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tms_document_generator.converter.registry')) {
            return;
        }

        $registryDefinition = $container->getDefinition('tms_document_generator.converter.registry');
        foreach ($container->findTaggedServiceIds('tms_document_generator.converter') as $id => $tags) {
            foreach ($tags as $attributes) {
                $alias = isset($attributes['alias'])
                    ? $attributes['alias']
                    : $id
                ;

                $registryDefinition->addMethodCall(
                    'setHtmlConverter',
                    array($alias, new Reference($id))
                );
            }
        }
    }
}