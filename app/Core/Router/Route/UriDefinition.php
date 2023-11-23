<?php

declare(strict_types=1);

namespace App\Core\Router\Route;

/**
 * Class UriDefinition
 *
 * @package App\Core\Router\Route
 */
class UriDefinition
{
    const ROUTE_FULL_URI_REGEX_KEY = 'fullUri';
    const ROUTE_PLACEHOLDER_REGEX_KEY = 'placeholder';
    const ROUTE_PARAMETER_REGEX_KEY = 'parameter';

    /**
     * @var string $fullUriRegex
     */
    protected string $fullUriRegex;

    /**
     * @var array $parametersDefinitions
     */
    protected array $parametersDefinitions = [];

    /**
     * @param string $uriMask
     */
    public function __construct(
        protected string $uriMask
    ) {
        $this->setUriParametersDefinition();
        $this->setFullUriRegex();
    }

    /**
     * @param string $uriMask
     * @return static
     */
    public static function fromMask(string $uriMask): static
    {
        return new static(
            uriMask: str_starts_with($uriMask, "/") ? $uriMask : "/$uriMask"
        );
    }

    /**
     * @return string
     */
    public function getUriMask(): string
    {
        return $this->uriMask;
    }

    /**
     * @return string
     */
    public function getFullUriRegex(): string
    {
        return $this->fullUriRegex;
    }

    /**
     * @return array
     */
    public function getParametersDefinitions(): array
    {
        return $this->parametersDefinitions;
    }

    /**
     * @return void
     */
    private function setUriParametersDefinition(): void
    {
        $parameterKey = self::ROUTE_PARAMETER_REGEX_KEY;
        $placeholderKey = self::ROUTE_PLACEHOLDER_REGEX_KEY;
        $pattern = "#\{(?<$placeholderKey>((?<$parameterKey>[-\w]+)(:slug)?))}#i";
        preg_match_all($pattern, $this->uriMask, $matches);
        $urlParametersMap = array_combine($matches[$parameterKey], $matches[$placeholderKey]);

        if (! empty($urlParametersMap)) {
            foreach ($urlParametersMap as $name => $placeholder) {
                $parameter = UriParameterDefinition::fromArray([
                    'name' => $name,
                    'placeholder' => $placeholder,
                ]);

                $this->parametersDefinitions[] = $parameter;
            }
        }

    }

    /**
     * @return void
     */
    private function setFullUriRegex(): void
    {
        $patterns = array_map(function (UriParameterDefinition $parameter) {
            return $parameter->getPlaceholderPattern();
        }, $this->parametersDefinitions);

        $replacements = array_map(function (UriParameterDefinition $parameter) {
            return $parameter->getPattern();
        }, $this->parametersDefinitions);

        $fullUriRegex = preg_replace($patterns, $replacements, $this->uriMask);
        $fullUriRegexKey = self::ROUTE_FULL_URI_REGEX_KEY;

        $this->fullUriRegex = "#^(?<$fullUriRegexKey>$fullUriRegex)$#";
    }
}