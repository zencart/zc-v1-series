<?php
/**
 * template_func Class.
 *
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott C Wilson 2022 Oct 16 Modified in v1.5.8a $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

/**
 * template_func Class.
 * This class is used to for template-override calculations
 *
 */
class template_func extends base
{
    public function get_template_part(string $page_directory, string $template_part, string $file_extension = '.php'): array
    {
        $pageLoader = Zencart\PageLoader\PageLoader::getInstance();
        return $pageLoader->getTemplatePart($page_directory, $template_part, $file_extension);
    }

    public function get_template_dir(string $template_code, string $current_template, string $current_page, string $template_dir): string
    {
        $pageLoader = Zencart\PageLoader\PageLoader::getInstance();
        return $pageLoader->getTemplateDirectory($template_code, $current_template, $current_page, $template_dir);
    }
}
