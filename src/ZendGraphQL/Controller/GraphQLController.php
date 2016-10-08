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
        $requestString = $this->params()->fromPost('query');
        $variableValues = json_decode($this->params()->fromPost('variables'), true);
        $operationName = $this->params()->fromPost('operation');

        $context = null;

        try {
            $result = GraphQL::execute(
                $this->schema,
                $requestString,
                null,
                $context,
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
