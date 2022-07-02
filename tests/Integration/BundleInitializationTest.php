<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Integration;

use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Ju1iusXdgMimeBundle;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

final class BundleInitializationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->setTestProjectDir(__DIR__);
        $kernel->addTestBundle(Ju1iusXdgMimeBundle::class);
        $kernel->addTestConfig(__DIR__.'/fixtures/config/services.php');
        $kernel->handleOptions($options);
        //$kernel->setClearCacheAfterShutdown(false);

        return $kernel;
    }

    public function testDefaultConfig(): void
    {
        $kernel = self::bootKernel();
        $service = $kernel->getContainer()->get(TestService::class);
        Assert::assertInstanceOf(XdgMimeDatabase::class, $service->mimeDatabase);
        $type = $service->mimeDatabase->guessTypeByFileName('foo.txt');
        Assert::assertSame('text/plain', (string) $type);
    }

    public function testEmptyDatabase(): void
    {
        $kernel = self::bootKernel([
            'config' => fn (TestKernel $k) => $k->addTestConfig(__DIR__.'/fixtures/config/empty.yml'),
        ]);
        $service = $kernel->getContainer()->get(TestService::class);
        Assert::assertInstanceOf(XdgMimeDatabase::class, $service->mimeDatabase);
        $type = $service->mimeDatabase->guessTypeByFileName('foo.txt');
        Assert::assertSame('application/octet-stream', (string) $type);
    }
}
