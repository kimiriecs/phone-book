<?php

declare(strict_types=1);

namespace App\Core\Database\Migration;

use App\Core\Database\Actions\MakeQueryInTransaction;

/**
 * Class Migration
 *
 * @package App\Core\Database\Migration
 */
class Migration
{
    /**
     * @param MakeQueryInTransaction $query
     */
    public function __construct(
        protected MakeQueryInTransaction $query
    ) {
    }

    /**
     * @return void
     */
    public function run(): void
    {
        //
    }

    /**
     * @return void
     */
    public function back(): void
    {
        //
    }

    /**
     * @param string $query
     * @param array|null $values
     * @return bool
     */
    public function execute(string $query, ?array $values = []): bool
    {
        return $this->query->execute($query, $values);
    }
}