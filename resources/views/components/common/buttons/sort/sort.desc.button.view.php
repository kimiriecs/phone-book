<?php declare(strict_types=1);

use App\Core\Helpers\Str;

?>
<label id="sort_label"
       for="<?php echo Str::snake($field) . '_default' ?>"
       class="col-2 text-success
       <?php echo Str::snake($field) . '_desc_label'; ?>
       <?php echo (isset($sort[Str::snake($field)]) && $sort[Str::snake($field)] === 'desc') ? '' : 'd-none' ?>"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
    </svg>
</label>

<input type="radio" name="<?php echo 'sort[' . Str::snake($field) . ']' ?>"
       value="desc"
       class="d-none"
       id="<?php echo Str::snake($field) . '_desc' ?>"
    <?php echo (isset($sort[Str::snake($field)]) && $sort[Str::snake($field)] === 'desc') ? "checked='checked'" : ''; ?>
>