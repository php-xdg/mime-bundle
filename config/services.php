<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use ju1ius\XdgMime\MimeDatabaseInterface;
use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\DefaultDatabaseGenerator;
use ju1ius\XdgMimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services
        ->set('ju1ius_xdg_mime.database', XdgMimeDatabase::class)
        ->args([
            param('%kernel.cache_dir%').'/xdg-mime',
        ])
        ->alias(MimeDatabaseInterface::class, 'ju1ius_xdg_mime.database')
    ;

    $services
        ->set('ju1ius_xdg_mime.cache_warmer', XdgMimeDatabaseCacheWarmer::class)
        ->args([
            inline_service(DefaultDatabaseGenerator::class),
            'xdg-mime',
        ])
        ->tag('kernel.cache_warmer')
    ;

    $services
        ->set('ju1ius_xdg_mime.guesser', XdgMimeTypeGuesser::class)
        ->args([
            service('ju1ius_xdg_mime.database'),
        ])
        ->tag('mime.mime_type_guesser')
    ;
};
