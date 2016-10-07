<?php

namespace ZendGraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZendGraphQL\Type\Exception\TypeFactoryException;

/**
 * Class TypeFactory
 * @package ZendGraphQL\Type
 */
class TypeFactory implements FactoryInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $typeConfig;

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @param string $name
     * @throws TypeFactoryException
     * @return ObjectType
     */
    public function getType(string $name) : ObjectType
    {
        if (!isset($this->typeConfig[$name])) {
            throw new TypeFactoryException();
        }

        if (!isset($this->types[$name])) {
            $this->types[$name] = $this->container->get($this->typeConfig[$name]);
        }

        return $this->types[$name];
    }

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return $this
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $this->typeConfig = $typeConfig = $this->getTypeConfig($container);
        $this->container = $container;

        return $this;
    }

    /**
     * @param ContainerInterface $container
     * @return array
     */
    protected function getTypeConfig(ContainerInterface $container) : array
    {
        $config = $container->get('config');

        return $config['graphql']['types'];
    }
}