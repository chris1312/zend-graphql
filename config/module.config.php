<?php

namespace ZendGraphQL;

return [

    'router' => [
        'routes' => [
            'ZendGraphQL' => [
                'type'    => 'Literal',
                'options' => [
                    'route' => '/graphql',
                    'defaults' => [
                        'controller' => 'ZendGraphQL\Controller\GraphQL',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            'ZendGraphQL\Controller\GraphQL' => 'ZendGraphQL\Controller\GraphQLControllerFactory',
        ],
    ],

    'service_manager' => [
        'factories' => [
            'ZendGraphQL\Schema' => 'ZendGraphQL\Schema\SchemaFactory',
            'ZendGraphQL\Schema\Query' => 'ZendGraphQL\Schema\QueryFactory',
            'ZendGraphQL\Schema\Mutation' => 'ZendGraphQL\Schema\MutationFactory',

            'ZendGraphQL\TypeFactory' => 'ZendGraphQL\Type\TypeFactory',
        ],
        'initializers' => [
            'ZendGraphQL\Type\TypeFactoryInitializer',
        ]
    ],
];

