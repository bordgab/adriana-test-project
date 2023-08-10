<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Infrastructure\Dbal\AbstractRepository;
use App\Infrastructure\Dbal\Exception\DriverException;
use App\Infrastructure\Dbal\Exception\QueryException;
use App\Infrastructure\Model\Customer;
use Doctrine\Common\Collections\ArrayCollection;

class CustomerRepository extends AbstractRepository
{
    /**
     * @return ArrayCollection<Customer>
     *
     * @throws DriverException;
     * @throws QueryException
     */
    public function getCustomers(): ArrayCollection
    {
        $result = $this->connection->executeSql('SELECT * FROM `client` ORDER BY `name`');

        return new ArrayCollection(\array_map(static fn(array $data) => Customer::fromArray($data), $result));
    }

    /**
     * @param Customer|array<Customer> $client
     *
     * @throws QueryException
     * @throws DriverException;
     */
    public function storeCustomer(Customer|array $client): void
    {
        $this->connection->beginTransaction();

        if (!\is_array($client)) {
            $client = [$client];
        }

        try {
            foreach ($client as $c) {
                $this->connection->executeSql(
                    'INSERT INTO `client` (`id`, `name`, `address`, `client_number`, `contract_date`)
                    VALUES (?, ?, ?, ?)',
                    [
                        $c->getId(),
                        $c->getName(),
                        $c->getAddress(),
                        $c->getCustomerNumber(),
                        $c->getContractDate()
                    ]
                );
            }

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * @throws QueryException
     * @throws DriverException;
     */
    public function updateCustomer(Customer $client): void
    {
        $this->connection->beginTransaction();

        try {
            $this->connection->executeSql(
                'UPDATE `client` SET
                `name` = ?, `address` = ?, `client_number` = ?, `contract_date` = ?
                WHERE `id` = ?',
                [
                    $client->getName(),
                    $client->getAddress(),
                    $client->getCustomerNumber(),
                    $client->getContractDate(),
                    $client->getId()
                ]
            );

            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollback();
            throw $e;
        }
    }
}
