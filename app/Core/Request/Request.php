<?php

declare(strict_types=1);

namespace App\Core\Request;

use App\Core\Exceptions\InvalidUriException;
use App\Core\Helpers\Arr;
use App\Core\Session\Session;

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

    /**
     * @throws InvalidUriException
     */
    public function __construct()
    {
        $this->uri = $this->validateUri();
        $this->post = $this->satinize($_POST);
        $this->get = $this->satinize($_GET);
        Session::start();
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
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return Arr::get($key, $this->get);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function post(string $key): mixed
    {
        return Arr::get($key, $this->post);
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
        return Session::get(self::SESSION_PREVIOUS_URI_KEY);
    }

    /**
     * @return void
     */
    public function setPrevUri(): void
    {
        if (Session::get(self::SESSION_CURRENT_URI_KEY)) {
            Session::set(self::SESSION_PREVIOUS_URI_KEY, Session::get(self::SESSION_CURRENT_URI_KEY));
        }

        Session::set(self::SESSION_CURRENT_URI_KEY, $this->uri());
    }
}