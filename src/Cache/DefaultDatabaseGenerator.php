<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Cache;

use ju1ius\XdgMime\MimeDatabaseGeneratorInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use Symfony\Component\Filesystem\Filesystem;

final class DefaultDatabaseGenerator implements MimeDatabaseGeneratorInterface
{
    public function generate(string $outputDirectory): void
    {
        $r = new \ReflectionClass(XdgMimeDatabase::class);
        $path = \dirname($r->getFileName());
        $fs = new Filesystem();
        $fs->mirror("{$path}/Resources/db", $outputDirectory, null, [
            'override' => true,
            'delete' => true,
        ]);
    }
}
