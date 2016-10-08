# Getting started

## 1. Installation

Install ZendGraphQL via composer

```bash
$ composer require willzyc/zend-graphql
```

Add the module to your application.config.php

```php
'modules' => array(
    'ZendGraphQL',
),
```

By default the route below is defined in module.config.php. You can overwrite it in your own module.config.php

```php
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
```

## 2. Creating queries and mutations

In this example we create a simple object type and query with a controller as the resolver.

At first we create the object type.

```php
<?php

// Choose your namespace, thats only my namespace structure
namespace MySite\GraphQL\ObjectType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use ZendGraphQL\Type\TypeFactory;

class User extends ObjectType
{

    public function __construct(TypeFactory $typeFactory)
    {
        parent::__construct([
            'name' => 'User',
            'description' => 'A user on my website',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'Id of the user',
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'Name of the user',
                ],
                'email' => [
                    'type' => Type::string(),
                    'description' => 'Email of the user',
                ],
                'myObjectType' => [
                    'type' => $typeFactory->getType('nameOfMyObjectType'),
                    'description' => 'This field contains my custom object type',
                ],
                'bestFriend' => [
                    'type' => $this, // If you want to use the object type itself set it to $this to avoid a circular dependency
                    'description' => 'Best friend of the user',
                ],
            ],
        ]);
    }

}
```

Now add this class to your service manager. The type factory will create one instance of it and provide it to other object types.
There is only one instance with the same name allowed in the GraphQL schema.

```php
'service_manager' => [
    'invokables' => [
        'MySite\GraphQL\ObjectType\User' => 'MySite\GraphQL\ObjectType\User',
    ],
],
```

After the object type we create a query. It is a factory which returns an array.

```php
<?php

namespace MySite\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $typeFactory = $this->getTypeFactory($container);

        $field = [
            'type' => $typeFactory->getType('User'), // The name of the object type
            'args' => [
                'id' => [
                    'name' => 'id',
                    'type' => Type::string(),
                    'description' => 'If omitted, it returns user by id',
                ],
                'name' => [
                    'name' => 'name',
                    'type' => Type::string(),
                    'description' => 'If omitted, it returns user by name',
                ],
                'email' => [
                    'name' => 'email',
                    'type' => Type::string(),
                    'description' => 'If omitted, it returns user by email',
                ],
            ],
            'resolve' => function() {
                // your resolve function
            }
        ];

        return $field;
    }

    /**
     * @param ContainerInterface $container
     * @return \ZendGraphQL\Type\TypeFactory
     */
    public function getTypeFactory(ContainerInterface $container)
    {
        $typeFactory = $container->get('ZendGraphQL\TypeFactory');

        return $typeFactory;
    }
}
```

And again add it to the service manager

```php
'factories' => [
    'MySite\GraphQL\Query\User' => 'MySite\GraphQL\Query\UserFactory',
],
```

In the last step you need to configure the GraphQL schema

```php
'service_manager' => [
    // ...
],

'graphql' => [
    'query' => [
        'fields' => [
            'user' => [
                'service' => 'MySite\GraphQL\Mutation\Register',
            ],
        ],
    ],
    'mutation' => [
        'fields' => [
            // the same as above
        ],
    ],
    'types' => [
        'User' => 'MySite\GraphQL\ObjectType\User',
    ],
],
```

Now you can query the user field.

For more information on GraphQL with PHP see: https://github.com/webonyx/graphql-php
