<?php
declare(strict_types=1);

use App\Core\App;
use App\Core\Helpers\Path;
use App\Core\Helpers\Str;
use App\Core\Interfaces\DTO\EntityEditPageDtoInterface;
use App\Core\Session\Session;

/** @var EntityEditPageDtoInterface $pageDto */
$contactId = $pageDto->getFields()['id'] ?? null;
$isFavorite = $pageDto->getFields()['is_favorite'] ?? false;
$errors = $pageDto->getErrors();
$oldInput = $pageDto->getOldInput();
$readOnlyFields = [
    'id',
    'created_at',
];
$skipFields = [
    'user_id',
    'full_name',
    'is_favorite',
];
?>

    <div class="col">
        <div class="row mb-5 justify-content-end">
            <span class="col-3 badge fs-5 text-<?php echo $isFavorite ? 'success' : 'secondary' ?>">
                <?php echo $isFavorite ? 'Favorite' : 'Common' ?>
            </span>
        </div>
        <!-- Contact fields -->
        <form action="<?php echo App::router()->uri('contact.update', ['userId' => App::auth()->id(), 'contactId' => $contactId]) ?>"
              method="POST"
              class="row"
        >
            <input type="hidden"
                   class="d-none"
                   name="<?php echo Session::SESSION_CSRF_TOKEN_KEY ?>"
                   value="<?php echo App::session()->getCsrf() ?>">
            <input type="hidden" name="actual_method" value="PUT" class="d-none">
            <input type="checkbox"
                   name="is_favorite"
                   id="is_favorite"
                   class="d-none"
                <?php echo $isFavorite ? "checked='checked' value=true" : "value=false"; ?>
            >
            <input type="text"
                   name="user_id"
                   id="user_id"
                   class="d-none"
                   value="<?php echo App::auth()->id() ?>"
            >
            <div class="col-11">
                <?php foreach ($pageDto->getFields() as $field => $value) { ?>
                    <?php if (in_array($field, $skipFields)) { continue; } ?>
                    <div class="row mb-3 mt-auto align-items-baseline d-flex justify-content-between">
                        <label for="title" class="col-5 fw-bolder fs-5 border-bottom h5 mt-auto">
                            <?php echo ucfirst(Str::camel($field)) ?>
                        </label>
                        <input name="<?php echo $field ?>"
                               type="text"
                               class="col-5 fw-light fs-6 focus-ring focus-ring-light border-0 border-bottom h5 mt-auto"
                               id="<?php echo $field ?>"
                               value="<?php echo $oldInput[$field] ?? $value; ?>"
                            <?php echo in_array($field, $readOnlyFields)  ? 'readonly' : '';?>
                        >
                        <?php if (isset($errors[$field])) { ?>
                            <div id="titleError" class="form-text row small text-danger">
                                <?php echo $errors[$field][0] ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <!-- Actions buttons -->
                <div class="row mt-5 mb-3 d-flex justify-content-start">
                    <!-- Favorite|Unfavorite buttons -->
                    <div class="col-3 p-0" id="favorite_button_container">
                        <?php if ($isFavorite) { ?>
                            <?php include Path::views('components/contact/buttons/contact.unfavorite.button') ?>
                        <?php } else { ?>
                            <?php include Path::views('components/contact/buttons/contact.favorite.button') ?>
                        <?php } ?>
                    </div>
                    <!-- Save button -->
                    <div class="col-3">
                        <?php include Path::views('components/common/buttons/save.button') ?>
                    </div>
                </div>
        </form>
        <form action="<?php echo App::router()->uri('contact.delete',
            ['userId' => App::auth()->id(), 'contactId' => $contactId]) ?>"
              method="POST"
              class="row d-flex justify-content-end mb-5"
        >
            <input type="hidden"
                   name="<?php echo Session::SESSION_CSRF_TOKEN_KEY ?>"
                   value="<?php echo App::session()->getCsrf() ?>">
            <input class="d-none" type="hidden" name="actual_method" value="DELETE">
            <?php include Path::views('components/common/buttons/delete.button') ?>
        </form>
    </div>
<?php include Path::views('components/contact/helpers/contact.set-is-favorite-js.script'); ?>