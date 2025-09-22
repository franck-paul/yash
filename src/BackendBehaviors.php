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

class BackendBehaviors
{
    public static function adminPostEditor(string $editor = ''): string
    {
        if ($editor !== 'dcLegacyEditor') {
            return '';
        }

        return
        App::backend()->page()->jsJson('dc_editor_yash', [
            'title'    => __('Highlighted Code'),
            'icon'     => urldecode(My::fileURL('/icon.svg')),
            'open_url' => urldecode(My::manageUrl(['popup' => 1], '&')),
        ]) .
        My::jsLoad('post.js');
    }
}
