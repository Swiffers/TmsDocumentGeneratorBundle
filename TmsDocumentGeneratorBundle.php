<?php

/**
 *
 * @author:  TESSI Marketing <contact@tessi.fr>
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tms\Bundle\DocumentGeneratorBundle\DependencyInjection\Compiler\DomDocumentCompilerPass;

class TmsDocumentGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DomDocumentCompilerPass());
    }
}
