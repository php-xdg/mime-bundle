<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Unit\DependencyInjection;

use ju1ius\XdgMime\MimeDatabaseInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use ju1ius\XdgMimeBundle\DependencyInjection\Configuration;
use ju1ius\XdgMimeBundle\DependencyInjection\Ju1iusXdgMimeExtension;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new Ju1iusXdgMimeExtension(),
        ];
    }

    public function testGetConfiguration(): void
    {
        $extension = new Ju1iusXdgMimeExtension();
        $builder = $this->createStub(ContainerBuilder::class);
        Assert::assertInstanceOf(Configuration::class, $extension->getConfiguration([], $builder));
    }

    public function testDefaultConfiguration(): void
    {
        $this->load([]);
        $this->assertDatabaseIsDefined();
        $this->assertMimeTypeGuesserIsDefined();
        $this->assertCacheWarmerIsDefined();
    }

    public function testCustomDatabase(): void
    {
        $this->load([
            'custom_database' => [
                'enabled' => true,
            ],
        ]);
        $this->assertDatabaseIsDefined(['%kernel.cache_dir%/xdg-mime']);
        $this->assertMimeTypeGuesserIsDefined();
        $this->assertCacheWarmerIsDefined();
    }

    public function testCustomDatabaseWithCustomPaths(): void
    {
        $this->load([
            'custom_database' => [
                'enabled' => true,
                'use_xdg_directories' => false,
                'paths' => ['/foo/bar'],
            ],
        ]);
        $this->assertDatabaseIsDefined(['%kernel.cache_dir%/xdg-mime']);
        $this->assertMimeTypeGuesserIsDefined();
        $this->assertCacheWarmerIsDefined();
    }

    private function assertDatabaseIsDefined(array $arguments = []): void
    {
        $id = 'ju1ius_xdg_mime.database';
        $this->assertContainerBuilderHasService($id, XdgMimeDatabase::class);
        $this->assertContainerBuilderHasAlias(MimeDatabaseInterface::class, $id);
        foreach ($arguments as $index => $value) {
            $this->assertContainerBuilderHasServiceDefinitionWithArgument($id, $index, $value);
        }
    }

    private function assertMimeTypeGuesserIsDefined(): void
    {
        $id = 'ju1ius_xdg_mime.guesser';
        $this->assertContainerBuilderHasService($id, XdgMimeTypeGuesser::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag($id, 'mime.mime_type_guesser');
    }

    private function assertCacheWarmerIsDefined(array $arguments = []): void
    {
        $id = 'ju1ius_xdg_mime.cache_warmer';
        $this->assertContainerBuilderHasService($id, XdgMimeDatabaseCacheWarmer::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag($id, 'kernel.cache_warmer');
        foreach ($arguments as $index => $value) {
            $this->assertContainerBuilderHasServiceDefinitionWithArgument($id, $index, $value);
        }
    }
}
