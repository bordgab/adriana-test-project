<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

interface DriverManager
{
    public function createConnection(string $dsn): Connection;
}

