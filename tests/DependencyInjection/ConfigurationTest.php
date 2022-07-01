<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\DependencyInjection;

use ju1ius\XdgMimeBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    public function testCustomPathsAreRequiredWhenNotUsingXdgDirectories(): void
    {
        $config = [
            'ju1ius_xdg_mime' => [
                'custom_database' => [
                    'use_xdg_directories' => false,
                ],
            ],
        ];
        $message = 'You must provide custom paths when not using standard XDG directories.';
        $this->assertConfigurationIsInvalid($config, $message);
    }
}
