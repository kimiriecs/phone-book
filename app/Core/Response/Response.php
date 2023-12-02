<?php

declare(strict_types=1);

namespace App\Core\Response;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class Response
 *
 * @package App\Core\Response
 */
class Response
{
    /**
     * @param int $statusCode
     * @return void
     */
    #[NoReturn]
    public function abort(int $statusCode): void
    {
        header("Location: /$statusCode", true, $statusCode);
        exit();
    }

    /**
     * @param string $to
     * @param int $statusCode
     * @return void
     */
    #[NoReturn]
    public function redirect(string $to, int $statusCode = 302): void
    {
        header("Location: " . $to, true, $statusCode);
        exit();
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return void
     */
    #[NoReturn]
    public function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit();
    }
}