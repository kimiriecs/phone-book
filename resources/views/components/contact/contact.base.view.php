<?php declare(strict_types=1);

use App\Core\App;
use App\Core\Helpers\Path;
use App\Core\Interfaces\DTO\BaseEntityPageDtoInterface;

/** @var BaseEntityPageDtoInterface $pageDto */
?>

<div class="col justify-content-center h-100 mt-5">
    <div class="row d-flex h-100">
        <div class="col-2 border-end px-5">
            <ul class="row d-flex flex-column list-group">
                <li class="col list-group-item border-0">
                    <a href="<?php echo App::router()->uri('contact.index', ['userId' => App::auth()->id()]) ?>"
                       style="text-decoration: none"
                    >
                        All contacts
                    </a>
                </li>
            </ul>
        </div>
        <div class="col px-5">
            <div class="row justify-content-center h-100">
                <?php include Path::views($pageDto->getPage())?>
            </div>
        </div>
    </div>
</div>