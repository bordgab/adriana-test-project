<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

/**
 * For testing purposes only
 */
class DummyConnection implements Connection
{

    public function open(string $username, string $password): void
    {
    }

    public function close(): void
    {
    }

    public function executeSql(string $sql, array $parameters = []): mixed
    {
        return [];
    }

    public function beginTransaction(): void
    {
    }

    public function commit(): void
    {
    }

    public function rollback(): void
    {
    }
}
