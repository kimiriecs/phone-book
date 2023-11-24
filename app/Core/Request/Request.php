<?php

declare(strict_types=1);

namespace App\Core\Request;

use App\Core\App;
use App\Core\Exceptions\InvalidUriException;
use App\Core\Helpers\Arr;
use App\Core\Router\Route\CurrentRoute;

/**
 * Class Request
 *
 * @package App\Core\Request
 */
class Request
{
    const SESSION_CURRENT_URI_KEY = 'current_uri';
    const SESSION_PREVIOUS_URI_KEY = 'previous_uri';

    public string $uri;
    public array $post;
    public array $get;
    public ?CurrentRoute $route = null;

    /**
     * @throws InvalidUriException
     */
    public function __construct()
    {
        $this->uri = $this->validateUri();
        $this->post = $this->satinize($_POST);
        $this->get = $this->satinize($_GET);
        $this->setPrevUri();
    }

    /**
     * @return string
     * @throws InvalidUriException
     */
    private function validateUri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
        $isValidUri = preg_match('/^(\/([\w\-]|\d)+)*\/?$/i', trim($uri));
        if (! $isValidUri) {
            throw new InvalidUriException("Provided uri has invalid format");
        }

        return $uri;
    }

    /**
     * @param array $data
     * @return array
     */
    private function satinize(array $data): array
    {
        $satinized = [];

        foreach ($data as $field => $value) {
            if (is_array($value)) {
                $value = $this->satinize($value);
                $satinized[$field] = $value;
            } else {
                $satinized[$field] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }

        return $satinized;
    }

    /**
     * @return bool
     */
    public function isXRH(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * @return string
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function query(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '';
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $_POST[HttpMethodEnum::SUB_METHOD_FIELD_NAME->value] ?? $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function get(?string $key = null): mixed
    {
        return $key ? Arr::get($key, $this->get) : $this->get;
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function post(?string $key = null): mixed
    {
        return $key ? Arr::get($key, $this->post) : $this->post;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $all[HttpMethodEnum::GET->value] = $this->get();
        $all[HttpMethodEnum::POST->value] = $this->post();

        return $all;
    }

    /**
     * @return string|null
     */
    public function prevUri(): ?string
    {
        return App::session()->get(self::SESSION_PREVIOUS_URI_KEY);
    }

    /**
     * @return CurrentRoute|null
     */
    public function route(): ?CurrentRoute
    {
        return $this->route;
    }

    /**
     * @return void
     */
    public function setPrevUri(): void
    {
        if (App::session()->get(self::SESSION_CURRENT_URI_KEY)) {
            App::session()->set(self::SESSION_PREVIOUS_URI_KEY, App::session()->get(self::SESSION_CURRENT_URI_KEY));
        }

        App::session()->set(self::SESSION_CURRENT_URI_KEY, $this->uri());
    }

    /**
     * @param CurrentRoute $route
     * @return void
     */
    public function setRoute(CurrentRoute $route): void
    {
        $this->route = $route;
    }
}