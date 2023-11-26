<?php declare(strict_types=1);

use App\Core\App;

?>
<div class="col justify-content-center h-100 mt-5">
    <div class="row d-flex h-100">
        <div class="col-2 border-end px-5">
            <ul class="row d-flex flex-column list-group">
                <li class="col list-group-item border-0">
                    <a href="<?php echo App::router()->uri('welcome') ?>"
                       style="text-decoration: none"
                    >
                        <span class="text-danger">Phone</span>
                        <span>Book</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col px-5">
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <h1 class="text-center">Topics</h1>
                </div>
            </div>
        </div>
    </div>
</div>