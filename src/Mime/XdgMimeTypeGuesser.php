<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Mime;

use Symfony\Component\Mime\MimeTypeGuesserInterface;
use Xdg\Mime\MimeDatabaseInterface;

final class XdgMimeTypeGuesser implements MimeTypeGuesserInterface
{
    public function __construct(
        private readonly MimeDatabaseInterface $mimeDatabase,
    ) {
    }

    public function isGuesserSupported(): bool
    {
        return true;
    }

    public function guessMimeType(string $path): ?string
    {
        return (string) $this->mimeDatabase->guessType($path);
    }
}
