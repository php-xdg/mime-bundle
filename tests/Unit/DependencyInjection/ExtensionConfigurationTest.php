<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Unit\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Xdg\MimeBundle\DependencyInjection\Configuration;
use Xdg\MimeBundle\DependencyInjection\XdgMimeExtension;

final class ExtensionConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    protected function getContainerExtension(): ExtensionInterface
    {
        return new XdgMimeExtension();
    }

    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }

    public function testDefaultConfig(): void
    {
        $expected = [
            'cache_prefix' => 'xdg-mime',
            'custom_database' => [
                'enabled' => false,
                'use_xdg_directories' => true,
                'paths' => [],
            ],
        ];
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/default.xml']);
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/default.yml']);
    }

    public function testDefaultCustom(): void
    {
        $expected = [
            'cache_prefix' => 'xdg-mime',
            'custom_database' => [
                'enabled' => true,
                'use_xdg_directories' => true,
                'paths' => [],
            ],
        ];
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/custom_default.xml']);
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/custom_default.yml']);
    }

    public function testCustomPaths(): void
    {
        $expected = [
            'cache_prefix' => 'xdg-mime',
            'custom_database' => [
                'enabled' => true,
                'use_xdg_directories' => false,
                'paths' => ['foo', 'bar'],
            ],
        ];
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/custom_paths.xml']);
        $this->assertProcessedConfigurationEquals($expected, [__DIR__.'/fixtures/custom_paths.yml']);
    }
}
