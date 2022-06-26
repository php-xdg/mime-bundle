<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle;

use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Cache\CustomDatabaseWarmer;
use ju1ius\XdgMimeBundle\Cache\DefaultDatabaseWarmer;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Mime\MimeTypeGuesserInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

final class Ju1iusXdgMimeBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->arrayNode('custom_database')
                    ->info('Use a custom XDG mime database instead of the built-in default.')
                    ->canBeEnabled()
                    ->children()
                        ->booleanNode('use_xdg_directories')
                            ->info('Adds mime-info XML files from the standard XDG data directories.')
                            ->defaultTrue()
                        ->end()
                        ->arrayNode('paths')
                            ->info('Adds custom mime-info files or directories.')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $services = $container->services();
        $db = $services->set('ju1ius_xdg_mime.database', XdgMimeDatabase::class);
        $db->alias(XdgMimeDatabase::class, 'ju1ius_xdg_mime.database');

        $custom = $config['custom_database'];
        if ($custom['enabled']) {
            $db->args(['%kernel.cache_dir%/xdg-mime']);
            $services
                ->set(CustomDatabaseWarmer::class)
                ->args([
                    $custom['use_xdg_directories'],
                    $custom['paths'],
                ])
                ->tag('kernel.cache_warmer')
            ;
        } else {
            $services
                ->set(DefaultDatabaseWarmer::class)
                ->tag('kernel.cache_warmer')
            ;
        }

        if ($builder::willBeAvailable('symfony/mime', MimeTypeGuesserInterface::class, [])) {
            $services
                ->set('ju1ius_xdg_mime.guesser', XdgMimeTypeGuesser::class)
                ->args([
                    service('ju1ius_xdg_mime.database'),
                ])
                ->tag('mime.mime_type_guesser')
                ->alias(XdgMimeTypeGuesser::class, 'ju1ius_xdg_mime.guesser')
            ;
        }
    }
}
