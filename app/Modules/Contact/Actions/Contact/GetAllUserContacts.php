<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact;

use App\Core\App;
use App\Core\Entity\Entity;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;
use ReflectionException;

/**
 * Class GetAllUserContacts
 *
 * @package App\Modules\Contact\Actions\Contact
 */
class GetAllUserContacts
{
    /**
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(
        protected ContactRepositoryInterface $repository
    ) {
    }

    /**
     * @param array|null $filter
     * @param array|null $sort
     * @return Entity[]
     * @throws ReflectionException
     */
    public function execute(?array $filter = [], ?array $sort = []): array
    {
        return $this->repository->findAllUserContacts(App::auth()->id(), $filter, $sort);
    }
}