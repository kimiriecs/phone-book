<?php

declare(strict_types=1);

namespace App\Core\Middleware;

/**
 * Class MiddlewareRegister
 *
 * @package App\Core\Middleware
 */
class MiddlewareRegister
{
    /**
     * @var string[] $commonMiddleware
     */
    private array $commonMiddleware = [];

    /**
     * @var string[] $webMiddleware
     */
    private array $webMiddleware = [];

    /**
     * @return string[]
     */
    public function getMiddleware(): array
    {
        return [
            ...$this->commonMiddleware,
            ...$this->webMiddleware
        ];
    }

    /**
     * @return string[]
     */
    public function getCommonMiddleware(): array
    {
        return $this->commonMiddleware;
    }

    /**
     * @return string[]
     */
    public function getWebMiddleware(): array
    {
        return $this->webMiddleware;
    }

    /**
     * @param array|string $middleware
     * @return void
     */
    public function addCommonMiddleware(array|string $middleware): void
    {
        if (is_array($middleware)) {
            foreach ($middleware as $item) {
                $this->commonMiddleware[] = $item;
            }
        } else {
            $this->commonMiddleware[] = $middleware;
        }
    }

    /**
     * @param array|string $middleware
     * @return void
     */
    public function addWebMiddleware(array|string $middleware): void
    {
        if (is_array($middleware)) {
            foreach ($middleware as $item) {
                $this->webMiddleware[] = $item;
            }
        } else {
            $this->webMiddleware[] = $middleware;
        }
    }
}