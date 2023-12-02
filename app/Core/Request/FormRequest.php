<?php

declare(strict_types=1);

namespace App\Core\Request;

use App\Core\App;
use App\Core\Exceptions\FailedValidationException;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class FormRequest
 *
 * @package App\Core\Request
 */
class FormRequest
{
    protected array $data = [];

    /**
     * @param Request $request
     * @throws Exception
     */
    public function __construct(
        protected Request $request
    ) {
        App::errorBag()->cleanAll();
        $this->setData();
        $this->validate();
    }

    /**
     * @return void
     */
    public function setData(): void
    {
        foreach ($this->rules() as $field => $rule) {
            $this->data[$field] = $this->post($field);
        }
    }

    /**
     * @return array
     */
    public function routeParameters(): array
    {
        return $this->request->route()->getParameters();
    }

    /**
     * @param string $parameterName
     * @return string|int
     */
    public function routeParameter(string $parameterName): string|int
    {
        return $this->request->route()->getParameter($parameterName);
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function post(?string $key = null): mixed
    {
        return $this->request->post($key);
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function get(?string $key = null): mixed
    {
        return $this->request->get($key);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function validate(): void
    {
        foreach ($this->rules() as $field => $rules) {
            foreach ($rules as $rule) {
                $this->handle($field, $this->request->post($field), $rule);
            }
        }

        try {
            if (App::errorBag()->hasErrors()) {
                throw new FailedValidationException('Validation failed');
            }
        } catch (FailedValidationException $e) {
            ValidationErrorHandler::handle($e);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param string $field
     * @param mixed $value
     * @param string|array $rule
     * @return void
     * @throws Exception
     */
    private function handle(string $field, mixed $value, string|array $rule): void
    {
        App::errorBag()->addOld($field, $value);

        if (! ($this->isValidString($rule) || $this->isValidArray($rule))) {
            throw new Exception("Invalid syntax in rules definition for field '$field'");
        }

        $ruleArgs = [];
        if (is_array($rule)) {
            $ruleName = array_key_first($rule);
            if (! $this->isValidString($ruleName)) {
                throw new Exception(
                    "Invalid syntax in rule name definition for field '$field'. "
                     . "Rule name must be a type of 'string'"
                );
            }

            $ruleArgs = $rule[$ruleName] ?? null;
            if (! $this->isValidArray($ruleArgs)) {
                throw new Exception(
                    "Invalid syntax in rules definition for field '$field'. "
                    . "Rule arguments must be not empty array"
                );
            }

            $rule = $ruleName;
        }

        /** @var Rule $ruleInstance */
        $ruleInstance = App::instance()->make($rule, ['data' => $this->data, 'args' => $ruleArgs]);
        $ruleInstance->handle($field, $value);
    }

    /**
     * @param mixed $str
     * @return bool
     */
    private function isValidString(mixed $str): bool
    {
        return is_string($str) && trim($str) !== '';
    }

    /**
     * @param mixed $arr
     * @return bool
     */
    private function isValidArray(mixed $arr): bool
    {
        return is_array($arr) && !empty($arr);
    }
}