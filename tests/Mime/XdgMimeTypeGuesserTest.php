<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Mime;

use ju1ius\XdgMime\MimeDatabaseInterface;
use ju1ius\XdgMime\MimeType;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class XdgMimeTypeGuesserTest extends TestCase
{
    public function testItIsAlwaysSupported(): void
    {
        $db = $this->createMock(MimeDatabaseInterface::class);
        $guesser = new XdgMimeTypeGuesser($db);
        Assert::assertTrue($guesser->isGuesserSupported());
    }

    public function testGuessMimeType(): void
    {
        $expectedType = 'foo/bar';

        $db = $this->createStub(MimeDatabaseInterface::class);
        $db->method('guessType')->willReturn(MimeType::of($expectedType));

        $guesser = new XdgMimeTypeGuesser($db);
        Assert::assertSame($expectedType, $guesser->guessMimeType('any'));
    }
}
