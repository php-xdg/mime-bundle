<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Unit;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Xdg\MimeBundle\DependencyInjection\XdgMimeExtension;
use Xdg\MimeBundle\XdgMimeBundle;

final class XdgMimeBundleTest extends TestCase
{
    public function testGetName(): void
    {
        $bundle = new XdgMimeBundle();
        Assert::assertSame('XdgMime', $bundle->getName());
    }

    public function testGetPath(): void
    {
        $bundle = new XdgMimeBundle();
        Assert::assertSame(\dirname(__DIR__, 2), $bundle->getPath());
    }

    public function testGetNamespace(): void
    {
        $bundle = new XdgMimeBundle();
        Assert::assertSame('Xdg\\MimeBundle', $bundle->getNamespace());
    }

    public function testGetExtension(): void
    {
        $bundle = new XdgMimeBundle();
        Assert::assertInstanceOf(XdgMimeExtension::class, $bundle->getContainerExtension());
    }
}
