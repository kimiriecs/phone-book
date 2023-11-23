<?php declare(strict_types=1);

namespace App\Core\View;

use App\Core\Helpers\Path;

/**
 * Class View
 *
 * @package App\Core\View
 */
class View
{
    public const TEMPLATE_FILE_EXTENSION = '.view.php';

    /**
     * @param string $template
     * @param array|null $args
     * @return void
     */
    public static function render(string $template, ?array $args = null): void
    {
        $viewContent = self::getTemplate($template, $args);
        self::sendToOutput($viewContent);
    }

    /**
     * @param string $viewContent
     * @return void
     */
    private static function sendToOutput(string $viewContent): void
    {
        echo $viewContent;
    }

    /**
     * @param string $template
     * @param array|null $args
     * @return string
     */
    private static function getTemplate(string $template, ?array $args = null): string
    {
        ob_start();
        if($args !== null) {
            extract($args, EXTR_SKIP);
        }
        require self::getFullTemplatePath($template);
        $view = ob_get_contents();
        ob_end_clean();

        return $view;
    }

    /**
     * @param string $template
     * @return string
     */
    private static function getFullTemplatePath(string $template): string
    {
        return Path::views($template);
    }
}