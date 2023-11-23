<?php

declare(strict_types=1);

namespace App\Core\Commands;

/**
 * Class Command
 *
 * @package App\Core\Commands
 */
abstract class Command
{
    /**
     * @var string $name
     */
    protected string $name;

    /**
     * @var string $description
     */
    protected string $description;

    public function __construct()
    {
        $this->name = $this->name();
        $this->description = $this->description();
    }

    /**
     * @return mixed|void
     */
    abstract public function run(array $args);

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
    abstract public function name(): string;

    /**
     * @return string
     */
    abstract public function description(): string;
}