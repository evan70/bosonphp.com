<?php

$bundles = [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Local\Bridge\HttpFactory\HttpFactoryBundle::class => ['all' => true],
    Local\Bridge\TypeLang\TypeLangBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Local\Bridge\RequestMapper\RequestMapperBundle::class => ['all' => true],
    Local\Bridge\ResponseMapper\ResponseMapperBundle::class => ['all' => true],
    Pentatrion\ViteBundle\PentatrionViteBundle::class => ['all' => true],
];

// Add dev/test bundles only if they exist
if (class_exists(Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class)) {
    $bundles[Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class] = ['dev' => true, 'test' => true];
}

if (class_exists(Symfony\Bundle\DebugBundle\DebugBundle::class)) {
    $bundles[Symfony\Bundle\DebugBundle\DebugBundle::class] = ['dev' => true];
}

if (class_exists(Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class)) {
    $bundles[Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class] = ['dev' => true, 'test' => true];
}

if (class_exists(FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle::class)) {
    $bundles[FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle::class] = ['test' => true];
}

return $bundles;
