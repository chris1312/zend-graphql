<?php

namespace ZendGraphQL\Schema;

use GraphQL\Type\Definition\ObjectType;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class QueryFactory
 * @package ZendGraphQL\Schema
 */
class QueryFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ObjectType
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : ObjectType
    {
        $queryConfig = $this->getQueryConfig($container);

        $queryTypeConfig = [
            'name' => 'Query',
            'fields' => [],
        ];

        foreach ($queryConfig['fields'] as $name => $field) {
            $queryTypeConfig['fields'][$name] = $container->get($field['service']);
            if (!isset($queryTypeConfig['fields'][$name]['resolve'])) {
                $queryTypeConfig['fields'][$name]['resolve'] = $container->get($field['resolver']);
            }
        }

        $queryType = new ObjectType($queryTypeConfig);

        return $queryType;
    }

    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    protected function getQueryConfig(ContainerInterface $container)
    {
        $config = $container->get('config');

        return $config['graphql']['query'];
    }
}