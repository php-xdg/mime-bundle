# xdg/mime-bundle

[![codecov](https://codecov.io/gh/php-xdg/mime-bundle/branch/main/graph/badge.svg?token=5YUK7ZFMYJ)](https://codecov.io/gh/php-xdg/mime-bundle)

Symfony integration for the [xdg/mime](https://github.com/php-xdg/mime) library.

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require xdg/mime-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require xdg/mime-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php
return [
    // ...
    Xdg\MimeBundle\XdgMimeBundle::class => ['all' => true],
];
```

## Usage

Read the [documentation](docs/index.md)
