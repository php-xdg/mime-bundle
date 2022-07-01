<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\DependencyInjection;

use ju1ius\XdgMime\MimeDatabaseGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class Ju1iusXdgMimeExtension extends Extension
{
    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration();
    }

    public function getNamespace(): string
    {
        return 'urn:ju1ius:xdg-mime-bundle:dic';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');

        $config = $this->processConfiguration(new Configuration(), $configs);
        $this->processCustomDatabase($container, $config['custom_database']);
    }

    private function processCustomDatabase(ContainerBuilder $container, array $config): void
    {
        if ($config['enabled']) {
            $container->getDefinition('ju1ius_xdg_mime.database')->setArguments([
                '%kernel.cache_dir%/xdg-mime',
            ]);
            $container->getDefinition('ju1ius_xdg_mime.cache_warmer')->setArguments([
                $this->createDatabaseGenerator($config['use_xdg_directories'], $config['paths']),
            ]);
        }
    }

    private function createDatabaseGenerator(bool $useXdgDirs, array $paths): Definition
    {
        return (new Definition(MimeDatabaseGenerator::class))
            ->addMethodCall('enablePlatformDependentOptimizations')
            ->addMethodCall('useXdgDirectories', [$useXdgDirs])
            ->addMethodCall('addCustomPaths', $paths)
        ;
    }
}
