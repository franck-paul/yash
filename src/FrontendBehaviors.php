<?php
/**
 * @brief yash, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\yash;

use dcCore;
use dcUtils;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        if (dcCore::app()->blog->settings->yash->active) {
            $custom_css = dcCore::app()->blog->settings->yash->custom_css;
            if (!empty($custom_css)) {
                if (str_starts_with((string) $custom_css, '/')) {
                    $css = $custom_css;
                } else {
                    $css = dcCore::app()->blog->settings->system->themes_url . '/' .
                    dcCore::app()->blog->settings->system->theme . '/' .
                        $custom_css;
                }
            } else {
                $theme = (string) dcCore::app()->blog->settings->yash->theme;
                if ($theme === '') {
                    $css = dcCore::app()->blog->getPF(My::id() . '/syntaxhighlighter/css/shThemeDefault.css');
                } else {
                    $css = dcCore::app()->blog->getPF(My::id() . '/syntaxhighlighter/css/shTheme' . $theme . '.css');
                }
            }
            echo
            My::cssLoad('/syntaxhighlighter/css/shCore.css') .
            dcUtils::cssLoad($css);
        }

        return '';
    }

    public static function publicFooterContent(): string
    {
        if (dcCore::app()->blog->settings->yash->active) {
            echo
            My::jsLoad('/syntaxhighlighter/js/shCore.js') .
            My::jsLoad('/syntaxhighlighter/js/shAutoloader.js') .
            dcUtils::jsJson('yash_config', [
                'path'   => dcCore::app()->blog->getPF(My::id() . '/syntaxhighlighter/js/'),
                'gutter' => dcCore::app()->blog->settings->yash->hide_gutter ? false : true,
            ]) .
            My::jsLoad('public.js');
        }

        return '';
    }
}
