<?php
/**
 * @brief YASH, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Pep
 * @author Franck Paul
 *
 * @copyright Pep
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'YASH',
    'Yet Another Syntax Highlighter',
    'Pep and contributors',
    '5.1',
    [
        'requires'    => [['core', '2.28']],
        'permissions' => 'My',
        'priority'    => 1001, // Must be higher than dcLegacyEditor/dcCKEditor priority (ie 1000)
        'type'        => 'plugin',
        'settings'    => [
            'self' => '',
        ],

        'details'    => 'https://open-time.net/?q=yash',
        'support'    => 'https://github.com/franck-paul/yash',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/yash/master/dcstore.xml',
    ]
);
