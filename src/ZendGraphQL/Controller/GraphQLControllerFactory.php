<?php

namespace ZendGraphQL\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class GraphQLControllerFactory
 * @package ZendGraphQL\Controller
 */
class GraphQLControllerFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return GraphQLController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new GraphQLController($container->get('ZendGraphQL\Schema'));

        return $controller;
    }

}

