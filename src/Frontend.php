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
use Dotclear\Core\Process;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        $settings = My::settings();
        if (!(bool) $settings->active) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'publicHeadContent'   => FrontendBehaviors::publicHeadContent(...),
            'publicFooterContent' => FrontendBehaviors::publicFooterContent(...),
        ]);

        return true;
    }
}
