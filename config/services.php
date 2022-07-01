<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;

return static function(ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set('ju1ius_xdg_mime.database', XdgMimeDatabase::class)
        ->alias(XdgMimeDatabase::class, 'ju1ius_xdg_mime.database')
    ;

    $services
        ->set('ju1ius_xdg_mime.cache_warmer', XdgMimeDatabaseCacheWarmer::class)
        ->tag('kernel.cache_warmer')
    ;

    $services
        ->set('ju1ius_xdg_mime.guesser', XdgMimeTypeGuesser::class)
        ->args([
            service('ju1ius_xdg_mime.database'),
        ])
        ->tag('mime.mime_type_guesser')
        ->alias(XdgMimeTypeGuesser::class, 'ju1ius_xdg_mime.guesser')
    ;
};
