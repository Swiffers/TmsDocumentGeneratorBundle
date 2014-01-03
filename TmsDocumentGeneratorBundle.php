<?php

/**
 *
 * @author:  TESSI Marketing <contact@tessi.fr>
 *
 */

namespace Tms\Bundle\DocumentGeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TmsDocumentGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
