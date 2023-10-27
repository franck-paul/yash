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

use Dotclear\App;
use Dotclear\Helper\Html\Html;

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
                    $css = My::cssLoad('/syntaxhighlighter/css/shThemeDefault.css');
                } else {
                    $css = My::cssLoad('/syntaxhighlighter/css/shTheme' . $theme . '.css');
                }
            }

            echo
            My::cssLoad('/syntaxhighlighter/css/shCore.css') .
            $css;
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
            Html::jsJson('yash_config', [
                'path'   => App::blog()->getPF(My::id() . '/syntaxhighlighter/js/'),
                'gutter' => !(bool) $settings->hide_gutter,
            ]) .
            My::jsLoad('public.js');
        }

        return '';
    }
}
