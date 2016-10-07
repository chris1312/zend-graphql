<?php

namespace ZendGraphQL\Controller;

use GraphQL\GraphQL;
use GraphQL\Schema;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class GraphQLController
 * @package ZendGraphQL\Controller
 */
class GraphQLController extends AbstractActionController
{

    /**
     * @var Schema
     */
    protected $schema;

    /**
     * GraphQLController constructor.
     * @param Schema $schema
     */
    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return JsonModel
     */
    public function indexAction()
    {
        $requestString = $this->params('query');
        $variableValues = json_decode($this->params('variables'), true);
        $operationName = $this->params('operation');

        try {
            $result = GraphQL::execute(
                $this->schema,
                $requestString,
                null,
                $variableValues,
                $operationName
            );
        } catch (\Exception $exception) {
            $result = [
                'errors' => [
                    ['message' => $exception->getMessage()]
                ]
            ];
        }


        return new JsonModel($result);
    }

}
