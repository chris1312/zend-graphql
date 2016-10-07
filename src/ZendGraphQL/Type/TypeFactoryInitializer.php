<?php

namespace ZendGraphQL\Type;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Initializer\InitializerInterface;

/**
 * Class TypeFactoryInitializer
 * @package ZendGraphQL\Type
 */
class TypeFactoryInitializer implements InitializerInterface
{

    /**
     * @param ContainerInterface $container
     * @param object $instance
     * @return void
     */
    public function __invoke(ContainerInterface $container, $instance)
    {
        if ($instance instanceof TypeFactoryAwareInterface) {
            $instance->setTypeFactory($container->get('ZendGraphQL\TypeFactory'));
        }
    }

}