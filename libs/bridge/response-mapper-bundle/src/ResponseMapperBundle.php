<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper;

use Local\Bridge\ResponseMapper\DependencyInjection\ResponseMapperExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class ResponseMapperBundle extends AbstractBundle
{
    public function getContainerExtension(): ResponseMapperExtension
    {
        return new ResponseMapperExtension();
    }
}
