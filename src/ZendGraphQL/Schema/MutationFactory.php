<?php

namespace ZendGraphQL\Schema;

use GraphQL\Type\Definition\ObjectType;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZendGraphQL\Resolver\ControllerResolver;

/**
 * Class MutationFactory
 * @package ZendGraphQL\Schema
 */
class MutationFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ObjectType
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : ObjectType
    {
        $mutationConfig = $this->getMutationConfig($container);

        $mutationTypeConfig = [
            'name' => 'Mutation',
            'fields' => [],
        ];

        foreach ($mutationConfig['fields'] as $name => $field) {
            $mutationTypeConfig['fields'][$name] = $container->get($field['service']);
            if (!isset($mutationTypeConfig['fields'][$name]['resolve'])) {
                $mutationTypeConfig['fields'][$name]['resolve'] = $container->get($field['resolver']);
            }
        }

        $mutationType = new ObjectType($mutationTypeConfig);

        return $mutationType;
    }

    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    protected function getMutationConfig(ContainerInterface $container)
    {
        $config = $container->get('config');

        return $config['graphql']['mutation'];
    }
}