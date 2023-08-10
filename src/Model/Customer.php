<?php

declare(strict_types=1);

namespace App\Model;

class Customer
{
    protected string $id;

    public function __construct(
        protected readonly string $name,
        protected readonly string $address,
        protected readonly \DateTimeInterface $contractDate,
        protected readonly ?string $customerNumber = null
    ) {
        $this->id = \uniqid();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getContractDate(): \DateTimeInterface
    {
        return $this->contractDate;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    public static function fromArray(array $data): self
    {
        if (empty($data['contract_date'])) {
            throw new \InvalidArgumentException('Field "contract_date" cannot be empty.');
        }

        return new self(
            $data['name']??'',
            $data['address']??'',
            $data['contract_date'],
            $date['client_number']??null
        );
    }
}
