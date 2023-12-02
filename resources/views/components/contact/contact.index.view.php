<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Helpers\Path;
use App\Core\Helpers\Str;
use App\Core\Interfaces\DTO\EntityIndexPageDtoInterface;
use App\Modules\Contact\Entities\Contact;

/**
 * @var EntityIndexPageDtoInterface $pageDto
 * @var array<Contact> $contacts
 */
$contacts = $pageDto->getEntities();

$onlyFields = [
    'id',
    'first_name',
    'last_name',
    'phone',
    'is_favorite',
];

$sort = App::request()->get('sort');

?>

<div class="col">
    <form id="sort_form" class="row"
      action="<?php App::router()->uri('contact.index', ['userId' => App::auth()->id()]) ?>" method="GET">
        <?php foreach ($pageDto->getFields() as $field) { ?>
            <?php if (in_array($field, $onlyFields)) { ?>
                <div class="<?php echo match($field ) {
                    'id' => 'col-1',
                    'phone' => 'col-3',
                    default => 'col-2'
                }; ?>">
                    <div class="row d-flex">
                        <div class="col h6 border-0 bg-body" style="font-weight: bold">
                        <span class="me-2">
                            <?php echo ucfirst(Str::camel($field)) ?>
                        </span>

                        <!--ASC Sort Button-->
                        <?php include Path::views('components/common/buttons/sort/sort.asc.button') ?>

                        <!--DESC Sort Button-->
                        <?php include Path::views('components/common/buttons/sort/sort.desc.button') ?>

                        <!--Default Sort Button-->
                        <?php include Path::views('components/common/buttons/sort/sort.default.button') ?>

                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <h5 class="col-2">
            <?php echo ucfirst('actions') ?>
        </h5>
        <div class="col-12">
            <div class="row d-flex justify-content-end d-none">
                <button type="submit" id="apply_sort_button" class="col-2 btn btn-sm btn-outline-success">
                    Apply sort
                </button>
            </div>
        </div>
    </form>
</div>
<?php if (count($contacts) > 0) { ?>
    <?php foreach ($contacts as $contact) { ?>
        <div id="<?php echo $contact->getId() ?>" class="row my-3 border-bottom">
            <?php if (in_array('id', $onlyFields)) { ?>
                <div class="col-1">
                    <span>
                        <?php echo $contact->getId() ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (in_array('user_id', $onlyFields)) { ?>
                <div class="col-2">
                    <span>
                        <?php echo $contact->getUserId() ?>
                    </span>
                </div>
            <?php } ?>

            <?php if (in_array('first_name', $onlyFields)) { ?>
                <div class="col-2">
                    <span>
                        <?php echo ucfirst($contact->getShortFirstName()) ?>
                    </span>
                </div>
                <?php } ?>
            <?php if (in_array('last_name', $onlyFields)) { ?>
                <div class="col-2">
                    <span>
                        <?php echo ucfirst($contact->getShortLastName()) ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (in_array('phone', $onlyFields)) { ?>
                <div class="col-3">
                    <span>
                        <?php echo $contact->getPhone() ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (in_array('email', $onlyFields)) { ?>
                <div class="col-2">
                    <span>
                        <?php echo $contact->getEmail() ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (in_array('is_favorite', $onlyFields)) { ?>
                <div class="col-2">
                    <span class="badge text-<?php echo $contact->isFavorite() ? 'success' : 'secondary' ?>">
                        <?php echo $contact->isFavorite() ? 'Favorite' : 'Common' ?>
                    </span>
                </div>
            <?php } ?>
            <?php if (in_array('createdAt', $onlyFields)) { ?>
                <div class="col-2">
                    <span>
                        <?php echo is_string($contact->getCreatedAt()) ? $contact->getCreatedAt() : $contact->getCreatedAt()->format('Y-m-d') ?>
                    </span>
                </div>
            <?php } ?>

            <!--Actions-->
            <div class="col-2">
                <div class="row d-flex justify-content-around">
                    <?php include Path::views('components/common/buttons/small/show.small.button');

                    //Auth Actions
                    if (App::auth()->check()) {
                        include Path::views('components/common/buttons/small/edit.small.button');

                        if ($contact->isFavorite()) {
                            include Path::views('components/contact/buttons/small/contact.unfavorite.small.button');
                        } else {
                            include Path::views('components/contact/buttons/small/contact.favorite.small.button');
                        }

                        include Path::views('components/common/buttons/small/delete.small.button');
                    } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (App::auth()->check()) { ?>
    <div class="row">
        <div class="col">
            <?php include Path::views('components/common/buttons/add.button'); ?>
        </div>
    </div>
<?php } ?>

<?php include Path::views('components/common/helpers/sort-js.script'); ?>
