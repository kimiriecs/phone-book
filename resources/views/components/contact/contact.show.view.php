<?php declare(strict_types=1);

use App\Core\App;
use App\Core\Helpers\Path;
use App\Core\Helpers\Str;
use App\Core\Interfaces\DTO\EntityShowPageDtoInterface;

/** @var EntityShowPageDtoInterface $pageDto */
?>
<div class="col-8">
    <!--Fields-->
    <?php foreach ($pageDto->getFields() as $field => $value) { ?>
        <?php if ($field === 'user_id' || $field === 'full_name') { continue; } ?>
        <div class="row mb-3 mt-auto align-items-baseline d-flex justify-content-between">
            <div class="col-5 fw-bolder fs-5 border-bottom h5 mt-auto">
                <?php echo ucfirst(Str::camel($field)) ?>
            </div>
            <div class="col-5 fw-light fs-6 border-bottom h5 mt-auto">
                <?php if ($field === 'is_favorite') { ?>
                    <span class="fs-6 fw-light text-<?php echo $value ? 'success' : 'secondary' ?>">
                        <?php if ($value) {
                            echo 'Favorite';
                        } else {
                            echo 'Common';
                        } ?>
                    </span>
                <?php } else { ?>
                    <?php echo $value ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <!--Action Buttons-->
    <?php if (App::auth()->check()) {?>
    <div class="row mt-5 d-flex justify-content-end">
        <div class="col-3">
            <?php include Path::views('components/common/buttons/edit.button') ?>
        </div>
    </div>
    <?php } ?>
</div>