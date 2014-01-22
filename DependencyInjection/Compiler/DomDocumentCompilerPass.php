<?php

/**
 *
 * @author:  Gabriel BONDAZ <gabriel.bondaz@idci-consulting.fr>
 * @author:  Jean-Philippe <jp.chateau@trepia.fr>
 * @license: GPL
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class DomDocumentCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tms_document_generator.document')) {
            return;
        }

        $configuration = $container->getParameter('tms_document_generator.configuration');
        foreach ($configuration['formats'] as $format => $generatorServiceName) {
            $documentServiceId = sprintf(
                'tms_document_generator.document.%s',
                $format
            );

            $documentDefinition = new DefinitionDecorator('tms_document_generator.document');
            $documentDefinition->setAbstract(false);
            $documentDefinition->replaceArgument(0, new Reference($generatorServiceName));

            $container->setDefinition($documentServiceId, $documentDefinition);
        }
    }
}
