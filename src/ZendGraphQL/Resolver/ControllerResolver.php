<?php

namespace ZendGraphQL\Resolver;

use GraphQL\Type\Definition\ResolveInfo;
use Zend\Mvc\Controller\AbstractController;

/**
 * Class ControllerResolver
 * @package ZendGraphQL\Resolver
 */
class ControllerResolver implements ResolverInterface
{

    /**
     * @var AbstractController
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * ControllerResolver constructor.
     * @param AbstractController $controller
     * @param string $action
     */
    public function __construct(AbstractController $controller, string $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @param $object
     * @param array $args
     * @param $context
     * @param ResolveInfo $info
     * @return mixed
     */
    public function __invoke($object, array $args, $context, ResolveInfo $info)
    {
        return $this->controller->__call($this->action, $args);
    }

}