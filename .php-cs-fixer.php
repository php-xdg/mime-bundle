<?php

$finder = \PhpCsFixer\Finder::create()
    ->exclude([
        __DIR__ . '/tests/Resources',
    ])
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/config',
        __DIR__ . '/tests',
    ])
;

$config = new \PhpCsFixer\Config();

return $config
    ->setCacheFile(__DIR__ . '/tools/.php-cs-fixer.cache')
    ->setRules([
        '@Symfony' => true,
        'linebreak_after_opening_tag' => false,
        'blank_line_after_opening_tag' => false,
        'native_function_invocation' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
