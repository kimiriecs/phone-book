<?php declare(strict_types=1);

use App\Core\App;
use App\Core\Helpers\Path;
use App\Core\Session\Session;
use Modules\User\DTO\Web\Pages\AuthFormPageDto;

/** @var AuthFormPageDto $pageDto */
?>
<div class="row justify-content-center mt-5">
    <div class="col-4">
        <h4 class="text-center">
            <?php echo $pageDto->isRegisterPage() ? 'Register' : 'Login' ?>
        </h4>
        <form action="<?php echo $pageDto->isRegisterPage()
            ? App::router()->uri('register')
            : App::router()->uri('login')
        ?>"
              method="POST"
              class="mt-5"
        >
            <input type="hidden" name="<?php echo Session::SESSION_CSRF_TOKEN_KEY ?>" value="<?php echo App::session()->getCsrf() ?>">
            <div class="mb-3 row d-flex">
                <div class="col-12">
                    <?php if ($pageDto->getAuthErrors()) { ?>
                        <div id="loginError>" class="form-text small text-danger">
                            <?php echo $pageDto->getAuthErrors()[0] ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col">
                    <label for="email" class="form-label row text-start mt-auto mb-0 col-5">Email address</label>
                    <input
                            name="email"
                            type="email"
                            class="form-control row rounded-0 border-0 border-bottom"
                            id="email"
                            value="<?php if ($pageDto->getOldEmail()) {
                                echo $pageDto->getOldEmail();
                            } ?>"
                    >
                    <?php if ($pageDto->getEmailErrors()) { ?>
                        <div id="emailError" class="form-text row small text-danger">
                            <?php echo $pageDto->getPasswordErrors()[0] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="mb-3 row d-flex mt-5">
                <div class="col">
                    <label for="password" class="form-label row text-start mt-auto mb-0 col-5">
                        Password
                    </label>
                    <div class="row border-bottom w-100">
                        <input
                                name="password"
                                type="password"
                                class="form-control col rounded-0 border-0"
                                id="password"
                                value="<?php if ($pageDto->getOldPassword()) {
                                    echo $pageDto->getOldPassword();
                                } ?>"
                        >
                        <?php include Path::views('components/auth/buttons/small/auth.show-password.small.button');?>
                    </div>
                    <?php if ($pageDto->getPasswordErrors()) { ?>
                        <div id="passwordError" class="form-text row small text-danger">
                            <?php echo $pageDto->getPasswordErrors()[0] ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php if ($pageDto->isRegisterPage()) { ?>
                <div class="mb-3 row d-flex mt-5">
                    <div class="col">
                        <label for="password_confirmation" class="form-label row text-start mt-auto mb-0 col-5">
                            Confirm Password
                        </label>
                        <div class="row border-bottom w-100">
                            <input
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control col rounded-0 border-0"
                                    id="password_confirmation"
                                    value="<?php if ($pageDto->getOldPasswordConfirmation()) {
                                        echo $pageDto->getOldPasswordConfirmation();
                                    } ?>"
                            >
                            <?php include Path::views('components/auth/buttons/small/auth.show-password-confirmation.small.button');?>
                        </div>
                        <?php if ($pageDto->getPasswordConfirmationErrors()) { ?>
                            <div id="passwordConfirmationError" class="form-text row small text-danger">
                                <?php echo $pageDto->getPasswordConfirmationErrors()[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="mb-3 form-check">
                <!--                <input type="checkbox" class="form-check-input" id="exampleCheck1">-->
                <!--                <label class="form-check-label" for="exampleCheck1">Check me out</label>-->
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-success">Submit</button>
                <a class="btn btn-outline-primary"
                   href="<?php echo $pageDto->isRegisterPage() ? '/login/show' : '/register/show' ?>"
                >
                    <?php echo $pageDto->isRegisterPage() ? 'Login' : 'Register' ?>
                </a>
            </div>
        </form>
    </div>
</div>

<?php include Path::views('components/auth/helpers/auth.show-password-js.script'); ?>