<?php declare(strict_types=1);

use ju1ius\XdgMime\XdgMimeDatabase;
use ju1ius\XdgMimeBundle\Mime\XdgMimeTypeGuesser;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Stopwatch\Stopwatch;

require __DIR__ . '/../vendor/autoload.php';

$stopwatch = new Stopwatch(true);

$files = glob('/usr/bin/*');
$readableFiles = array_filter($files, fn($f) => is_file($f) && is_readable($f));
printf("Found %d files.\n", \count($readableFiles));

$mimeTypes = new MimeTypes();

$stopwatch->start('symfony-default');
foreach ($readableFiles as $file) {
    $mimeTypes->guessMimeType($file);
}
echo $stopwatch->stop('symfony-default'), "\n";

$mimeTypes = new MimeTypes();
$mimeTypes->registerGuesser(new FileinfoMimeTypeGuesser());

$stopwatch->start('symfony-finfo');
foreach ($readableFiles as $file) {
    $mimeTypes->guessMimeType($file);
}
echo $stopwatch->stop('symfony-finfo'), "\n";

$mimeTypes = new MimeTypes();
$mimeTypes->registerGuesser(new XdgMimeTypeGuesser(new XdgMimeDatabase()));

$stopwatch->start('xdg');
foreach ($readableFiles as $file) {
    $mimeTypes->guessMimeType($file);
}
echo $stopwatch->stop('xdg'), "\n";
