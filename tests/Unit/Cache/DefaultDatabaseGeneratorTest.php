<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Unit\Cache;

use ju1ius\XdgMimeBundle\Cache\DefaultDatabaseGenerator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

final class DefaultDatabaseGeneratorTest extends TestCase
{
    private const OUTPUT_DIRECTORY = __DIR__ . '/../tmp/db';

    protected function setUp(): void
    {
        $this->cleanupOutputDirectory();
    }

    protected function tearDown(): void
    {
        $this->cleanupOutputDirectory();
    }


    public function testGenerate(): void
    {
        $generator = new DefaultDatabaseGenerator();
        $generator->generate(self::OUTPUT_DIRECTORY);
        $files = glob(sprintf('%s/*.php', self::OUTPUT_DIRECTORY));
        Assert::assertNotEmpty($files);
    }

    private function cleanupOutputDirectory(): void
    {
        $fs = new Filesystem();
        if ($fs->exists(self::OUTPUT_DIRECTORY)) {
            $fs->remove(self::OUTPUT_DIRECTORY);
        }
    }
}
