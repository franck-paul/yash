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
use dcPage;

class BackendBehaviors
{
    public static function adminPostEditor($editor = ''): string
    {
        if ($editor != 'dcLegacyEditor') {
            return '';
        }

        return
        dcPage::jsJson('dc_editor_yash', ['title' => __('Highlighted Code')]) .
        dcPage::jsModuleLoad(My::id() . '/js/post.js', dcCore::app()->getVersion(My::id()));
    }
}
