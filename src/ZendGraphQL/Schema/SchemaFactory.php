<?php

namespace ZendGraphQL\Schema;

use GraphQL\Schema;
use GraphQL\Type\Definition\Type;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class SchemaFactory
 * @package ZendGraphQL\Schema
 */
class SchemaFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Schema
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : Schema
    {
        $queryType = $this->getQueryType($container);
        $mutationType = $this->getMutationType($container);

        $schema = new Schema([
            $queryType,
            $mutationType
        ]);

        return $schema;
    }

    /**
     * @param ContainerInterface $container
     * @return \GraphQL\Type\Definition\Type
     */
    protected function getQueryType(ContainerInterface $container) : Type
    {
        return $container->get('ZendGraphQL\Schema\Query');
    }

    /**
     * @param ContainerInterface $container
     * @return \GraphQL\Type\Definition\Type
     */
    protected function getMutationType(ContainerInterface $container) : Type
    {
        return $container->get('ZendGraphQL\Schema\Mutation');
    }
}