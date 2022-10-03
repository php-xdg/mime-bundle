<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xdg\Mime\MimeDatabaseInterface;
use Xdg\MimeBundle\Tests\Integration\TestService;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(TestService::class)
        ->args([
            service(MimeDatabaseInterface::class),
        ])
        ->public()
    ;
};
