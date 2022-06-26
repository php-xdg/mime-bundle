<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Cache;

use ju1ius\XdgMime\MimeDatabaseGenerator;
use ju1ius\XdgMime\XdgMimeDatabase;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

final class CustomDatabaseWarmer implements CacheWarmerInterface
{
    /**
     * @param string[] $paths
     */
    public function __construct(
        private readonly bool $useXdgDirectories,
        private readonly array $paths = [],
    ) {
    }

    public function isOptional(): bool
    {
        return false;
    }

    public function warmUp(string $cacheDir): array
    {
        $outputDir = "{$cacheDir}/xdg-mime";
        MimeDatabaseGenerator::new()
            ->useXdgDirectories($this->useXdgDirectories)
            ->addCustomPaths(...$this->paths)
            ->enablePlatformDependentOptimizations()
            ->generate($outputDir)
        ;
        $files = glob("{$outputDir}/*.php");

        return [
            XdgMimeDatabase::class,
            ...$files,
        ];
    }
}
