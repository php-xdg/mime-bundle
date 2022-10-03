<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Unit\Mime;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Xdg\Mime\MimeDatabaseInterface;
use Xdg\Mime\MimeType;
use Xdg\MimeBundle\Mime\XdgMimeTypeGuesser;

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
