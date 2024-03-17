<?php

declare(strict_types = 1);

namespace Source\User\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Shared\Application\Controller;
use Source\Shared\CQRS\QueryBus\QueryBus;
use Source\User\Application\Query\CheckPasswordQuery;

class CheckPasswordController implements Controller
{
    private QueryBus $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $params = $request->getParams();
            $query = new CheckPasswordQuery($params['email'], $params['password']);
            $isValid = $this->queryBus->handle($query);
            $response->getBody()->write(json_encode(['is_valid' => $isValid]));
            return $response->withStatus(200);
        } catch (\Exception $e) {
            return $response->withStatus($e->getCode(), $e->getMessage());
        }
    }
}
