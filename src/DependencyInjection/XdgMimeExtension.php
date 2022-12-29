<?php declare(strict_types=1);

namespace Xdg\MimeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileExistenceResource;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\Resource\GlobResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Xdg\BaseDirectory\XdgBaseDirectory;
use Xdg\Mime\MimeDatabaseGenerator;
use Xdg\Mime\Utils\XdgDataDirIterator;
use Xdg\Mime\XdgMimeDatabase;

final class XdgMimeExtension extends Extension
{
    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration();
    }

    public function getNamespace(): string
    {
        return 'urn:xdg:mime-bundle:dic';
    }

    public function getXsdValidationBasePath(): string
    {
        return \dirname(__DIR__).'/Resources/schema';
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.php');

        $config = $this->processConfiguration(new Configuration(), $configs);
        ['cache_prefix' => $cachePrefix, 'custom_database' => $customDatabase] = $config;

        $container->getDefinition('xdg_mime.database')->setArguments([
            sprintf('%s/%s', '%kernel.cache_dir%', $cachePrefix),
        ]);
        $container->getDefinition('xdg_mime.cache_warmer')->setArgument('$cachePrefix', $cachePrefix);

        if ($customDatabase['enabled'] ?? false) {
            $this->processCustomDatabase($container, $customDatabase);
        } else {
            $this->processDefaultDatabase($container);
        }
    }

    private function processCustomDatabase(ContainerBuilder $container, array $config): void
    {
        ['use_xdg_directories' => $useXdgDirs, 'paths' => $paths] = $config;
        $this->registerMimeInfoResources($container, $useXdgDirs, $paths);
        $container->getDefinition('xdg_mime.cache_warmer')->setArgument(
            '$generator',
            (new Definition(MimeDatabaseGenerator::class))
                ->addMethodCall('enablePlatformDependentOptimizations')
                ->addMethodCall('useXdgDirectories', [$useXdgDirs])
                ->addMethodCall('addCustomPaths', $paths),
        );
    }

    private function processDefaultDatabase(ContainerBuilder $container): void
    {
        $r = new \ReflectionClass(XdgMimeDatabase::class);
        $path = \dirname($r->getFileName());
        $mimeInfo = $path . '/Resources/mime-info';
        $container->addResource(new GlobResource($mimeInfo, '*.xml', false));
        $container->getDefinition('xdg_mime.cache_warmer')->setArgument(
            '$generator',
            (new Definition(MimeDatabaseGenerator::class))
                ->addMethodCall('enablePlatformDependentOptimizations')
                ->addMethodCall('useXdgDirectories', [false])
                ->addMethodCall('addCustomPaths', [$mimeInfo]),
        );
    }

    private function registerMimeInfoResources(ContainerBuilder $container, bool $useXdgDirs, array $paths): void
    {
        if ($useXdgDirs) {
            $dataDirs = XdgBaseDirectory::fromEnvironment()->collectDataPaths('mime/packages');
            $paths = [...$dataDirs, ...$paths];
        }

        foreach ($paths as $path) {
            $container->addResource(match (true) {
                is_dir($path) => new GlobResource($path, '*.xml', false),
                file_exists($path) => new FileResource($path),
                default => new FileExistenceResource($path),
            });
        }
    }
}
