<?php
declare(strict_types=1);

namespace Api\Routes\Flights\StaticData\RtTable\RtSearch;

use RoutesRegistrator\AbstractHandler;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Handler extends AbstractHandler
{
    private ExampleMiddleware $exampleMiddleware;
    private SecondExampleMiddleware $secondExampleMiddleware;

    public function __construct(ExampleMiddleware $exampleMiddleware, SecondExampleMiddleware $secondExampleMiddleware)
    {
        $this->exampleMiddleware = $exampleMiddleware;
        $this->secondExampleMiddleware = $secondExampleMiddleware;
    }

    public function getPipe(): MiddlewareInterface
    {
        $pipe = new MiddlewarePipe();

        $pipe->pipe($this->exampleMiddleware);
        $pipe->pipe($this->secondExampleMiddleware);

        return $pipe;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'status' => self::class,
            'headers' => $request->getHeaders(),
        ]);
    }

    static function getDescription(): string
    {
        return 'Rt search route';
    }

    static function getMethods(): array
    {
        return ['GET', 'POST'];
    }
}