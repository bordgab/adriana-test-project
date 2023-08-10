<?php

declare(strict_types=1);

namespace App\Infrastructure\Dbal;

use App\Infrastructure\Dbal\Exception\DatabaseException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Database
{
    private readonly int $maxConnections;
    private ArrayCollection $connections;

    public function __construct(array $options, private readonly DriverManager $driverManager)
    {
        $optionResolver = new OptionsResolver();
        $options = $optionResolver
            ->setRequired('max_connections')
            ->setAllowedTypes('max_connections', 'int')
            ->resolve($options)
        ;

        $this->maxConnections = $options['maxConnections'];
        $this->connections = new ArrayCollection();
    }

    /**
     * @throws DatabaseException
     */
    public function createConnection(string $dsn, string $username, string $password): Connection
    {
        if (0 !== $this->maxConnections
                && $this->maxConnections <= $this->connections->count()) {
            throw new DatabaseException(\sprintf('Maximum connections number exceeded, number of current connections is %d', $this->connections->count()));
        }

        $connection = $this->driverManager->createConnection($dsn);

        $connection->open($username, $password);

        $this->connections->set(\spl_object_id($connection), $connection);

        return $connection;
    }

    public function closeConnection(Connection $connection): void
    {
        $oid = \spl_object_id($connection);

        if ($this->connections->containsKey($oid)) {
            $this->connections->remove($oid);
        }

        $connection->close();
    }
}
