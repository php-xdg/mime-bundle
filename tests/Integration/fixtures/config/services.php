<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use ju1ius\XdgMime\MimeDatabaseInterface;
use ju1ius\XdgMimeBundle\Tests\Integration\TestService;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(TestService::class)
        ->args([
            service(MimeDatabaseInterface::class),
        ])
        ->public()
    ;
};
