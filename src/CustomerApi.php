<?php

declare(strict_types=1);

namespace App;

use App\Exception\ApiException;
use App\Infrastructure\Model\Customer;
use App\Infrastructure\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;

class CustomerApi
{
    public function __construct(private readonly CustomerRepository $repository)
    {
    }

    /**
     * @return ArrayCollection<Customer>
     */
    public function getCustomers(): ArrayCollection
    {
        try {
            return $this->repository->getCustomers();
        } catch (\App\Infrastructure\Dbal\Exception\RuntimeException $e) {
            throw new ApiException(\sprintf('Database error: %s', $e->getMessage()));
        } catch (\Throwable $e) {
            throw new ApiException(\sprintf('Unexpected error: %s', $e->getMessage()));
        }
    }

    /**
     * @param Customer|array<Customer> $customer
     *
     * @return void
     */
    public function storeCustomer(Customer|array $customer): void
    {
        if (!\is_array($customer)) {
            $customer = [$customer];
        }

        try {
            foreach ($customer as $c) {
                $this->repository->storeCustomer($customer);
            }
        } catch (\App\Infrastructure\Dbal\Exception\RuntimeException $e) {
            throw new ApiException(\sprintf('Database error: %s', $e->getMessage()));
        } catch (\Throwable $e) {
            throw new ApiException(\sprintf('Unexpected error: %s', $e->getMessage()));
        }
    }

    public function updateCustomer(Customer $customer): void
    {
        try {
            $this->repository->updateCustomer($customer);
        } catch (\App\Infrastructure\Dbal\Exception\RuntimeException $e) {
            throw new ApiException(\sprintf('Database error: %s', $e->getMessage()));
        } catch (\Throwable $e) {
            throw new ApiException(\sprintf('Unexpected error: %s', $e->getMessage()));
        }
    }
}
