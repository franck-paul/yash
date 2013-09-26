<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of YASH, a plugin for DotClear2.
# Copyright (c) 2008 Pep and contributors. All rights
# reserved.
#
# This plugin is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This plugin is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this plugin; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****

if (!defined('DC_CONTEXT_ADMIN')) { return; }

// dead but useful code, in order to have translations
__('YASH').__('Yet Another Syntax Highlighter');

$_menu['Blog']->addItem(__('YASH'),'plugin.php?p=yash','index.php?pf=yash/icon.png',
		preg_match('/plugin.php\?p=yash(&.*)?$/',$_SERVER['REQUEST_URI']),
		$core->auth->check('contentadmin',$core->blog->id));

$core->addBehavior('adminPostHeaders',		array('yashBehaviors','postHeaders'));
$core->addBehavior('adminPageHeaders',		array('yashBehaviors','postHeaders'));
$core->addBehavior('adminRelatedHeaders',	array('yashBehaviors','postHeaders'));
$core->addBehavior('coreInitWikiPost',		array('yashBehaviors','coreInitWikiPost'));

class yashBehaviors
{
	public static function postHeaders()
	{
		return
		'<script type="text/javascript" src="index.php?pf=yash/post.js"></script>'.
		'<script type="text/javascript">'."\n".
		"//<![CDATA[\n".
		dcPage::jsVar('jsToolBar.prototype.elements.yash.title',__('Highlighted Code')).
		"\n//]]>\n".
		"</script>\n";
	}

	public static function coreInitWikiPost($wiki2xhtml)
	{
		$wiki2xhtml->registerFunction('macro:yash',array('yashBehaviors','transform'));
	}

	public static function transform($text,$args)
	{
		$text = trim($text);
		$real_args = explode(' ',$args);
		$class = empty($real_args[1])?'plain':$real_args[1];
		return '<pre class="brush: '.$class.'">'.htmlspecialchars($text).'</pre>';
	}
}
