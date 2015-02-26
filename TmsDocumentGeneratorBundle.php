<?php

namespace Tms\Bundle\DocumentGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler\DataFetcherCompilerPass;
use Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler\HtmlConverterCompilerPass;

class TmsDocumentGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DataFetcherCompilerPass());
        $container->addCompilerPass(new HtmlConverterCompilerPass());
    }
}
