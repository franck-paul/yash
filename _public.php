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

if (!defined('DC_RC_PATH')) { return; }

$core->addBehavior('publicHeadContent',		array('dcYASH','publicHeadContent'));
$core->addBehavior('publicFooterContent',	array('dcYASH','publicFooterContent'));

class dcYASH
{
	public static function publicHeadContent()
	{
		global $core;

		$core->blog->settings->addNamespace('yash');
		if ($core->blog->settings->yash->yash_active)
		{
			$custom_css = $core->blog->settings->yash->yash_custom_css;
			if (!empty($custom_css)) {
				if (strpos('/',$custom_css) === 0) {
					$css = $custom_css;
				}
				else {
					$css =
						$core->blog->settings->system->themes_url."/".
						$core->blog->settings->system->theme."/".
						$custom_css;
				}
			}
			else {
				$theme = (string)$core->blog->settings->yash->yash_theme;
				if ($theme == '') {
					$css = html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/css/shThemeDefault.css');
				} else {
					$css = html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/css/shTheme'.$theme.'.css');
				}
			}
			echo
				'<link rel="stylesheet" href="'
				.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/css/shCore.css').'" type="text/css" media="screen" />'."\n".
				'<link rel="stylesheet" href="'.$css.'" type="text/css" media="screen" />'."\n";
		}
	}

	public static function publicFooterContent()
	{
		global $core;

		$core->blog->settings->addNamespace('yash');
		if ($core->blog->settings->yash->yash_active)
		{
			echo
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shCore.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushAppleCript.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushAS3.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushBash.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushColdFusion.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushCpp.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushCSharp.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushCss.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushDelphi.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushDiff.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushErlang.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushGroovy.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushJava.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushJavaFX.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushJScript.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushPerl.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushPhp.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushPlain.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushPowerShell.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushPython.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushRuby.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushSass.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushScala.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushSql.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushVb.js').'"></script>'."\n".
				'<script type="text/javascript" src="'.html::stripHostURL($core->blog->getQmarkURL().'pf=yash/syntaxhighlighter/js/shBrushXml.js').'"></script>'."\n".
				'<script type="text/javascript">'."\n".
				"//<![CDATA[\n".
				'SyntaxHighlighter.all();'.
				"\n//]]>\n".
				"</script>\n";
		}
	}
}
