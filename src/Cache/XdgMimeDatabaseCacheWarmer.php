<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Cache;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Xdg\Mime\MimeDatabaseGeneratorInterface;
use Xdg\Mime\XdgMimeDatabase;

final class XdgMimeDatabaseCacheWarmer implements CacheWarmerInterface
{
    public function __construct(
        private readonly MimeDatabaseGeneratorInterface $generator,
        private readonly string $cachePrefix = 'xdg-mime',
    ) {
    }

    public function isOptional(): bool
    {
        return false;
    }

    public function warmUp(string $cacheDir): array
    {
        $cacheDir = sprintf('%s/%s', $cacheDir, $this->cachePrefix);
        $this->generator->generate($cacheDir);

        return [
            XdgMimeDatabase::class,
            ...glob("{$cacheDir}/*.php"),
        ];
    }
}
