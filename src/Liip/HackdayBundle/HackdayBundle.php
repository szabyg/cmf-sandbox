<?php

namespace Liip\HackdayBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HackdayBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
