<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Integration;

use Nyholm\BundleTest\TestKernel as BaseKernel;

final class TestKernel extends BaseKernel
{
    private string $testCachePrefix;

    public function __construct(string $environment, bool $debug)
    {
        parent::__construct($environment, $debug);
        $this->testCachePrefix = uniqid('cache', true);
    }

    public function getCacheDir(): string
    {
        return __DIR__ . '/tmp/' . $this->testCachePrefix;
    }

    public function getLogDir(): string
    {
        return __DIR__ . '/tmp/log';
    }
}
