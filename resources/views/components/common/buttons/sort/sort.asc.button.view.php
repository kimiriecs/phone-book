<?php declare(strict_types=1);

use App\Core\Helpers\Str;

?>
<label id="sort_label"
       for="<?php echo Str::snake($field) . '_desc' ?>"
       class="col-2 text-danger
        <?php echo Str::snake($field) . '_asc_label'; ?>
       <?php echo (isset($sort[Str::snake($field)]) && $sort[Str::snake($field)] === 'asc') ? '' : 'd-none' ?>"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
    </svg>
</label>

<input type="radio" name="<?php echo 'sort[' . Str::snake($field) . ']' ?>"
       value="asc"
       class="d-none"
       id="<?php echo Str::snake($field) . '_asc' ?>"
    <?php echo (isset($sort[Str::snake($field)]) && $sort[Str::snake($field)] === 'asc') ? "checked='checked'" : ''; ?>
>