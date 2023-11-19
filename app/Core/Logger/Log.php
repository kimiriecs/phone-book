<?php declare(strict_types=1);

namespace App\Core\Logger;

use App\Core\Helpers\Config;
use App\Core\Helpers\Path;
use DateTimeZone;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

/**
 * Class Log
 *
 * @package App\Core\Logger
 */
class Log
{
    const DEFAULT_LOG_FILE_NAME = 'app';

    /**
     * @var Logger|null $logger
     */
    private ?Logger $logger = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function initialize(): void
    {
        if (!$this->logger) {
            $this->logger = new Logger($name ?? 'default');
        }

        $formatter = new CustomLineFormatter(Config::get('log.output'), Config::get('log.date_format'));
        $stream = new StreamHandler(Path::logsPath(self::DEFAULT_LOG_FILE_NAME), Level::Debug);
        $stream->setFormatter($formatter);
        $this->logger->pushHandler($stream)->setTimezone(new DateTimeZone(Config::get('app.timezone')));
    }

    /**
     * @return Logger|null
     */
    public function instance(): ?Logger
    {
        return $this->logger;
    }

    /**
     * @param string $log
     * @param array|null $context
     * @return void
     */
    public function error(string $log, ?array $context = []): void
    {
        $this->logger->error($log, $context);
    }

    /**
     * @param string $log
     * @param array|null $context
     * @return void
     */
    public function debug(string $log, ?array $context = []): void
    {
        $this->logger->debug($log, $context);
    }

    /**
     * @param string $log
     * @param array|null $context
     * @return void
     */
    public function info(string $log, ?array $context = []): void
    {
        $this->logger->info($log, $context);
    }
}