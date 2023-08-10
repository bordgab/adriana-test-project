<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

/**
 * For testing purposes only
 */
class DummyDriverManager implements DriverManager
{
    public function createConnection(string $dsn): Connection
    {
        return new DummyConnection();
    }
}