<?php

declare(strict_types=1);

namespace App\Core\Database\Seeder;

use App\Core\Database\Actions\MakeQueryInTransaction;

/**
 * Class Seeder
 *
 * @package App\Core\DB\Seeder
 */
class Seeder
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
     * @param string $query
     * @param array|null $values
     * @return bool
     */
    public function execute(string $query, ?array $values = []): bool
    {
        return $this->query->execute($query, $values);
    }
}