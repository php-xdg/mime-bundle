<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Xdg\Mime\MimeDatabaseInterface;
use Xdg\Mime\XdgMimeDatabase;
use Xdg\MimeBundle\Cache\XdgMimeDatabaseCacheWarmer;
use Xdg\MimeBundle\Mime\XdgMimeTypeGuesser;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services
        ->set('xdg_mime.database', XdgMimeDatabase::class)
        ->args([
            param('%kernel.cache_dir%').'/xdg-mime',
        ])
        ->alias(MimeDatabaseInterface::class, 'xdg_mime.database')
    ;

    $services
        ->set('xdg_mime.cache_warmer', XdgMimeDatabaseCacheWarmer::class)
        ->args([
            abstract_arg('Database generator.'),
            'xdg-mime',
        ])
        ->tag('kernel.cache_warmer')
    ;

    $services
        ->set('xdg_mime.guesser', XdgMimeTypeGuesser::class)
        ->args([
            service('xdg_mime.database'),
        ])
        ->tag('mime.mime_type_guesser')
    ;
};
