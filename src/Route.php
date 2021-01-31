<?php
declare(strict_types=1);

namespace AFaller\Psr7RoutesBuilder;

class Route
{
    public const METHODS = [
        self::METHOD_GET,
        self::METHOD_POST,
        self::METHOD_PUT,
        self::METHOD_HEAD,
        self::METHOD_DELETE,
        self::METHOD_CONNECT,
        self::METHOD_OPTIONS,
        self::METHOD_TRACE,
        self::METHOD_PATCH,
    ];

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_HEAD = 'HEAD';
    public const METHOD_DELETE = 'DELETE';
    public const METHOD_CONNECT = 'CONNECT';
    public const METHOD_OPTIONS = 'OPTIONS';
    public const METHOD_TRACE = 'TRACE';
    public const METHOD_PATCH = 'PATCH';

    /** @var string */
    private $name;
    /** @var string */
    private $description;
    /** @var string */
    private $path;
    /** @var string */
    private $handlerClassName;
    /** @var string[] */
    private $methods = [];

    public function __construct(string $name, string $description, string $path, string $handlerClassName, array $methods)
    {
        $this->name = $name;
        $this->description = $description;
        $this->path = $path;
        $this->handlerClassName = $handlerClassName;

        foreach ($methods as $method) {
            if ($this->checkMethod($method)) {
                $this->methods[] = $method;
            }
        }
    }

    private function checkMethod($method): bool
    {
        return in_array($method, self::METHODS, true);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandlerClassName(): string
    {
        return $this->handlerClassName;
    }

    /**
     * @return array
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}