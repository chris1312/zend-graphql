<?php

namespace ZendGraphQL\Schema;

use GraphQL\Type\Definition\ObjectType;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MutationFactory
 * @package ZendGraphQL\Schema
 */
abstract class AbstractFieldFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ObjectType
     */
    abstract public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : ObjectType;

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