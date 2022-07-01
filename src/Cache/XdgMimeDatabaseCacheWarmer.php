<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Cache;

use ju1ius\XdgMime\MimeDatabaseGeneratorInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

final class XdgMimeDatabaseCacheWarmer implements CacheWarmerInterface
{
    public function __construct(
        private readonly ?MimeDatabaseGeneratorInterface $generator = null,
    ) {
    }

    public function isOptional(): bool
    {
        return false;
    }

    public function warmUp(string $cacheDir): array
    {
        if (!$this->generator) {
            return $this->warmUpDefault($cacheDir);
        }
        return $this->warmUpCustom($cacheDir);
    }

    public function warmUpDefault(string $cacheDir): array
    {
        $r = new \ReflectionClass(XdgMimeDatabase::class);
        $path = \dirname($r->getFileName());
        $files = glob("{$path}/Resources/db/*.php");

        return [
            XdgMimeDatabase::class,
            ...$files,
        ];
    }

    public function warmUpCustom(string $cacheDir): array
    {
        $this->generator->generate($outputDir = "{$cacheDir}/xdg-mime");
        $files = glob("{$outputDir}/*.php");

        return [
            XdgMimeDatabase::class,
            ...$files,
        ];
    }
}
