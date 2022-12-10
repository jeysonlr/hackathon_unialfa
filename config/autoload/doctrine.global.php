<?php

declare(strict_types=1);

use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'driverClass' => Driver::class,
                    'driverOptions' => array(PDO::ATTR_EMULATE_PREPARES => true),
                    'charset' => getenv("DB_CHARSET"),
                    'host' => getenv("DB_HOST"),
                    'port' => getenv("DB_PORT"),
                    'user' => getenv("DB_USER"),
                    'password' => getenv("DB_PASSWORD"),
                    'dbname' => getenv("DB_NAME"),
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => MappingDriverChain::class,
                'drivers' => [
                    'Academy\City\Entity' => 'city_entity',
                    'Academy\State\Entity' => 'state_entity',
                    'Academy\User\Entity' => 'user_entity',
                ],
            ],
            'city_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . './../../src/Academy/src/City/Entity'],
            ],
            'state_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . './../../src/Academy/src/State/Entity'],
            ],
            'user_entity' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . './../../src/Academy/src/User/Entity'],
            ],
        ],
    ],
];
