<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests;

use ju1ius\XdgMimeBundle\DependencyInjection\Ju1iusXdgMimeExtension;
use ju1ius\XdgMimeBundle\Ju1iusXdgMimeBundle;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ju1iusXdgMimeBundleTest extends TestCase
{
    public function testGetName(): void
    {
        $bundle = new Ju1iusXdgMimeBundle();
        Assert::assertSame('Ju1iusXdgMime', $bundle->getName());
    }

    public function testGetPath(): void
    {
        $bundle = new Ju1iusXdgMimeBundle();
        Assert::assertSame(dirname(__DIR__), $bundle->getPath());
    }

    public function testGetNamespace(): void
    {
        $bundle = new Ju1iusXdgMimeBundle();
        Assert::assertSame('ju1ius\\XdgMimeBundle', $bundle->getNamespace());
    }

    public function testGetExtension(): void
    {
        $bundle = new Ju1iusXdgMimeBundle();
        Assert::assertInstanceOf(Ju1iusXdgMimeExtension::class, $bundle->getContainerExtension());
    }
}
