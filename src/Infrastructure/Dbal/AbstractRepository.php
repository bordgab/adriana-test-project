<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

abstract class AbstractRepository
{
    public function __construct(protected readonly Connection $connection)
    {
    }

    public static function create(Connection $connection): static
    {
        return new static($connection);
    }
}
