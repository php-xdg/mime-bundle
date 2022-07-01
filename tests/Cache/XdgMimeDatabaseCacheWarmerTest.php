<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Cache;

use ju1ius\XdgMime\MimeDatabaseGeneratorInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class XdgMimeDatabaseCacheWarmerTest extends TestCase
{
    public function testItIsNotOptional(): void
    {
        $warmer = new XdgMimeDatabaseCacheWarmer();
        Assert::assertFalse($warmer->isOptional());
    }

    public function testWarmUpDefault(): void
    {
        $warmer = new XdgMimeDatabaseCacheWarmer();
        $result = $warmer->warmUp('foo');
        Assert::assertContains(XdgMimeDatabase::class, $result);
    }

    public function testWarmUpCustom(): void
    {
        $warmer = new XdgMimeDatabaseCacheWarmer(
            $this->createStub(MimeDatabaseGeneratorInterface::class),
        );
        $result = $warmer->warmUp('foo');
        Assert::assertContains(XdgMimeDatabase::class, $result);
    }
}
