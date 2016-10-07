<?php

namespace ZendGraphQL\Resolver;

use GraphQL\Type\Definition\ResolveInfo;

/**
 * Interface ResolverInterface
 * @package ZendGraphQL\Resolver
 */
interface ResolverInterface
{

    /**
     * @param $object
     * @param array $args
     * @param $context
     * @param ResolveInfo $info
     * @return mixed
     */
    public function __invoke($object, array $args, $context, ResolveInfo $info);

}