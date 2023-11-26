<?php

declare(strict_types=1);

namespace Modules\Contact\Repositories;

use App\Core\Database\BaseRepository;
use App\Modules\Contact\Entities\Contact;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class ContactRepository
 *
 * @package Modules\Contact\Repositories
 */
class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Contact::class;
    }

    /**
     * @return string
     */
    public function getEntityTable(): string
    {
        return Contact::TABLE_NAME;
    }
}