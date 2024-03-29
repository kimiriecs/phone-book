<?php

declare(strict_types=1);

namespace App\Core\ServiceProvider;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\CommandRegister;
use App\Core\Database\BaseRepository;
use App\Core\Interfaces\RepositoryInterface;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;
use Modules\Contact\Repositories\ContactRepository;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use Modules\User\Repositories\UserRepository;

/**
 * Class ServiceProvider
 *
 * @package App\Core\ServiceProvider
 */
class ServiceProvider
{
    /**
     * @var App $app
     */
    protected App $app;

    /**
     * Initialize ServiceProvider
     */
    public function __construct()
    {
        $this->app = App::instance();
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
    }

    /**
     * @return void
     */
    public function registerCommands(): void
    {
        foreach (CommandRegister::list() as $commandClass) {
            /** @var Command $command */
            $command = $this->app->make($commandClass);
            $this->app->bind($command->getName(), $commandClass);
        }
    }
}