<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Unit\Cache;

use ju1ius\XdgMime\MimeDatabaseGeneratorInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class XdgMimeDatabaseCacheWarmerTest extends TestCase
{
    public function testItIsNotOptional(): void
    {
        $warmer = new XdgMimeDatabaseCacheWarmer(
            $this->createStub(MimeDatabaseGeneratorInterface::class),
        );
        Assert::assertFalse($warmer->isOptional());
    }

    public function testWarmUp(): void
    {
        $warmer = new XdgMimeDatabaseCacheWarmer(
            $this->createStub(MimeDatabaseGeneratorInterface::class),
        );
        $result = $warmer->warmUp('foo');
        Assert::assertContains(XdgMimeDatabase::class, $result);
    }
}
