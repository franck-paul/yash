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

use dcUtils;
use Dotclear\App;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        $settings = My::settings();
        if ($settings->active) {
            $custom_css = $settings->custom_css;
            if (!empty($custom_css)) {
                if (str_starts_with((string) $custom_css, '/')) {
                    $css = $custom_css;
                } else {
                    $css = App::blog()->settings()->system->themes_url . '/' .
                    App::blog()->settings()->system->theme . '/' .
                        $custom_css;
                }
            } else {
                $theme = (string) $settings->theme;
                if ($theme === '') {
                    $css = App::blog()->getPF(My::id() . '/syntaxhighlighter/css/shThemeDefault.css');
                } else {
                    $css = App::blog()->getPF(My::id() . '/syntaxhighlighter/css/shTheme' . $theme . '.css');
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
        $settings = My::settings();
        if ($settings->active) {
            echo
            My::jsLoad('/syntaxhighlighter/js/shCore.js') .
            My::jsLoad('/syntaxhighlighter/js/shAutoloader.js') .
            dcUtils::jsJson('yash_config', [
                'path'   => App::blog()->getPF(My::id() . '/syntaxhighlighter/js/'),
                'gutter' => $settings->hide_gutter ? false : true,
            ]) .
            My::jsLoad('public.js');
        }

        return '';
    }
}
