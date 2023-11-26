<?php

declare(strict_types=1);

use App\Core\App;
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid px-5">
        <a class="navbar-brand" href="<?php echo App::router()->uri('welcome') ?>">
            <span class="text-danger">Phone</span>
            <span>Book</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100 mb-2 mb-lg-0 echo justify-content-between">
                <?php if (App::auth()->check()) {?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo App::router()->uri('dashboard', ['userId' => App::auth()->id()]) ?>">Dashboard</a>
                </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo App::router()->uri('topics') ?>">Topics</a>
                    </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false"
                    >
                        <?php if (!App::auth()->check()) { echo "Profile"; } else { echo App::auth()->user()->getEmail(); } ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (!App::auth()->check()) { ?>
                            <li><a class="dropdown-item" href="<?php echo App::router()->uri('login.show') ?>">Login</a></li>
                            <li><a class="dropdown-item" href="<?php echo App::router()->uri('register.show') ?>">Register</a></li>
                        <?php } else { ?>
                            <li><a class="dropdown-item" href="<?php echo App::router()->uri('logout') ?>">Logout</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>