<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle;

use ju1ius\XdgMimeBundle\DependencyInjection\Ju1iusXdgMimeExtension;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

final class Ju1iusXdgMimeBundle implements BundleInterface
{
    use ContainerAwareTrait;

    public function getName(): string
    {
        return 'Ju1iusXdgMime';
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new Ju1iusXdgMimeExtension();
    }

    public function boot()
    {
    }

    public function shutdown()
    {
    }

    public function build(ContainerBuilder $container)
    {
    }
}
