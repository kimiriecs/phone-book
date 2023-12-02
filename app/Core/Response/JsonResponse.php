<?php

declare(strict_types=1);

namespace App\Core\Response;

/**
 * Class JsonResponse
 *
 * @package App\Core\Response
 */
class JsonResponse
{
    /**
     * @var array|mixed $data
     */
    protected array $data;

    /**
     * @var int|mixed $status
     */
    protected int $status;

    /**
     * @param array|null $data
     * @param int|null $status
     */
    public function __construct(
        ?array $data = [],
        ?int $status = 200
    ) {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}