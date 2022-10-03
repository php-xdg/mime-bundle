<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Unit\Cache;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Xdg\Mime\MimeDatabaseGeneratorInterface;
use Xdg\Mime\XdgMimeDatabase;
use Xdg\MimeBundle\Cache\XdgMimeDatabaseCacheWarmer;

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
