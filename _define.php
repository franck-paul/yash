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
    '7.5',
    [
        'date'        => '2025-12-12T12:53:21+0100',
        'requires'    => [['core', '2.37']],
        'permissions' => 'My',
        'priority'    => 1010,  // Must be higher than dcLegacyEditor/dcCKEditor priority (ie 1000)
        'type'        => 'plugin',
        'settings'    => [
            'self' => '',
        ],

        'details'    => 'https://open-time.net/?q=yash',
        'support'    => 'https://github.com/franck-paul/yash',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/yash/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
