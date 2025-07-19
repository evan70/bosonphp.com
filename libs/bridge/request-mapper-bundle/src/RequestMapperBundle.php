<?php

declare(strict_types=1);

namespace Local\Bridge\RequestMapper;

use Local\Bridge\RequestMapper\DependencyInjection\RequestMapperExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class RequestMapperBundle extends AbstractBundle
{
    public function getContainerExtension(): RequestMapperExtension
    {
        return new RequestMapperExtension();
    }
}
