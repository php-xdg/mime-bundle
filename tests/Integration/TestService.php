<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\Tests\Integration;

use ju1ius\XdgMime\MimeDatabaseInterface;

final class TestService
{
    public function __construct(
        public readonly MimeDatabaseInterface $mimeDatabase,
    ) {
    }
}
