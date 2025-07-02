<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang;

use Local\Bridge\TypeLang\DependencyInjection\TypeLangExtension;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class TypeLangBundle extends AbstractBundle
{
    public function getContainerExtension(): TypeLangExtension
    {
        return new TypeLangExtension();
    }
}
