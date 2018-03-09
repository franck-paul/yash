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

if (!defined('DC_RC_PATH')) {return;}

$__autoload['yashBehaviors'] = dirname(__FILE__) . '/inc/yash.behaviors.php';

$core->addBehavior('coreInitWikiPost', array('yashBehaviors', 'coreInitWikiPost'));
