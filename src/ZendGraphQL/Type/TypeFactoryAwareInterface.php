<?php

namespace ZendGraphQL\Type;

/**
 * Interface TypeFactoryAwareInterface
 * @package ZendGraphQL\Type
 */
interface TypeFactoryAwareInterface
{

    /**
     * @param TypeFactory $typeFactory
     * @return mixed
     */
    public function setTypeFactory(TypeFactory $typeFactory);

    /**
     * @return TypeFactory
     */
    public function getTypeFactory() : TypeFactory;

}