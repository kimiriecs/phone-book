<?php

declare(strict_types=1);

namespace App\Core\ServiceProvider;

use App\Core\App;
use App\Core\Database\BaseRepository;
use App\Core\Interfaces\RepositoryInterface;

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
    }
}