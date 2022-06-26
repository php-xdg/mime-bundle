<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Cache;

use ju1ius\XdgMime\XdgMimeDatabase;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

final class DefaultDatabaseWarmer implements CacheWarmerInterface
{
    public function isOptional(): bool
    {
        return false;
    }

    public function warmUp(string $cacheDir): array
    {
        $r = new \ReflectionClass(XdgMimeDatabase::class);
        $path = \dirname($r->getFileName());
        $files = glob("{$path}/Resources/db/*.php");

        return [
            XdgMimeDatabase::class,
            ...$files,
        ];
    }
}
