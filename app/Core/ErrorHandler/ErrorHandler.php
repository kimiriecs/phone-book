<?php declare(strict_types=1);

namespace App\Core\ErrorHandler;

use App\Core\Helpers\Config;
use App\Core\Helpers\Env;
use App\Core\Helpers\Path;
use App\Core\Logger\CustomLineFormatter;
use DateTimeZone;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Throwable;

/**
 * Class ErrorHandler
 *
 * @package App\Core\ErrorHandler
 */
class ErrorHandler
{
    const DEFAULT_LOG_FILE_NAME = 'error';

    /**
     * @var Logger|null $logger
     */
    private static ?Logger $logger = null;

    /**
     * @return Logger
     */
    private static function getLogger(): Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger('error_handler');
            $formatter = new CustomLineFormatter(Config::get('log.output'), Config::get('log.date_format'));
            $stream = new StreamHandler(Path::logsPath(self::DEFAULT_LOG_FILE_NAME), Level::Debug);
            $stream->setFormatter($formatter);
            self::$logger->pushHandler($stream);

            try {
                self::$logger->setTimezone(new DateTimeZone(Config::get('app.timezone')));
            } catch (Throwable $e) {
                self::$logger->error($e->getMessage(), [$e->getTrace()]);
            }
        }

        return self::$logger;
    }

    /**
     * @param $errNumber
     * @param $errString
     * @param $errFile
     * @param $errLine
     * @return void
     * @throws Exception
     */
    #[NoReturn]
    public static function handleErrors($errNumber, $errString, $errFile, $errLine): void
    {
        $logMessage = "Error: [$errNumber] $errString - $errFile:$errLine";
        error_log($logMessage);

        self::getLogger()->error($logMessage);

        if (Env::getBoolean('APP_DEBUG') === true) {
            dd($logMessage);
        }

        header('HTTP/1.1 500 Internal Server Error');
        include 'fallback-error-page/server-error.view.php';
        exit();
    }

    /**
     * @param Throwable $exception
     * @return void
     */
    #[NoReturn]
    public static function handleExceptions(Throwable $exception): void
    {
        $logMessage = 'Uncaught Exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine();
        error_log($logMessage);

        self::getLogger()->error($exception->getMessage(), [$exception->getTrace()]);

        if (Env::getBoolean('APP_DEBUG') === true) {
            dd($exception->getMessage(), $exception->getTrace());
        }

        header('HTTP/1.1 503 Service Temporarily Unavailable');
        include 'fallback-error-page/unavailable-page.view.php';
        exit();
    }
}