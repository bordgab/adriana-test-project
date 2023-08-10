#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use App\CustomerApi;
use App\Model\Customer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

(new SingleCommandApplication())
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        // setting up dependency injection
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
        $loader->load('services.yaml');

        $container->compile();

        $api = $container->get(CustomerApi::class);

        // retrieve customers
        $api->getCustomers();

        // store new customers
        $api->storeCustomer(new Customer('Gipsz Jakab', 'Miskolc', new \DateTime()));
        $api->storeCustomer([
                new Customer('Teszt Elek', 'Pécs', new \DateTime(), '1234-12'),
                new Customer('Csillag Virág', 'Szeged', new \DateTime(), '7777-77'),
        ]);

        return 0;
    })
    ->run()
;

