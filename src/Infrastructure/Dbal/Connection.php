<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

use App\Infrastructure\Dbal\Exception\ConnectionException;
use App\Infrastructure\Dbal\Exception\DriverException;
use App\Infrastructure\Dbal\Exception\QueryException;

interface Connection
{
    /**
     * @throws ConnectionException
     */
    public function open(string $username, string $password): void;

    /**
     * @throws ConnectionException
     */
    public function close(): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;

    /**
     * @throws QueryException
     * @throws DriverException;
     */
    public function executeSql(string $sql, array $parameters): mixed;
}
