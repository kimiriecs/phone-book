<?php declare(strict_types=1);

use App\Core\Helpers\Str;

?>
<label id="sort_label"
       for="<?php echo Str::snake($field) . '_asc' ?>"
       class="col-2 text-secondary
       <?php echo Str::snake($field) . '_default_label'; ?>
       <?php echo !isset($sort[Str::snake($field)]) ? '' : 'd-none' ?>"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-expand" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z"/>
    </svg>
</label>

<input type="radio" name="<?php echo 'sort[' . Str::snake($field) . ']' ?>"
       id="<?php echo Str::snake($field) . '_default' ?>"
       value="default"
       class="d-none defaultSort"
    <?php echo !isset($sort[Str::snake($field)]) ? "checked='checked'" : ''; ?>
>