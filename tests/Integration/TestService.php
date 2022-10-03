<?php declare(strict_types=1);

namespace Xdg\MimeBundle\Tests\Integration;

use Xdg\Mime\MimeDatabaseInterface;

final class TestService
{
    public function __construct(
        public readonly MimeDatabaseInterface $mimeDatabase,
    ) {
    }
}
