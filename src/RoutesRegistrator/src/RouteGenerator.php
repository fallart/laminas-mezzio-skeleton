<?php
declare(strict_types=1);

namespace RoutesRegistrator;

class RouteGenerator
{
    /** @var ConfigInterface */
    private $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function generate(string $handlerClassname): Route
    {
        $relativePath = $this->getRelativePath($handlerClassname);
        $elements = explode('\\', $relativePath);

        if (is_subclass_of($handlerClassname, AbstractHandler::class)) {
            $description = $handlerClassname::getDescription();
            $methods = $handlerClassname::getMethods();
        } else {
            $description = '';
            $methods = [Route::METHOD_GET];
        }

        return new Route(
            $this->getNameFromRelativePath($elements),
            $description,
            $this->getUrlPathFromRelativePath($elements),
            $handlerClassname,
            $methods
        );
    }

    private function getNameFromRelativePath(array $elements): string
    {
        foreach ($elements as $key => $element) {
            $elements[$key] = $this->camelToSnake($element);
        }

        return implode('.', $elements);
    }

    private function getUrlPathFromRelativePath(array $elements): string
    {
        $elements = $this->filterElements($elements);

        foreach ($elements as $key => $element) {
            $elements[$key] = $this->camelToUrl($element);
        }

        $uriPath = $this->config->getApiRoutesPrefix() . '/' . implode('/', $elements);
        $uriPath = rtrim($uriPath, '/');
        $uriPath .= '[/]';

        return $uriPath;
    }

    private function camelToSnake(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
    }

    private function camelToUrl(string $str): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $str));
    }

    private function filterElements(array $elements): array
    {
        foreach ($elements as $key => $element) {
            if ('index' === strtolower($element)) {
                unset($elements[$key]);
            }
        }

        return $elements;
    }

    /**
     * @param string $handlerClassname
     * @return string
     */
    public function getRelativePath(string $handlerClassname): string
    {
        $relativePath = str_replace($this->config->getNamespace(), '', $handlerClassname);
        $relativePath = str_replace('Handler', '', $relativePath);
        $relativePath = trim($relativePath, '\\');

        return $relativePath;
    }
}