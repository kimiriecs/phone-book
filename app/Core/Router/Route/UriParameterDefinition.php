<?php

declare(strict_types=1);

namespace App\Core\Router\Route;

/**
 * Class RouteParameter
 *
 * @package App\Core\Router\Route
 */
class UriParameterDefinition
{
    /**
     * @param string $name
     * @param string $type
     * @param string $pattern
     * @param string $placeholderPattern
     */
    public function __construct(
        protected string $name,
        protected string $type,
        protected string $pattern,
        protected string $placeholderPattern,
    ) {
    }

    /**
     * @param array $data
     * @return UriParameterDefinition
     */
    public static function fromArray(array $data): UriParameterDefinition
    {
        $name = $data['name'] ?? null;
        $placeholder = $data['placeholder'] ?? null;

        return new static(
            name: self::getPreparedName($name),
            type: self::getPreparedType($placeholder),
            pattern: self::getPreparedPattern($name, $placeholder),
            placeholderPattern: self::getPreparedPlaceholderPattern($placeholder)
        );
    }

    /**
     * @param string $name
     * @return string|null
     */
    private static function getPreparedName(string $name): ?string
    {
        $name = trim($name);

        if (! $name) {
            return null;
        }

        return str_replace('-', '_', $name);
    }

    /**
     * @param string $placeholder
     * @return string|null
     */
    private static function getPreparedType(string $placeholder): ?string
    {
        $placeholder = trim($placeholder);

        if (! $placeholder) {
            return null;
        }

        $isSlug = str_ends_with(trim($placeholder), ':slug');

        return $isSlug ? 'string' : 'integer';
    }

    /**
     * @param string $name
     * @param string $placeholder
     * @return string|null
     */
    private static function getPreparedPattern(string $name, string $placeholder): ?string
    {
        $name = trim($name);
        $placeholder = trim($placeholder);

        if (! $name || ! $placeholder) {
            return null;
        }

        $isSlug = str_ends_with($placeholder, ':slug');

        return $isSlug ? "(?<$name>[-\w]+)" : "(?<$name>\d+)";
    }

    /**
     * @param string $placeholder
     * @return string|null
     */
    private static function getPreparedPlaceholderPattern(string $placeholder): ?string
    {
        $placeholder = trim($placeholder);

        if (! $placeholder) {
            return null;
        }

        return "/\{$placeholder}/";
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return string
     */
    public function getPlaceholderPattern(): string
    {
        return $this->placeholderPattern;
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $name
     * @param string $pattern
     * @return void
     */
    public function setPattern(string $name, string $pattern): void
    {
        $pattern = trim($pattern);
        if ($pattern === '') {
            return;
        }

        $this->pattern = "(?<$name>$pattern)";
    }
}