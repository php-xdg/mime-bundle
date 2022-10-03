<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Unit\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Xdg\MimeBundle\DependencyInjection\Configuration;

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
            'xdg_mime' => [
                'custom_database' => [
                    'use_xdg_directories' => false,
                ],
            ],
        ];
        $message = 'You must provide custom paths when not using standard XDG directories.';
        $this->assertConfigurationIsInvalid($config, $message);
    }
}
