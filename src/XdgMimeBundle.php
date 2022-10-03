<?php declare(strict_types=1);

namespace Xdg\MimeBundle;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Xdg\MimeBundle\DependencyInjection\XdgMimeExtension;

final class XdgMimeBundle implements BundleInterface
{
    use ContainerAwareTrait;

    public function getName(): string
    {
        return 'XdgMime';
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
        return new XdgMimeExtension();
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
